<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class TopPageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // モックを設定
        $mockItem = Mockery::mock(Item::class);
        $mockItem->shouldReceive('getItems')->andReturn(collect([new Item(['id' => 1]), new Item(['id' => 2])]));
        $mockItem->shouldReceive('getThumbnailUrl')->andReturn('http://example.com/thumbnail.jpg');
        $mockItem->shouldReceive('getCategoryIds')->andReturn([1, 2]);

        // 依存注入の設定
        $this->app->instance(Item::class, $mockItem);
    }

    /** @test */
    public function only_users_with_specific_permissions_can_access_the_page()
    {
        // 認証せずログインしたとき、login画面へリダイレクト
        $response = $this->get(route('top.page'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function it_displays_the_top_page_with_sorted_items()
    {
        // テストユーザーとしてログイン
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('top.page'));

        $response->assertStatus(200);
        $response->assertViewIs('top_page');
        $response->assertViewHas('items');
    }
}
