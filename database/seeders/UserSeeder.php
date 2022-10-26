<?php

namespace Database\Seeders;

use App\Models\PermissionUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        /** Create Admin */
        User::factory()
            ->has(PermissionUser::factory()->all(), 'permissions')
            ->create([
                'name' => 'Admin',
                'email' => 'admin@email.com'
            ]);
    }
}
