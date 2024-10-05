<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exists = User::query()
            ->where('email', 'admin@mail.ru')
            ->exists();
        if(!$exists) {
            $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);

            /** @var User $user */
            $admin = User::factory([
                'name' => 'Admin',
                'email' => 'admin@mail.ru'
            ])->create();

            $admin->assignRole($adminRole);
        }
    }
}
