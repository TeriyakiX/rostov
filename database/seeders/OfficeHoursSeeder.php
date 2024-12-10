<?php

namespace Database\Seeders;

use App\Models\OfficeHour;
use Illuminate\Database\Seeder;

class OfficeHoursSeeder extends Seeder
{
    public function run()
    {
        OfficeHour::create([
            'days' => 'пн-пт',
            'hours' => '8:30-17:30',
        ]);
    }
}
