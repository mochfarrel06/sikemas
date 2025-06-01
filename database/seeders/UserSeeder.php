<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(attributes: [
            'nama_depan' => 'Admin',
            'nama_belakang' => 'admin',
            'email' => 'admin@example.com',
            'no_hp' => '082331492038',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
    }
}
