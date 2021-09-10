<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'address' => $this->faker->address,
            'postcode' => $this->faker->postcode,
            'appointment_date' => now()->addDays(3),
            'out_of_office_date' => now()->addDays(3)->subHour(),
            'back_to_office_date' => now()->addDays(3)->addHour(),
            'contact_id' => rand(1, 10),
            'consultant_id' => rand(1, 10)
        ];
    }
}
