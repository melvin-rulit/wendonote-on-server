<?php

namespace App\Http\Controllers;

use App\Event;
use App\City;
use App\Event_type;

use App\Job;
use App\Job_category;
use App\Default_Job_Categories;
use App\Default_Jobs;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use Prophecy\Exception\InvalidArgumentException;

class WeddingController extends Controller
{

    public function getCreateWeddingPage($message = null)
    {
        $cities = City::all();
        $event_types = Event_type::all();

        $params = [
            'cities' => $cities,
            'event_types' => $event_types,
            'message' => $message
        ];

        return view('pages.create_wedding', $params);
    }

    public function postCreateWeddingPage(Request $request)
    {
        $data = $request->all();

        try{
            Carbon::createFromFormat('Y-m-d', $data['date']);
        }catch (\InvalidArgumentException $e)
        {
            $temp = explode('.', $data['date']);
            $data['date'] = $temp[2]."-".$temp[1]."-".$temp[0];
        }

        $rules = [
            'name' => 'required|max:100',
            'event_type' => 'required|exists:event_types,name',
            'city' => 'required|exists:cities,name',
            'date' => 'required|date|date_format:Y-m-d|after:'.Carbon::now()->addDay(1)->toDateString()
        ];

        $messages = [
            'name.required' => 'Вы не ввели имя для вашего события!',
            'name.max' => 'Введенное имя слишком длинное!',
            'city.required' => 'Поле с городом не было заполнено!',
            'city.exists' => 'Такого города не найдено в базе данных!',
            'event_type.required' => 'Поле с типом мероприятия не заполнено!',
            'event_type.exists' => 'Такой тип мероприятия не был найден!',
            'date.date' => 'Была введена некорректная дата',
            'date.date_format' => 'Дата должна быть в формате yyyy-mm-dd (например 2017-06-03)',
            'date.after' => 'Вы не можете выбрать дату ранее сегодняшней даты'
        ];

        $validator = Validator::make($data, $rules, $messages);

        if($validator->fails())
        {
            $string = $validator->getMessageBag()->first();
            return redirect()->back()->withInput()->withErrors($string);
        }




        if(!Auth::check())
        {
            Session::put('event', $data);
            return redirect()->route('register');
        }

        Event::create([
            'user_id' => Auth::user()->id,
            'city_id' => City::where('name', $data['city'])->first()->id,
            'event_type_id' => Event_type::where('name', $data['event_type'])->first()->id,
            'name' => $data['name'],
            'date' => $data['date']
        ]);

        return redirect()->route('mynote');



    }

}
