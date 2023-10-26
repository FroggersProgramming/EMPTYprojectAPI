<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\CategoryField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdvertisementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $advertisement = new Advertisement();
        $advertisement->fill([
            'title' =>  'Test',
            'description' =>  'Тестовое объявление для тестирования тестов',
            'location' =>  'Марс',
            'user_id'   =>  1,
        ]);
        $advertisement->save();
        $categoryField = CategoryField::first();
        $advertisement->categoryFields()->attach($categoryField);
    }
}
