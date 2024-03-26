<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Device;
use App\Models\DeviceType;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeviceType::create(['name' => 'Gépek']);
        DeviceType::create(['name' => 'Elszívók']);

        // Device MODEL
        Device::create([
            'name' => 'Siemens',
            'erp_code' => 'D001',
            'type_id' => 1,
            'plant' => 'K',
            'active' => true
        ]);
        Device::create([
            'name' => 'KUKA',
            'erp_code' => 'D002',
            'type_id' => 1,
            'plant' => 'L',
            'active' => true
        ]);
        Device::create([
            'name' => 'Atlas',
            'erp_code' => 'D003',
            'type_id' => 2,
            'plant' => 'L',
            'active' => true
        ]);
        Device::create([
            'name' => 'Bernardi',
            'erp_code' => 'D004',
            'type_id' => 2,
            'plant' => 'K',
            'active' => true
        ]);
    }
}
