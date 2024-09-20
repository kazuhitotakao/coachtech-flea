<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //スポーツ用品ブランド
        Brand::create(['name' => 'Nike', 'description' => '世界的なスポーツブランド']);
        Brand::create(['name' => 'Puma', 'description' => '高速スポーツ用品の設計と革新で知られるドイツのブランド。']);
        Brand::create(['name' => 'Adidas', 'description' => 'スポーツ用品を展開する企業']);
        Brand::create(['name' => 'Under Armour', 'description' => '革新的なパフォーマンスウェアを提供するアメリカのスポーツブランド。']);
        Brand::create(['name' => 'Reebok', 'description' => 'フィットネスとライフスタイルフットウェアに焦点を当てたグローバル企業。']);
        Brand::create(['name' => 'Asics', 'description' => '高性能ランニングシューズとスポーツギアで有名な日本のブランド。']);

        //家電用品ブランド
        Brand::create(['name' => 'Sony', 'description' => '日本を代表するエレクトロニクス企業']);
        Brand::create(['name' => 'Panasonic', 'description' => '家電やエレクトロニクス製品を展開する日本企業']);
        Brand::create(['name' => 'Samsung', 'description' => '韓国の大手電機メーカー、特にスマートフォンとテレビで有名']);
        Brand::create(['name' => 'Apple', 'description' => 'スマートフォンやコンピュータ、家電製品を手がける世界的企業']);
        Brand::create(['name' => 'Sharp', 'description' => '日本の家電メーカー、特に液晶技術で有名']);
        Brand::create(['name' => 'Hitachi', 'description' => '日本の総合電機メーカー、家電から産業用電機まで幅広い製品を展開']);
    }
}
