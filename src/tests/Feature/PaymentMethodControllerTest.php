<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Item;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentMethodControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $paymentMethod;
    protected $item;
    protected $address;

    public function setUp(): void
    {
        parent::setUp();
        // ダミーデータの作成
        $this->user = User::factory()->create();
        $this->paymentMethod = PaymentMethod::factory()->create();
        $this->item = Item::factory()->create();
        $this->address = Address::factory()->create(['user_id' => $this->user->id]);

        // ユーザーを認証
        $this->actingAs($this->user);
    }

    public function testShowPaymentMethod()
    {
        $response = $this->get(route('payment_method.show', ['item_id' => $this->item->id]));
        $response->assertStatus(200);
        $response->assertViewIs('payment_method');
    }

    public function testUpdatePaymentMethod()
    {
        $response = $this->post(route('payment_method.update', [
            'item_id' => $this->item->id,
            'payment_method_id' => $this->paymentMethod->id
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('purchase');
        $response->assertSessionHas('payment_method_id', $this->paymentMethod->id);
    }
}
