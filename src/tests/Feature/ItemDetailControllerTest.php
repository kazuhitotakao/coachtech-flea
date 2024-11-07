<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemDetailControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserItemDetail()
    {
        $user = User::factory()->create();

        // BrandとConditionモデルのインスタンスをデータベースに保存してIDを作成
        $brand = Brand::factory()->create();
        $condition = Condition::factory()->create();

        // Itemモデルを作成し、brand_idとcondition_idを設定
        $item = Item::factory()->create([
            'brand_id' => $brand->id,
            'condition_id' => $condition->id,
        ]);
        // BrandとConditionのリレーションを設定
        $item->setRelation('brand', $brand);
        $item->setRelation('condition', $condition);

        // コメントのリレーション
        $comments = Comment::factory()->count(4)->create(['item_id' => $item->id]);
        $item->setRelation('comments', $comments);

        // お気に入りのリレーション
        // ユーザーがアイテムをお気に入りに追加
        $user->favorites()->attach($item->id);

        // ルートパラメータのシミュレーション
        $response = $this->actingAs($user)->get(route('item.user_detail', ['item_id' => $item->id]));

        // レスポンスの検証
        $response->assertStatus(200);
        $response->assertViewIs('item_detail');
        $response->assertViewHas('item', $item);
        $response->assertViewHas('brand_name', $brand->name);
        $response->assertViewHas('categories_name', $item->getCategoryNames());
        $response->assertViewHas('image_urls', $item->getImageUrls());
        $response->assertViewHas('image_url_thumbnail', $item->getThumbnailUrl());
        $response->assertViewHas('favorites_count', 1);
        $response->assertViewHas('comments_count', 4);
    }
}
