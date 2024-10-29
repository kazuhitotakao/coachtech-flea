<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_fetch_the_address_for_a_given_user_id()
    {
        $user = User::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);

        $fetchedAddress = Address::getUserAddress($user->id);

        $this->assertInstanceOf(Address::class, $fetchedAddress);
        $this->assertEquals($user->id, $fetchedAddress->user_id);
    }

    /** @test */
    public function it_formats_the_postal_code_correctly()
    {
        $address = new Address(['postcode' => '1234567']);
        $formatted = $address->getFormattedPostalCode();

        $this->assertEquals('〒123-4567', $formatted);
    }

    /** @test */
    public function user_relationship_is_correct()
    {
        $user = User::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $address->user);
        $this->assertEquals($user->id, $address->user->id);
    }
}
