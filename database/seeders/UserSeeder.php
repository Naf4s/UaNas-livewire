<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        if (User::where('email', 'admin@admin.com')->exists()) {
            $this->command->info('Admin users already exist, skipping...');
            return;
        }

        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nip_nis' => 'ADM001',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1, Jakarta',
            'status' => 'active',
        ]);

        // Create Kepala Sekolah User
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@admin.com',
            'password' => Hash::make('password'),
            'role' => 'kepala',
            'nip_nis' => 'KS001',
            'phone' => '081234567891',
            'address' => 'Jl. Kepala Sekolah No. 1, Jakarta',
            'status' => 'active',
        ]);

        // Create Guru User
        User::create([
            'name' => 'Guru Mata Pelajaran',
            'email' => 'guru@admin.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip_nis' => 'GRU001',
            'phone' => '081234567892',
            'address' => 'Jl. Guru No. 1, Jakarta',
            'status' => 'active',
        ]);

        // Create Wali Kelas User
        User::create([
            'name' => 'Wali Kelas',
            'email' => 'walikelas@admin.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip_nis' => 'WK001',
            'phone' => '081234567893',
            'address' => 'Jl. Wali Kelas No. 1, Jakarta',
            'status' => 'active',
        ]);

        // Create additional sample users
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'Guru ' . $i,
                'email' => 'guru' . $i . '@admin.com',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'nip_nis' => 'GRU' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'phone' => '08' . rand(1000000000, 9999999999),
                'address' => 'Jl. Guru No. ' . ($i + 1) . ', Jakarta',
                'status' => 'active',
            ]);
        }
    }
}
