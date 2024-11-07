<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MyListControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexMethodReturnsViewWithItems()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        // テスト用のアイテムをデータベースに作成
        $items = Item::factory()->count(3)->create()->each(function ($item) use ($user) {
            Favorite::factory()->create([
                'item_id' => $item->id,
                'user_id' => $user->id,
            ]);
            $item->thumbnail_url = $item->getThumbnailUrl();
        });

        // アクションを実行
        $response = $this->get(route('my.list'));
        // レスポンスの検証
        $response->assertStatus(200);
        $response->assertViewIs('my_list');
        $response->assertViewHas('items', function ($view_items) use ($items) {
            // テスト生成データとビューに渡されるアイテムコレクションとを比較
            return $items->pluck('id')->all() === $view_items->pluck('id')->all();
        });
    }
}
