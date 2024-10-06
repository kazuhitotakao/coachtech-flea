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
            'name' => '新品',
        ]);

        Condition::create([
            'name' => '未使用に近い',
        ]);

        Condition::create([
            'name' => '目立った傷や汚れなし',
        ]);

        Condition::create([
            'name' => 'やや傷や汚れあり',
        ]);

        Condition::create([
            'name' => '傷や汚れあり',
        ]);

        Condition::create([
            'name' => 'ジャンク品',
        ]);
    }
}
