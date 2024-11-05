<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $admin;  // 管理者ユーザー用のインスタンス変数

    protected function setUp(): void
    {
        parent::setUp();
        // ロールを作成
        $role = Role::create(['name' => 'admin']);
        // ユーザーを作成し、ロールを割り当てる
        $this->admin = User::factory()->create(); // $this->admin に保存
        $this->admin->assignRole($role);
    }

    public function testIndexUsers()
    {
        // 認証された状態でユーザー一覧ページにアクセス
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));

        // レスポンスが 200 OK であることを確認
        $response->assertStatus(200);
        $response->assertViewIs('admin_users_index');
    }

    public function testDestroyUser()
    {
        // テスト用ユーザーの作成
        $userToDelete = User::factory()->create();

        // 認証された状態でユーザー削除処理を実行
        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', ['user_id' => $userToDelete->id]));

        // レスポンスがリダイレクトであること（削除後に一覧ページへ戻る）
        $response->assertRedirect('/admin-page/users');
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    public function testSearchUser()
    {
        // 検索対象のユーザーを作成
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com'
        ]);

        User::factory()->create([
            'name' => 'Another User',
            'email' => 'another@example.com'
        ]);

        // 認証された状態で名前付きルートを使ってユーザー検索（名前で検索）※keyはinputのname='key'のこと。検索キー
        $response = $this->actingAs($this->admin)->get(route('admin.users.search', ['key' => 'Test']));

        // レスポンスが 200 OK であることと、'Test User' が表示されていることを確認
        $response->assertStatus(200);
        $response->assertViewIs('admin_users_index');
        $response->assertSee('Test User');
        $response->assertDontSee('Another User'); // 検索結果に 'Another User' が含まれていないことを確認

        // 認証された状態でメールアドレスを使ってユーザー検索
        $response = $this->actingAs($this->admin)->get(route('admin.users.search', ['key' => 'example.com']));

        // メールアドレスでの検索が反映されていることを確認
        $response->assertStatus(200);
        $response->assertSee('Test User');
        $response->assertSee('Another User'); // 両方のユーザーが表示されていることを確認
    }

    public function testIndexComments()
    {
        // コメントとそれに関連するユーザーとアイテムのデータを作成
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Comment::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);

        // 認証された状態でコメント一覧ページにアクセス
        $response = $this->actingAs($this->admin)->get(route('admin.comments.index'));

        // レスポンスが 200 OK であることを確認
        $response->assertStatus(200);
        $response->assertViewIs('admin_comments_index');
        $response->assertViewHas('comments');
    }

    public function testDestroyComment()
    {
        // コメントとそれに関連するユーザーとアイテムのデータを作成
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id, 'item_id' => $item->id]);

        // 認証された状態でコメント削除処理を実行
        $response = $this->actingAs($this->admin)->delete(route('admin.comments.destroy', ['comment_id' => $comment->id]));

        // レスポンスがリダイレクトであること
        $response->assertRedirect('/admin-page/comments');
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function testDestroyComments()
    {
        // 複数のコメントとそれに関連するユーザーとアイテムのデータを作成
        $comments = Comment::factory()->count(3)->create();

        // コメントのIDの配列を作成
        $comment_ids = $comments->pluck('id')->toArray();

        // コメントID配列をもとに、フロントエンドが送信するであろうJSON配列を作成
        $comments_data = [];
        foreach ($comment_ids as $id) {
            $comments_data[] = ['id' => $id];
        }

        // JSON形式にエンコード
        $json_comments = json_encode($comments_data);

        // 認証された状態でコメント一括削除を実行
        $response = $this->actingAs($this->admin)->delete(route('admin.comments.bulk_destroy'), ['comments' => $json_comments]);

        // レスポンスがリダイレクトであること
        $response->assertRedirect('/admin-page/comments');
        foreach ($comment_ids as $id) {
            $this->assertDatabaseMissing('comments', ['id' => $id]);
        }
    }

    public function testSearchComment()
    {
        // コメントとそれに関連するユーザーとアイテムのデータを作成
        $user = User::factory()->create(['name' => 'John Doe']);
        $item = Item::factory()->create(['name' => 'Example Item']);
        Comment::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'This is a test comment.'
        ]);

        // 認証された状態でコメント検索を実行
        $response = $this->actingAs($this->admin)->get(route('admin.comments.search', ['key' => 'John']));
        // レスポンスが 200 OK であることと、特定のコメントが表示されていることを確認
        $response->assertStatus(200);
        $response->assertViewIs('admin_comments_index');
        $response->assertSee('This is a test comment.');
        $response->assertSee('John Doe');

        // コメントの内容でも検索
        $response = $this->actingAs($this->admin)->get(route('admin.comments.search', ['key' => 'Test']));
        // レスポンスが 200 OK であることと、特定のコメントが表示されていることを確認
        $response->assertStatus(200);
        $response->assertViewIs('admin_comments_index');
        $response->assertSee('This is a test comment.');
        $response->assertSee('John Doe');
    }
}
