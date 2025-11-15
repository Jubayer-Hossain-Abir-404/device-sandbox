<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Data\Seeds\Devices;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('devices')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('devices')->insert(Devices::get());
    }
}
