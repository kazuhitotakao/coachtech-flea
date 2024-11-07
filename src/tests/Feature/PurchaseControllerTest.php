<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Item;
use App\Models\PaymentDetail;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class PurchaseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowPurchase()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->withSession([
            'payment_method_id' => '1',
            'payment_method_name' => 'Credit Card',
            'payment_detail_id' => '1',
        ]);

        $response = $this->get(route('purchase.show', ['item_id' => $item->id]));

        $response->assertStatus(200);
        $response->assertViewIs('purchase');
        $response->assertViewHasAll([
            'item' => $item,
            'image_url_thumbnail' => $item->getThumbnailUrl(),
            'payment_detail_id',
            'payment_method_id',
            'payment_method_name',
            'paid_price',
            'paid_price_format',
            'address',
            'address_id',
        ]);
    }

    public function testPurchase()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create(['user_id' => $seller->id]);
        $address = Address::factory()->create(['user_id' => $user->id]);
        $payment_detail = PaymentDetail::factory()->create();

        $this->actingAs($user);
        $response = $this->post(route('item.purchase', ['item_id' => $item->id]), [
            'item_id' => $item->id,
            'payment_detail_id' => $payment_detail->id,
            'paid_price' => 1000,
            'address_id' => $address->id,
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'buyer_id' => $user->id,
            'seller_id' => $item->user_id,
            'paid_price' => '1000.00',
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'status' => 'sold',
        ]);
    }
}
