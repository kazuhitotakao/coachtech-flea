<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(UserImagesTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(PaymentBankDetailsTableSeeder::class);
        $this->call(PaymentCreditDetailsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(ItemImagesTableSeeder::class);
    }
}
