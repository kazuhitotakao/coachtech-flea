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
                'user_id' => 2,
                'postcode' => 1000001,
                'address' => '東京都千代田区千代田15-5',
                'building' => 'パレスサイドビル',
            ],
            [
                'user_id' => 3,
                'postcode' => 5300017,
                'address' => '大阪府大阪市北区角田町8-47',
                'building' => '阪急グランドビル',
            ],
            [
                'user_id' => 4,
                'postcode' => 8120013,
                'address' => '福岡県福岡市博多区博多駅東2丁目5-19',
                'building' => '博多第2ビル',
            ],
        ];

        foreach ($addresses as $address) {
            Address::create($address);
        }
    }
}
