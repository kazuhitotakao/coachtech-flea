<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowDisplaysItemAndComments()
    {
        // テスト用のユーザー、アイテム、コメントを作成
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $comment = Comment::factory()->create(['item_id' => $item->id, 'user_id' => $user->id]);

        // 認証された状態でアイテム表示ページにアクセス
        $response = $this->actingAs($user)->get(route('comment.show', ['item_id' => $item->id]));

        // 正常なレスポンスとアイテムおよびコメントの表示を確認
        $response->assertStatus(200);
        $response->assertViewIs('comment');
        $response->assertViewHasAll(['item', 'comments']);
    }

    public function testStoreCreatesNewComment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // ログインしてコメントを投稿
        $response = $this->actingAs($user)->post(route('comment.store', ['item_id' => $item->id]), [
            'comment' => 'New comment here'
        ]);

        // リダイレクトとコメントの作成を確認
        $response->assertRedirect(route('comment.show', ['item_id' => $item->id]));
        $this->assertDatabaseHas('comments', [
            'comment' => 'New comment here',
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);
    }
}
