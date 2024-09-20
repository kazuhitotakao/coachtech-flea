<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Database\Seeder;

class ItemImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemImages = [
            ['item_id' => 1, 'image_path' => 'images/items/item1.jpeg'],
            ['item_id' => 1, 'image_path' => 'images/items/item2.jpeg'],
            ['item_id' => 2, 'image_path' => 'images/items/item3.jpeg'],
            ['item_id' => 2, 'image_path' => 'images/items/item4.jpeg'],
            ['item_id' => 3, 'image_path' => 'images/items/item5.jpeg'],
            ['item_id' => 3, 'image_path' => 'images/items/item6.jpeg'],
            ['item_id' => 4, 'image_path' => 'images/items/item7.jpeg'],
            ['item_id' => 4, 'image_path' => 'images/items/item8.jpeg'],
            ['item_id' => 5, 'image_path' => 'images/items/item9.jpeg'],
            ['item_id' => 5, 'image_path' => 'images/items/item10.jpeg'],
            ['item_id' => 6, 'image_path' => 'images/items/item11.jpeg'],
            ['item_id' => 6, 'image_path' => 'images/items/item12.jpeg'],
        ];

        foreach ($itemImages as $itemImage) {
            ItemImage::create($itemImage);
        }

        /**
         *相互依存関係のあるシーダーの作成方法（お互いが外部キーをもつ場合）
         *
         * 1. ItemTableSeeder
         *    外部キー（item_image_id）をnullで登録
         *  （ItemsTableのマイグレーションファイル内でitem_image_idをnullableとしておく）
         *
         * 2. ItemImagesTableSeeder
         *    nullにしておいた、ItemsTableのitem_image_idカラムにitem_image_idを登録
         */
        $item1 = Item::where('id', '1')->first();
        $item2 = Item::where('id', '2')->first();
        $item3 = Item::where('id', '3')->first();
        $item4 = Item::where('id', '4')->first();
        $item5 = Item::where('id', '5')->first();
        $item6 = Item::where('id', '6')->first();

        $item1->item_image_id = 1;
        $item1->save();
        $item2->item_image_id = 3;
        $item2->save();
        $item3->item_image_id = 5;
        $item3->save();
        $item4->item_image_id = 7;
        $item4->save();
        $item5->item_image_id = 9;
        $item5->save();
        $item6->item_image_id = 11;
        $item6->save();
    }
}
