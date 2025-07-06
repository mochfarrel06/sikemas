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
            'nama_depan' => 'sdas',
            'nama_belakang' => 'sadas',
            'email' => 'sda@example.com',
            'no_hp' => '082331492038',
            'password' => Hash::make('12345678'),
            'role' => 'kasir',
        ]);
    }
}
