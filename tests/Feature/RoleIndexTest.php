<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ресурс должен быть закрытым для гостей
     */
    public function test_role_list_unauthorized()
    {
        $response = $this->get(route('role.index'));
        $response->assertStatus(401);
    }

    /**
     * Ресурс должен быть открытым для авторизованных пользователей
     */
    public function test_role_list_success()
    {
        $token = 'rememberme';
        $response = $this
            ->withToken($token)
            ->get(route('role.index'));
        $response->assertStatus(200);
    }
}
