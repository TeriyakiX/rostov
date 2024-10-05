<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exists = User::query()
            ->where('email', 'client@mail.ru')
            ->exists();
        if(!$exists) {
            $clientRole = Role::create(['name' => 'client', 'guard_name' => 'web']);

            /** @var User $user */
            $client = User::factory([
                'name' => 'Client',
                'email' => 'client@mail.ru'
            ])->create();

            $client->assignRole($clientRole);
        }
    }
}
