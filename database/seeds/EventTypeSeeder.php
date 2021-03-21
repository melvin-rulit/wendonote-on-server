<?php

use Illuminate\Database\Seeder;

use App\Event_type;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event_types = [
          'Свадьба','День рождения', 'Юбилей', 'Годовщина', 'Корпоратив'
        ];

        foreach ($event_types as $event_type)
        {
            Event_type::create(['name' => $event_type]);
        }
    }
}
