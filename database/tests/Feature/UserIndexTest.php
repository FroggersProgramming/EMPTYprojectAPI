<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_list_unauthorized(): void
    {
        $response = $this->get(route('user.index'));
        $response->assertStatus(401);
    }

    // public function test_user_list_without_permission(): void
    // {
    //     $userWithoutPermission = new User();
    //     $userWithoutPermission->fill([
    //         'name'  =>  'NoAdmin',
    //         'email' =>  'saa@a.a',
    //         'login' =>  'noadmin',
    //         'password'  =>  'noadmin123',
    //     ]);
    //     $token = Str::random(100);
    //     $userWithoutPermission->setRememberToken($token);
    //     $userWithoutPermission->save();
    //     $response = $this
    //         ->withToken($token)
    //         ->get(route('user.index'));
    //     $response->assertStatus(200);
    // }

    public function test_user_list_success(): void
    {
        $token = 'rememberme';
        $response = $this
            ->withToken($token)
            ->get(route('user.index'));
        $response->assertStatus(401);
    }
}
