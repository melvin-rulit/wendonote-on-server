<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Day;

class DayController extends Controller
{
    public function index()
    {
        return view('pages.day');
    }


    public function getDay(Request $request){

	            echo '<div class="">
                	</div>
	               	<table border="1" width="100%" cellpadding="5">
	                    <tr>
	                        <th width="10%">Удалить</th>
	                        <th>Название события</th>
	                        <th>Время</th>
	                    </tr>';

					foreach (Day::where('event_id', Auth::user()->events()->first()->id)->orderBy('time','asc')->get() as $key => $value) {
						echo '<tr id="'.$value->id.'">
	                        <th><a id="'.$value->id.'" href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true"></i></a></th>
	                        <th>'.$value->name.'</th>
	                        <th class="kolvo">'.$value->time.'</th>
	                    </tr>';
					}

	                echo '</table>
	                   <form name="1" class="new_add" method="POST" id="formsend" action="javascript:void(null);" onsubmit="send()">
                       <input type="text" id="name" name="name" placeholder="Название события">
                       <input type="time" id="time" name="time" placeholder="Время" min="07:00" max="23:00" step="00:15" pattern="[0-9]{2}:[0-9]{2}">
                       <input type="hidden" id="event_id" name="event_id" value="'.Auth::user()->events()->first()->id.'">
                       <input id="submit_send" value="Добавить" type="submit" class="add">
                </form>';


    }


	public function menuList(){
		if (Auth::id() !== null) {
			$auth_id = Auth::user();
		}else{
			$auth_id = 1;
		}

		foreach (User::find($auth_id)->group as $key => $value){
            echo '<h4 class="group"><a id="'.$value->id.'" class="test link delete_group" href="javascript:void(0)">'.$value->name.'</a><a href="javascript:void(0);"><i class="fa fa-trash delete-group" aria-hidden="true"></i></a><a href="javascript:void(0);"><i class="fa fa-plus add-group" aria-hidden="true"></i></a></h4>';
		}

	}


    public function store(Request $request){

		$data = $request->all();
		$menu = Day::create($data);

		return response('Блюдо успешно добавлено');
	}


    public function deleteDay(Request $request){

    	$menu = Day::find($request['id']);
    	if($menu !== null){
			$menu->delete();
			return response('Меню успешно удалено');
    	}else{
    		return response('Ошибка, такого меню нет в списке');
    	}
    }
}
