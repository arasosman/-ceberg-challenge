<?php

namespace Tests\Feature\Crud;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testRegisterSuccess()
    {
        $this->actingAs(User::find(1))
            ->post('/api/auth/register', [
                "name" => "test",
                "email" => "email2@test.com",
                "password" => "Test1234.@",
                "password_confirmation" => "Test1234.@"
            ])
            ->assertCreated();
    }

    public function testRegisterErrorEmailInUse()
    {
        $this->actingAs(User::find(1))
            ->post('/api/auth/register', [
                "name" => "test",
                "email" => User::find(1)->email,
                "password" => "Test1234.@",
                "password_confirmation" => "Test1234.@"
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(["email"]);
    }

    public function testRegisterErrorDoesNotExistPassConf()
    {
        $this->actingAs(User::find(1))
            ->post('/api/auth/register', [
                "name" => "test",
                "email" => "email2@test.com",
                "password" => "Test1234.@",
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(["password"]);
    }

    public function testRegisterErrorRequiredFields()
    {
        $this->actingAs(User::find(1))
            ->post('/api/auth/register', [
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(["name", "email", "password"]);
    }
}
