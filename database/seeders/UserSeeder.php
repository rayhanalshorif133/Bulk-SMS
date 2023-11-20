<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $adminUser = new User();
        $adminUser->name = 'admin';
        $adminUser->email = 'admin@gmail.com';
        $adminUser->password = Hash::make('password');
        $adminUser->save();
        $adminUser->syncRoles($adminRole);


        for ($index=0; $index < 5; $index++) { 
            $user = new User();
            $user->name = 'user'.$index;
            $user->email = 'user' . $index . '@gmail.com';
            $user->password = Hash::make('password');
            $user->api_key = $user->getUniqueApiKey();
            $user->save();
            $user->syncRoles($userRole);
        }

    }
}
