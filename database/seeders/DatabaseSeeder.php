<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hh.com'],
            [
                'name'     => 'Admin gudang',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );
    }
}