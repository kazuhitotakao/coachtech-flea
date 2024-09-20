<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'name' => 'クレジットカード',
            'description' => 'Visa, MasterCard, JCBなどのクレジットカードで支払います',
        ]);
        
        PaymentMethod::create([
            'name' => 'コンビニ',
            'description' => '全国のコンビニで支払います',
        ]);

        PaymentMethod::create([
            'name' => '銀行振込',
            'description' => '銀行口座からの振込で支払います',
        ]);
    }
}
