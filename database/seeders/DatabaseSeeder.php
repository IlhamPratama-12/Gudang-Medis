<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =======================
        // ADMIN
        // =======================
        User::updateOrCreate(
            ['email' => 'admin@hh.com'],
            [
                'name'     => 'Admin Gudang',
                'nip'      => 'ADM001',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'status'   => 'approved',
            ]
        );

        // =======================
        // MANAJEMEN
        // =======================
        User::updateOrCreate(
            ['email' => 'manajemen@hh.com'],
            [
                'name'     => 'Manajemen Gudang',
                'nip'      => 'MNG001',
                'password' => Hash::make('manajemen123'),
                'role'     => 'manajemen',
                'status'   => 'approved',
            ]
        );

        // =======================
        // PETUGAS
        // =======================
        User::updateOrCreate(
            ['email' => 'petugas@hh.com'],
            [
                'name'     => 'Petugas Gudang',
                'nip'      => 'PTG001',
                'password' => Hash::make('petugas123'),
                'role'     => 'petugas',
                'status'   => 'approved',
            ]
        );
    }
}