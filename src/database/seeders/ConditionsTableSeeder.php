<?php

namespace Database\Seeders;

use App\Models\Condition;
use Illuminate\Database\Seeder;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Condition::create([
            'condition' => '新品',
        ]);

        Condition::create([
            'condition' => '未使用に近い',
        ]);

        Condition::create([
            'condition' => '目立った傷や汚れなし',
        ]);

        Condition::create([
            'condition' => 'やや傷や汚れあり',
        ]);

        Condition::create([
            'condition' => '傷や汚れあり',
        ]);

        Condition::create([
            'condition' => 'ジャンク品',
        ]);
    }
}
