<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MyPageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexListedDisplaysCorrectItems()
    {
        // ユーザーを作成して認証
        $user = User::factory()->create();

        // ユーザーの出品アイテムを作成
        $items = Item::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/my-page/listed');

        // レスポンスの検証
        $response->assertStatus(200);
        $response->assertViewIs('my_page_listed');
        $response->assertViewHas('items', function ($view_items) use ($items) {
            // ビューに渡されたアイテムのIDが生成したアイテムのIDと一致するか確認
            return $items->pluck('id')->all() === $view_items->pluck('id')->all();
        });
    }

    public function testIndexPurchasedDisplaysCorrectItems()
    {
        // ユーザーを作成して認証
        $user = User::factory()->create();
        $other_user = User::factory()->create();

        // アイテムを作成
        $items = Item::factory()->count(3)->create();

        // Purchase モデルにアイテムを購入したとして登録
        foreach ($items as $item) {
            Purchase::create([
                'item_id' => $item->id,
                'buyer_id' => $user->id,
                'seller_id' => $other_user->id,
                'paid_price' => '2000',
            ]);
        }

        // メソッドを実行してレスポンスを取得
        $response = $this->actingAs($user)->get('/my-page/purchased');

        // レスポンスの検証
        $response->assertStatus(200);
        $response->assertViewIs('my_page_purchased');
        $response->assertViewHas('items', function ($view_items) use ($items) {
            return $items->pluck('id')->all() === $view_items->pluck('id')->all();
        });
    }
}
