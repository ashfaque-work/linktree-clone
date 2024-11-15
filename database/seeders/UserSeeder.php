<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PremiumUser;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => Hash::make('Admin@123')]);
        PremiumUser::create(['user_id' => $admin->id]);
        $admin->assignRole('admin');
    }
}
