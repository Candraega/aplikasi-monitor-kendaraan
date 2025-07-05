<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kantor.com',
            'password' => Hash::make('@1Niadmin'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Manajer',
            'email' => 'manajer@kantor.com',
            'password' => Hash::make('@1Nimanajer'),
            'role' => 'approver',
        ]);

        User::create([
            'name' => 'Kepala Divisi',
            'email' => 'kadiv@kantor.com',
            'password' => Hash::make('@1Nikadiv'),
            'role' => 'approver',
        ]);
    }
}