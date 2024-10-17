<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Database\Seeder;

class UserImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_images = [
            ['user_id' => 2, 'image_path' => 'public/images/users/user1.jpeg'],
            ['user_id' => 2, 'image_path' => 'public/images/users/user2.jpeg'],
            ['user_id' => 3, 'image_path' => 'public/images/users/user3.jpeg'],
            ['user_id' => 3, 'image_path' => 'public/images/users/user4.jpeg'],
            ['user_id' => 4, 'image_path' => 'public/images/users/user5.jpeg'],
            ['user_id' => 4, 'image_path' => 'public/images/users/user6.jpeg'],
        ];

        foreach ($user_images as $user_image) {
            UserImage::create($user_image);
        }

        /**
         *相互依存関係のあるシーダーの作成方法（お互いが外部キーをもつ場合）
         *
         * 1. UserTableSeeder
         *    外部キー（user_image_id）をnullで登録
         *  （UsersTableのマイグレーションファイル内でuser_image_idをnullableとしておく）
         *
         * 2. UserImagesTableSeeder
         *    nullにしておいた、UsersTableのuser_image_idカラムにuser_image_idを登録
         */
        $user1 = User::where('id', '2')->first();
        $user2 = User::where('id', '3')->first();
        $user3 = User::where('id', '4')->first();

        $user1->user_image_id = 1;
        $user1->save();
        $user2->user_image_id = 3;
        $user2->save();
        $user3->user_image_id = 5;
        $user3->save();
    }
}
