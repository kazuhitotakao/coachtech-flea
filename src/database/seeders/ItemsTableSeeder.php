<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**    
         * 'condition_id'
         *   1 : '新品',
         *   2 : '未使用に近い',
         *   3 : '目立った傷や汚れなし',
         *   4 : 'やや傷や汚れあり',
         *   5 : '傷や汚れあり',
         *   6 : 'ジャンク品',
         */
        $items = [
            [
                'name' => 'バスケットシューズ',
                'item_image_id' => null,
                'condition_id' => 1,
                'description' => '有名プレイヤーが履いていたモデルです。',
                'sale_price' => 10000,
                'user_id' => 2,
            ],
            [
                'name' => '洗濯機',
                'item_image_id' => null,
                'condition_id' => 1,
                'description' => '未使用の全自動洗濯機です。',
                'sale_price' => 110000,
                'user_id' => 2,
            ],
            [
                'name' => 'ランニングシューズ',
                'item_image_id' => null,
                'condition_id' => 2,
                'description' => 'よりよい走り心地をどうですか？',
                'sale_price' => 5000,
                'user_id' => 3,
            ],
            [
                'name' => 'パソコンディスプレイ',
                'item_image_id' => null,
                'condition_id' => 4,
                'description' => '若干の傷あるが、正常に動作します。デュアルディスプレイ用にいかがですか？',
                'sale_price' => 5000,
                'user_id' => 3,
            ],
            [
                'name' => 'バスケットボール',
                'item_image_id' => null,
                'condition_id' => 4,
                'description' => '使わなくなったので出品します。',
                'sale_price' => 2000,
                'user_id' => 4,
            ],
            [
                'name' => 'ドライヤー',
                'item_image_id' => null,
                'condition_id' => 3,
                'description' => '1年使用。正常に動作します。',
                'sale_price' => 3000,
                'user_id' => 4,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
