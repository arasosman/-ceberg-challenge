<?php

namespace Tests\Feature\Crud;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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
