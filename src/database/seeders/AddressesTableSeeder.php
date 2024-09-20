<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addresses = [
            [
                'user_id' => 1,
                'postcode' => '100-0001',
                'address' => '東京都千代田区千代田',
                'building' => 'パレスサイドビル',
            ],
            [
                'user_id' => 1,
                'postcode' => '105-0014',
                'address' => '東京都港区芝浦4丁目9-25',
                'building' => '三田国際ビル',
            ],
            [
                'user_id' => 2,
                'postcode' => '530-0017',
                'address' => '大阪府大阪市北区角田町8-47',
                'building' => '阪急グランドビル',
            ],
            [
                'user_id' => 2,
                'postcode' => '556-0011',
                'address' => '大阪府大阪市浪速区難波中3丁目7-20',
                'building' => 'なんばスカイオ',
            ],
            [
                'user_id' => 3,
                'postcode' => '812-0013',
                'address' => '福岡県福岡市博多区博多駅東2丁目5-19',
                'building' => '博多第2ビル',
            ],
            [
                'user_id' => 3,
                'postcode' => '810-0041',
                'address' => '福岡県福岡市中央区天神2丁目11-1',
                'building' => '福岡天神ビル',
            ],
        ];

        foreach ($addresses as $address) {
            Address::create($address);
        }
    }
}
