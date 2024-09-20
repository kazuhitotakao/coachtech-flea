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
                'overview' => '有名プレイヤーが履いていたモデルです。',
                'amount' => 10000,
                'user_id' => 2,
            ],
            [
                'name' => '洗濯機',
                'item_image_id' => null,
                'condition_id' => 1,
                'overview' => '未使用の全自動洗濯機です。',
                'amount' => 110000,
                'user_id' => 2,
            ],
            [
                'name' => 'ランニングシューズ',
                'item_image_id' => null,
                'condition_id' => 2,
                'overview' => 'よりよい走り心地をどうですか？',
                'amount' => 5000,
                'user_id' => 3,
            ],
            [
                'name' => 'パソコンディスプレイ',
                'item_image_id' => null,
                'condition_id' => 4,
                'overview' => '若干の傷あるが、正常に動作します。デュアルディスプレイ用にいかがですか？',
                'amount' => 5000,
                'user_id' => 3,
            ],
            [
                'name' => 'バスケットボール',
                'item_image_id' => null,
                'condition_id' => 4,
                'overview' => '使わなくなったので出品します。',
                'amount' => 2000,
                'user_id' => 4,
            ],
            [
                'name' => 'ドライヤー',
                'item_image_id' => null,
                'condition_id' => 3,
                'overview' => '1年使用。正常に動作します。',
                'amount' => 3000,
                'user_id' => 4,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
