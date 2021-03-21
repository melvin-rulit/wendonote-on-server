<?php

use Illuminate\Database\Seeder;

use App\Default_Job_Categories;

class DefaultJobCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_categories = [
            ['name' => 'банкет', 'color' => 'blue'],
            ['name' => 'невеста', 'color' => 'coral'],
            ['name' => 'жених', 'color' => 'purple'],
            ['name' => 'регистрация', 'color' => 'violet'],
            ['name' => 'свидетельница', 'color' => 'pink'],
            ['name' => 'свидетель', 'color' => 'purple'],
            ['name' => 'дополнительно', 'color' => 'red'],
            ['name' => 'фото видео', 'color' => 'red'],
        ];

        foreach ($default_categories as $default_category)
        {
            Default_Job_Categories::create($default_category);
        }
    }
}
