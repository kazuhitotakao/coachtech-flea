<?php

namespace Database\Seeders;

use App\Models\PaymentBankDetail;
use Illuminate\Database\Seeder;

class PaymentBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bankDetails = [
            [
                'payment_method_id' => 3,
                'account_name' => '利用者1',
                'account_number' => '1234567890',
                'bank_name' => '東京銀行',
                'branch_name' => '渋谷支店',
            ],
            [
                'payment_method_id' => 3,
                'account_name' => '利用者1',
                'account_number' => '2345678901',
                'bank_name' => 'みずほ銀行',
                'branch_name' => '新宿支店',
            ],
            [
                'payment_method_id' => 3,
                'account_name' => '利用者2',
                'account_number' => '3456789012',
                'bank_name' => '三井住友銀行',
                'branch_name' => '池袋支店',
            ],
            [
                'payment_method_id' => 3,
                'account_name' => '利用者2',
                'account_number' => '4567890123',
                'bank_name' => '三菱UFJ銀行',
                'branch_name' => '横浜支店',
            ],
            [
                'payment_method_id' => 3,
                'account_name' => '利用者3',
                'account_number' => '5678901234',
                'bank_name' => 'りそな銀行',
                'branch_name' => '大阪支店',
            ],
            [
                'payment_method_id' => 3,
                'account_name' => '利用者3',
                'account_number' => '6789012345',
                'bank_name' => '北洋銀行',
                'branch_name' => '札幌支店',
            ],
        ];

        foreach ($bankDetails as $detail) {
            PaymentBankDetail::create($detail);
        }
    }
}
