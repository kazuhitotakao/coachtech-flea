<?php

namespace Database\Seeders;

use App\Models\PaymentDetail;
use Illuminate\Database\Seeder;

class PaymentDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_details = [
            [
                'user_id' => 2,
                'payment_method_id' => 1,
            ],
            [
                'user_id' => 3,
                'payment_method_id' => 1,
            ],
            [
                'user_id' => 4,
                'payment_method_id' => 1,
            ],
        ];

        foreach ($payment_details as $detail) {
            PaymentDetail::create($detail);
        }
    }
}
