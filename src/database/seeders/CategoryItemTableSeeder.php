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
        $itemsToCategory = [
            1 => 3,
            2 => 5,
            3 => 4,
            4 => 6,
            5 => 3,
            6 => 7,
        ];

        foreach ($itemsToCategory as $itemId => $categoryId) {
            $item = Item::find($itemId);
            if ($item) {
                    $item->categories()->attach($categoryId);
                }
        }
    }
}
