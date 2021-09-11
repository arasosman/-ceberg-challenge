<?php

namespace Tests\Feature\Crud;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testCreateContactSuccess()
    {
        Http::fake([
            'api.postcodes.io/*' => Http::sequence()
                ->push(['result' => ["postcode" => "TW11 8RR", "longitude" => "-0.340473", "latitude" => "51.428852"]])
                ->pushStatus(404)
            ,
            'maps.googleapis.com/*' => Http::sequence()
                ->push(['results' => [['formatted_address' => 'test']]])
                ->pushStatus(404)
            ,
        ]);

        $this->actingAs(User::find(1))
            ->post('/api/contacts', [
                "name" => "test",
                "email" => "email2@test.com",
                "phone" => "1234",
                "postcode" => "asc12-23"
            ])
            ->assertCreated();
    }

    public function testListContactSuccess()
    {
        $this->actingAs(User::find(1))
            ->get('/api/contacts')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'phone',
                        'postcode',
                        'address',
                    ]
                ]
            ]);
    }

    public function testShowContactSuccess()
    {
        $this->actingAs(User::find(1))
            ->get('/api/contacts/1')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'postcode',
                    'address',
                ]
            ]);
    }

    public function testUpdateContactSuccess()
    {
        $this->actingAs(User::find(1))
            ->put('/api/contacts/1', ['name' => 'changed'])
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'postcode',
                    'address',
                ]
            ])
            ->assertJsonPath('data.name', 'changed');
    }
    public function testDeleteContactSuccess()
    {
        $this->actingAs(User::find(1))
            ->delete('/api/contacts/1')
            ->assertOk()
            ->assertJsonPath('message', 'success');
    }
}
