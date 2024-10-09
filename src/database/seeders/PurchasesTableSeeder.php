<?php

namespace Database\Seeders;

use App\Models\Purchase;
use Illuminate\Database\Seeder;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purchases = [
            [
                'item_id' => 3,
                'buyer_id' => 2,
                'seller_id' => 3,
                'payment_detail_id' => 1,
                'address_id' => 1,
                'paid_price' => 5000,
            ],
            [
                'item_id' => 5,
                'buyer_id' => 2,
                'seller_id' => 4,
                'payment_detail_id' => 1,
                'address_id' => 1,
                'paid_price' => 2000,
            ],
        ];

        foreach ($purchases as $purchase) {
            Purchase::create($purchase);
        }
    }
}
