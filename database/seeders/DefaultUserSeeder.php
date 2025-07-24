<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@sipus.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'instansi' => 'SIPUS Administrator',
                'role' => 'admin',
                'status' => 'approved',
                'approved_at' => now(),
                'email_verified_at' => now(),
            ]
        );

        // Create Regular User (Approved)
        User::updateOrCreate(
            ['email' => 'akhyar@example.com'],
            [
                'name' => 'Akhyar Nasrullah Adilian',
                'password' => Hash::make('user123'),
                'instansi' => 'Universitas Lampung',
                'role' => 'user',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => 1, // Approved by admin
                'email_verified_at' => now(),
            ]
        );

        // Create Pending User
        User::updateOrCreate(
            ['email' => 'pending@example.com'],
            [
                'name' => 'User Pending',
                'password' => Hash::make('user123'),
                'instansi' => 'Instansi Testing',
                'role' => 'user',
                'status' => 'pending',
                'email_verified_at' => now(),
            ]
        );
    }
}
