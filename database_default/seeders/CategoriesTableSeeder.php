<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        DB::table('categories')->insert([
//            [
//                'id'    =>  1,
//                'name'  =>  'Домашние животные',
//                'parent_id'  =>  NULL,
//            ],
//            [
//                'id'    =>  2,
//                'name'  =>  'Кошки',
//                'parent_id'  =>  1,
//            ],
//        ]);
        $parentCategory = new Category();
        $parentCategory->fill([
            'id'    =>  1,
            'name'  =>  'Домашние животные',
            'parent_id'  =>  NULL,
        ]);
        $parentCategory->save();
        $childCategory = new Category();
        $childCategory->fill([
            'id'    =>  2,
            'name'  =>  'Кошки',
            'parent_id'  =>  1,
        ]);
        $childCategory->save();

        $categories = Category::all();
        $categoryField = CategoryField::first();
        foreach ($categories as $category) {
            $category->categoryFields()->attach($categoryField);
        }
    }
}
