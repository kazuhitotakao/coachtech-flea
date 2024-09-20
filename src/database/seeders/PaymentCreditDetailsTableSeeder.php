<?php

namespace Database\Seeders;

use App\Models\PaymentCreditDetail;
use Illuminate\Database\Seeder;

class PaymentCreditDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $creditDetails = [
            [
                'payment_method_id' => 1,
                'card_holder_name' => '利用者1',
                'card_number' => '4000123412341234',
                'expiration_date' => '2026-05',
            ],
            [
                'payment_method_id' => 1,
                'card_holder_name' => '利用者1',
                'card_number' => '4000567812341234',
                'expiration_date' => '2025-09',
            ],
            [
                'payment_method_id' => 1,
                'card_holder_name' => '利用者2',
                'card_number' => '5000123412341234',
                'expiration_date' => '2027-01',
            ],
            [
                'payment_method_id' => 1,
                'card_holder_name' => '利用者2',
                'card_number' => '6000123412341234',
                'expiration_date' => '2026-11',
            ],
            [
                'payment_method_id' => 1,
                'card_holder_name' => '利用者3',
                'card_number' => '7000123412341234',
                'expiration_date' => '2028-03',
            ],
            [
                'payment_method_id' => 1,
                'card_holder_name' => '利用者3',
                'card_number' => '8000123412341234',
                'expiration_date' => '2026-12',
            ],
        ];

        foreach ($creditDetails as $detail) {
            PaymentCreditDetail::create($detail);
        }
    }
}
