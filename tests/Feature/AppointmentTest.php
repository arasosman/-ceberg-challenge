<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testCreateAppointmentSuccess()
    {
        $this->actingAs(User::find(1))
            ->post('/api/appointments', [
                "address" => "test",
                "postcode" => "asc12-23",
                "appointment_date" => "2021-10-10 12:00:00",
                "contact_id" => 1,
                "consultant_id" => 1,
            ])
            ->assertCreated();
    }

    public function testListAppointmentSuccess()
    {
        $this->actingAs(User::find(1))
            ->get('/api/appointments')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        "id",
                        "address",
                        "postcode" ,
                        "appointment_date",
                        "contact_id",
                        "consultant_id",
                    ]
                ]
            ]);
    }

    public function testShowAppointmentSuccess()
    {
        $this->actingAs(User::find(1))
            ->get('/api/appointments/1')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    "id",
                    "address",
                    "postcode" ,
                    "appointment_date",
                    "contact_id",
                    "consultant_id",
                ]
            ]);
    }

    public function testUpdateContactSuccess()
    {
        $this->actingAs(User::find(1))
            ->put('/api/appointments/1', ['address' => 'changed'])
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    "id",
                    "address",
                    "postcode" ,
                    "appointment_date",
                    "contact_id",
                    "consultant_id",
                ]
            ])
            ->assertJsonPath('data.address', 'changed');
    }
    public function testDeleteContactSuccess()
    {
        $this->actingAs(User::find(1))
            ->delete('/api/appointments/1')
            ->assertOk()
            ->assertJsonPath('message', 'success');
    }
}
