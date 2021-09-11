<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Appointment::factory(3)->create();
        Appointment::factory(3)->create(['created_at' => now()->subDays(1)]);
        Appointment::factory(3)->create(['created_at' => now()->subDays(2)]);
        Appointment::factory(3)->create(['created_at' => now()->subDays(3)]);
    }
}
