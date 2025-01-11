<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => "Walking Customer",
            'phone' => "012345678",
        ]);
        Supplier::create([
            'name' => "Own Supplier",
            'phone' => "012345678",
        ]);
        $this->call([
            UserSeeder::class,
            RolePermissionSeeder::class,
            SettingSeeder::class,
            UnitSeeder::class,
            CurrencySeeder::class,
        ]);
    }
}
