<?php

namespace Database\Seeders;

use App\Models\CategoryField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryFieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        DB::table('category_fields')->insert([
//            [
//                'id'    =>  1,
//                'name'  =>  'Порода',
//                'value'  =>  'Чешир',
//            ],
//        ]);
        $categoryField = new CategoryField();
        $categoryField->fill([
            'id'    =>  1,
            'name'  =>  'Порода',
            'value'  =>  'Чешир',
        ],);
        $categoryField->save();
    }
}
