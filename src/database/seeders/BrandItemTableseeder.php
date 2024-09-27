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
        $itemsToBrand = [
            1 => 1,
            2 => 8,
            3 => 3,
            4 => 11,
            5 => 1,
            6 => 12,
        ];

        foreach ($itemsToBrand as $itemId => $brandId) {
            $item = Item::find($itemId);
            if ($item) {
                $item->brands()->attach($brandId);
            }
        }
    }
}
