<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AutenticacaoTest extends TestCase
{
    use RefreshDatabase;

    public function test_tela_login_pode_ser_renderizada()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_pode_autenticar_usando_a_tela_login()
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_nao_podem_autenticar_com_password_invalido()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'senha-errada',
        ]);

        $this->assertGuest();
    }
}
