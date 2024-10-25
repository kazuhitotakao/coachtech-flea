<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Carbon\Carbon;

class UserPermissionSeeder extends Seeder
{
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

        // ロール作成
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // 権限作成
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'user']);

        // ロールに権限を付与
        $adminRole->givePermissionTo('delete');
        $userRole->givePermissionTo('user');

        // 管理者にadminRoleを割り当て
        $administrator->assignRole($adminRole);

        //一般ユーザーにuserRoleを割り当て
        $user1->assignRole($userRole);
        $user2->assignRole($userRole);
        $user3->assignRole($userRole);
    }
}
