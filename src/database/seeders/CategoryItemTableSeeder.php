<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class CategoryItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items_to_category = [
            1 => 3,
            2 => 5,
            3 => 4,
            4 => 6,
            5 => 3,
            6 => 7,
        ];

        foreach ($items_to_category as $item_id => $category_id) {
            $item = Item::find($item_id);
            if ($item) {
                    $item->categories()->attach($category_id);
                }
        }
    }
}
