<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User();
        $admin->fill([
            'name'  =>  'Admin',
            'email' =>  'aaa@a.a',
            'login' =>  'admin',
            'password'  =>  'admin123',
        ]);
        $adminRole = Role::where('name', 'Администратор')->first();
        $admin->role()->associate($adminRole);
        $admin->save();
    }
}
