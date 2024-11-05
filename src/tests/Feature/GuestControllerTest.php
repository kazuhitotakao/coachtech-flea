<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GuestControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestIndexDisplaysItems()
    {
        $item = Item::factory()->create();

        $response = $this->get('/guest');

        $response->assertStatus(200);
        $response->assertViewIs('guest.top_page');
        $response->assertViewHas('items');
    }

    public function testGuestItemDetailDisplaysItemDetails()
    {
        $brand = Brand::factory()->create(); // ブランドのテストデータを作成
        $condition = Condition::factory()->create();
        $parent_category = Category::factory()->create();
        $child_category = Category::factory()->withParent($parent_category->id)->create();
        $item = Item::factory()->hasAttached($child_category)->for($brand)->for($condition)->create(); // ブランドとカテゴリをアイテムに関連付ける

        $response = $this->get(route('items.guest_detail', ['item_id' => $item->id]));
        $response->assertStatus(200);
        $response->assertViewIs('guest.item_detail');
        $response->assertViewHasAll([
            'item',
            'brand_name',
            'categories_name',
            'image_urls',
            'image_url_thumbnail',
            'favorites_count',
            'comments_count'
        ]);
    }

    public function testUnauthorizedAccessPage()
    {
        $response = $this->get(route('guest.unauthorized_access'));

        $response->assertStatus(200);
        $response->assertViewIs('guest.unauthorized_access');
    }
}
