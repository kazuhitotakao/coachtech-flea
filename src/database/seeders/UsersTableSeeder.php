<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        // ユーザー作成
        $administrator = User::create([
            'name' => '管理者',
            'email' => 'admin@sample.com',
            'email_verified_at' => $now,
            'password' => bcrypt('password'),
            'user_image_id' => null,
        ]);

        $user1 = User::create([
            'name' => '利用者1',
            'email' => 'user1@sample.com',
            'email_verified_at' => $now,
            'password' => bcrypt('password'),
            'user_image_id' => null,
        ]);

        $user2 = User::create([
            'name' => '利用者2',
            'email' => 'user2@sample.com',
            'email_verified_at' => $now,
            'password' => bcrypt('password'),
            'user_image_id' => null,
        ]);

        $user3 = User::create([
            'name' => '利用者3',
            'email' => 'user3@sample.com',
            'email_verified_at' => $now,
            'password' => bcrypt('password'),
            'user_image_id' => null,
        ]);
    }
}
