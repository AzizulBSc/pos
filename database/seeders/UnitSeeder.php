<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'name' => 'Piece',
                'short_name' => 'pcs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kilogram',
                'short_name' => 'kg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pound',
                'short_name' => 'pnd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Liter',
                'short_name' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Meter',
                'short_name' => 'm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dozen',
                'short_name' => 'dz',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Box',
                'short_name' => 'box',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        Unit::insert($units);
    }
}
