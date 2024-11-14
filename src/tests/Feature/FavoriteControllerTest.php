<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreFavorite()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('like', ['item_id' => $item->id]));

        // リダイレクト確認
        $response->assertRedirect();

        // データベースにお気に入りが存在するか確認
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);
    }

    public function testDeleteFavorite()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // お気に入りを追加
        $user->favorites()->attach($item->id);

        $response = $this->actingAs($user)->post(route('unlike', ['item_id' => $item->id]));

        // リダイレクト確認
        $response->assertRedirect();

        // データベースからお気に入りが削除されているか確認
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);
    }
}
