<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // カテゴリーの親データを作成
        $sports = Category::create([
            'name' => 'スポーツ',
            'parent_id' => null, // 親カテゴリーがないためnull
        ]);

        $electronics = Category::create([
            'name' => '電化製品',
            'parent_id' => null, // 親カテゴリーがないためnull
        ]);

        // Sportsカテゴリの子カテゴリーを作成
        Category::create([
            'name' => 'バスケットボール',
            'parent_id' => $sports->id, // Sportsカテゴリの子
        ]);

        Category::create([
            'name' => 'ランニング',
            'parent_id' => $sports->id, // Sportsカテゴリの子
        ]);

        // electronicsカテゴリの子カテゴリーを作成
        Category::create([
            'name' => '洗濯機',
            'parent_id' => $electronics->id, // electronicsカテゴリの子
        ]);

        Category::create([
            'name' => 'パソコンディスプレイ',
            'parent_id' => $electronics->id, // electronicsカテゴリの子
        ]);

        Category::create([
            'name' => 'ドライヤー',
            'parent_id' => $electronics->id, // electronicsカテゴリの子
        ]);
    }
}
