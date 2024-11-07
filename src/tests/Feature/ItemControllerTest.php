<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Condition;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase; // データベースをテスト用にリセットする

    public function setUp(): void
    {
        parent::setUp();
        // テスト用のストレージをモック
        Storage::fake('local');
    }
    public function testCreateView()
    {
        $user = User::factory()->create(); // ユーザーをファクトリで生成
        $this->actingAs($user); // 生成したユーザーで認証

        $response = $this->get(route('item.create')); //$this->get()メソッドは、テスト中に HTTP GET リクエストを実行し、その結果を返す。
        $response->assertStatus(200);
        $response->assertViewIs('item_create');
        $response->assertViewHasAll(['categories', 'conditions', 'brands']);
    }

    public function testItemStore()
    {
        $user = User::factory()->create(); // ユーザーをファクトリで生成
        $this->actingAs($user); // 生成したユーザーで認証

        // 必要なデータの準備
        $category = Category::factory()->create();
        $condition = Condition::factory()->create();
        $brand = Brand::factory()->create();

        $form_data = [
            'category_ids' => [$category->id],
            'condition_id' => $condition->id,
            'brand_id' => $brand->id,
            'name' => 'テスト商品',
            'description' => 'これはテスト商品です。',
            'sale_price' => 1000,
            'thumbnail_index' => 0
        ];

        $response = $this->post(route('item.store'), $form_data);
        $response->assertRedirect('/'); // リダイレクト先が正しいか確認
        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'description' => 'これはテスト商品です。',
            'sale_price' => 1000,
        ]);
    }

    public function testImageUpload()
    {
        // ダミーの画像ファイルを作成
        $file = UploadedFile::fake()->image('test.jpg');

        // リクエストデータを模擬
        $request = new \Illuminate\Http\Request();
        $request->files->set('images', [$file]);

        // ImageServiceのインスタンスを作成
        $imageService = new ImageService();

        // メソッドを実行
        $imageService->saveImages($request);

        // ファイルが指定したディレクトリに保存されたか確認
        // ここでは 'public/images/items' が保存先ディレクトリと仮定
        Storage::disk('local')->assertExists('public/images/items/' . $file->hashName());

        // セッションに保存されたパスを検証
        $this->assertEquals(session('uploaded_images_items')[0], 'public/images/items/' . $file->hashName());
    }
}
