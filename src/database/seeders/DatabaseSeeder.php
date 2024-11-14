<?php

namespace Database\Seeders;

use App\Models\User;
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
        $this->call(UserPermissionSeeder::class);
        $this->call(UserImagesTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(PaymentDetailsTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(ItemImagesTableSeeder::class);
        $this->call(CategoryItemTableSeeder::class);
    }
}
