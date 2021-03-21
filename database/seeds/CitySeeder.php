<?php

use Illuminate\Database\Seeder;

use App\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
                    'Одесса',
					'Киев',
					'Харьков',
					'Днепр',
					'Запорожье',
					'Львов',
					'Кривой Рог',
					'Николаев Николаев',
					'Винница',
					'Херсон',
					'Чернигов',
					'Полтавва',
					'Черкассы',
					'Житомир',
					'Хмельницкий',
					'Черновцы',
					'Ровно',
					'Ивано-франковск',
					'Кременчуг',
					'Тернополь',
					'Луцк',
					'Ужгород'
        ];

        foreach($cities as $city)
        {
            City::create(['name' => $city]);
        }

    }
}
