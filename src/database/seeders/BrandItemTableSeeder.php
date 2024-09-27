<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class BrandItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = Item::find(1);
        $item->brands()->attach(1);
        $item = Item::find(2);
        $item->brands()->attach(8);

        $item = Item::find(3);
        $item->brands()->attach(3);
        $item = Item::find(4);
        $item->brands()->attach(11);

        $item = Item::find(5);
        $item->brands()->attach(1);
        $item = Item::find(6);
        $item->brands()->attach(12);
    }
}
