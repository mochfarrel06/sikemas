<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            [
                'name' => 'Paracetamol',
                'price' => 5000,
            ],
            [
                'name' => 'Amoxicillin',
                'price' => 12000,
            ],
            [
                'name' => 'Ibuprofen',
                'price' => 8000,
            ],
            [
                'name' => 'Cetirizine',
                'price' => 6000,
            ],
            [
                'name' => 'Loratadine',
                'price' => 7500,
            ],
        ];

        $data = [];
        foreach ($medicines as $medicine) {
            $data[] = [
                'name' => $medicine['name'],
                'price' => $medicine['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('medicines')->insert($data);
    }
}
