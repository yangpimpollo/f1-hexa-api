<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use yangpimpollo\L3_infrastructure\Model\my_user;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private string $username = 'testuser';
    private string $password = 'password123';

    protected function setUp(): void
    {
        parent::setUp();

        // Crear un usuario de prueba
        my_user::create([
            'username' => $this->username,
            'email' => 'test@example.com',
            'password' => Hash::make($this->password),
        ]);
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        $response = $this->postJson('/api/auth.login', [
            'username' => $this->username,
            'password' => $this->password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'token',
                'token_type'
            ])
            ->assertJson([
                'status' => 'success✅',
            ]);

        $this->assertNotEmpty($response->json('token'));
    }

    public function test_user_cannot_login_with_incorrect_password(): void
    {
        $response = $this->postJson('/api/auth.login', [
            'username' => $this->username,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['username']);
    }

    public function test_user_can_logout(): void
    {
        // Primero hacemos login para obtener un token
        $loginResponse = $this->postJson('/api/auth.login', [
            'username' => $this->username,
            'password' => $this->password,
        ]);

        $token = $loginResponse->json('token');

        // Intentamos logout con el token
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/auth.logout');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success✅',
                'dat' => '❌❌❌ Sesión cerrada correctamente.'
            ]);
    }

    public function test_logout_is_protected_by_sanctum(): void
    {
        $response = $this->postJson('/api/auth.logout');

        $response->assertStatus(401);
    }
}
