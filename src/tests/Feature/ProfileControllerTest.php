<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $address;

    public function setUp(): void
    {
        parent::setUp();
        // テストユーザーと住所の生成
        $this->user = User::factory()->create();
        $this->address = Address::factory()->create(['user_id' => $this->user->id]);

        // ユーザーを認証
        $this->actingAs($this->user);
    }

    public function testEdit()
    {
        $response = $this->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('profile');
        $response->assertViewHasAll(['user', 'address', 'image_urls', 'image_url_thumbnail']);
    }

    public function testUpdate()
    {
        $new_name = 'Updated Name';
        $new_address = 'Updated Address';
        $new_postcode = '9999999';
        $new_building = 'Updated Building';

        $response = $this->put(route('profile.update'), [
            'user_name' => $new_name,
            'thumbnail_id' => null, // サムネイルIDは変更しない場合
            'postcode' => $new_postcode,
            'address' => $new_address,
            'building' => $new_building,
        ]);

        $response->assertRedirect('/my-page/listed');
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => $new_name
        ]);
        $this->assertDatabaseHas('addresses', [
            'user_id' => $this->user->id,
            'postcode' => $new_postcode,
            'address' => $new_address,
            'building' => $new_building
        ]);
    }
}
