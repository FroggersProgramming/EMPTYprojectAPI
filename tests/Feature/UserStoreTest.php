<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_empty(): void
    {
        $response = $this->post(route('register'));
        $response->assertStatus(422);
    }

    public function test_user_invalid_name(): void
    {
        $responseWithoutField = $this->post(route('register'), [
            'email' =>  'saa@a.a',
            'login' =>  'noadmin',
            'password'  =>  'noadmin123',
        ]);
        $responseWithoutField->assertStatus(422);

        $responseWithInvalidField = $this->post(route('register'), [
//            'name' =>  'Saga',
            'name' =>  false,
            'email' =>  'saa@a.a',
            'login' =>  'noadmin',
            'password'  =>  'noadmin123',
        ]);
        $responseWithInvalidField->assertStatus(422);

        // assert that all assertions didn't create a new user
        $this->assertDatabaseMissing('users', [
            'email' =>  'saa@a.a',
        ]);
    }

    public function test_user_invalid_email(): void
    {
        $responseWithoutField = $this->post(route('register'), [
            'name' =>  'notadmin',
//            'email' =>  'saa@a.a',
            'login' =>  'noadmin',
            'password'  =>  'noadmin123',
        ]);
        $responseWithoutField->assertStatus(422);

        $responseWithInvalidField = $this->post(route('register'), [
            'name' =>  'notadmin',
            'email' =>  'saaa', // not a valid email
            'login' =>  'noadmin',
            'password'  =>  'noadmin123',
        ]);
        $responseWithInvalidField->assertStatus(422);

        $responseWithNonUniqueField = $this->post(route('register'), [
            'name' =>  'NoAdmin',
            'email' =>  'aaa@a.a', // user with this email already exists in DB
            'login' =>  'noadmin',
            'password'  =>  'noadmin123',
        ]);
        $responseWithNonUniqueField->assertStatus(422);

        // assert that all assertions didn't create a new user
        $this->assertDatabaseMissing('users', [
            'name' =>  'NoAdmin',
            'login' =>  'noadmin',
        ]);
    }

    public function test_user_invalid_login(): void
    {
        $responseWithoutField = $this->post(route('register'), [
            'name'  =>  'NoAdmin',
            'email' =>  'saa@a.a',
//            'login' =>  'noadmin',
            'password'  =>  'noadmin123',
        ]);
        $responseWithoutField->assertStatus(422);

        $responseWithInvalidField = $this->post(route('register'), [
            'name'  =>  'NoAdmin',
            'email' =>  'saa@a.a',
            'login' =>  false,
            'password'  =>  'noadmin123',
        ]);
        $responseWithInvalidField->assertStatus(422);

        // assert that all assertions didn't create a new user
        $this->assertDatabaseMissing('users', [
            'email' =>  'saa@a.a',
        ]);
    }

    public function test_user_store_success(): void
    {
        $response = $this
            ->post(route('register'), [
                'name'  =>  'NoAdmin',
                'email' =>  'saa@a.a',
                'login' =>  'noadmin',
                'password'  =>  'noadmin123',
            ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' =>  'saa@a.a',
        ]);
    }
}
