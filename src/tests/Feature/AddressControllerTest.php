<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function user_can_view_edit_address_page()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->get(route('purchase.edit.address', ['item_id' => $item->id]))
            ->assertStatus(200)
            ->assertViewIs('address')
            ->assertViewHasAll(['item' => $item, 'address' => $address]);
    }

    /** @test */
    public function user_can_update_address()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'postcode' => '1234567',
            'address' => 'Initial address',
            'building' => 'Initial building'
        ]);

        $updatedData = [
            'postcode' => '9998887',
            'address' => 'New street, Example',
            'building' => 'Building 10'
        ];

        $this->put(route('purchase.update.address', ['item_id' => $item->id]), $updatedData)
            ->assertRedirect(route('purchase.show', ['item_id' => $item->id]));

        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'postcode' => '9998887',
            'address' => 'New street, Example',
            'building' => 'Building 10'
        ]);
    }
}
