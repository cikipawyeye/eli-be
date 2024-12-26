<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\User\Enums\RoleEnum;
use App\Domains\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws \Throwable
     */
    public function run(): void
    {
        User::firstOrCreate([
            'email' => 'superadmin@example.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
        ])->assignRole(RoleEnum::SuperAdmin->value);

        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
        ])->assignRole(RoleEnum::Admin->value);

        User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'name' => 'User',
            'password' => Hash::make('password'),
        ])->assignRole(RoleEnum::User->value);
    }
}
