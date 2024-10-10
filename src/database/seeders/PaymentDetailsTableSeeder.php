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
        $paymentDetails = [
            [
                'user_id' => 2,
                'payment_method_id' => 1,
                'details' => json_encode([
                    'card_number' => '4000123412341234',
                    'cardholder_name' => '利用者1',
                    'expiration_date' => '2026-01',
                ])
            ],
            [
                'user_id' => 2,
                'payment_method_id' => 1,
                'details' => json_encode([
                    'card_number' => '4000123412349999',
                    'cardholder_name' => '利用者1',
                    'expiration_date' => '2026-08',
                ])
            ],
            [
                'user_id' => 2,
                'payment_method_id' => 3,
            ],
            [
                'user_id' => 3,
                'payment_method_id' => 1,
                'details' => json_encode([
                    'card_number' => '4000432143214321',
                    'cardholder_name' => '利用者2',
                    'expiration_date' => '2027-01',
                ])
            ],
            [
                'user_id' => 4,
                'payment_method_id' => 1,
                'details' => json_encode([
                    'card_number' => '4000987654321098',
                    'cardholder_name' => '利用者3',
                    'expiration_date' => '2027-07',
                ])
            ],
        ];

        foreach ($paymentDetails as $detail) {
            PaymentDetail::create($detail);
        }
    }
}
