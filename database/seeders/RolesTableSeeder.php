<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name'  =>  'Администратор',
                'created_at'    =>  now(),
            ],
            [
                'id' => 2,
                'name'  =>  'Модератор',
                'created_at'    =>  now(),
            ],
            [
                'id' => 3,
                'name'  =>  'Пользователь',
                'created_at'    =>  now(),
            ],

        ]);
    }
}
