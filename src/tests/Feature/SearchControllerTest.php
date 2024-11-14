<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testResultSearchWithFactoryData()
    {
        // テスト用のユーザーとアイテムをファクトリーで作成
        $user = User::factory()->create();
        $items = Item::factory()->count(3)->create(['name' => 'example']);

        $this->actingAs($user);

        $response = $this->get('/search', ['keyword' => 'example']);

        $response->assertStatus(200);
        $response->assertViewIs('top_page');
        $response->assertViewHas('items', function ($view_items) use ($items) {
            return $items->pluck('id')->all() === $view_items->pluck('id')->all();
        });
    }

    public function testResultSearchAsGuest()
    {
        // テスト用のアイテムをファクトリーで作成
        $items = Item::factory()->count(3)->create(['name' => 'example']);

        // ゲストユーザーとして検索結果ページにアクセス
        $response = $this->get('/search', ['keyword' => 'example']);

        // ゲスト用のビューが使用されていることを確認
        $response->assertStatus(200);
        $response->assertViewIs('guest.top_page');
        $response->assertViewHas('items', function ($view_items) use ($items) {
            return $items->pluck('id')->all() === $view_items->pluck('id')->all();
        });
    }
}
