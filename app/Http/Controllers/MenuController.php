<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Menu;
use App\User;
use App\Guest;
use App\Menu_group;

class MenuController extends Controller
{

    public function index(){

    	return view('pages/menu');
    }

    public function getMenu(Request $request){

    	$group = Menu_group::find($request['id']);

				$id_group = $group->id;
	            echo '<div class="group">
                    <h3 class="group" id="'.$group->id.'">'.$group->name.'</h3>
                	</div>
	               	<table border="1" width="100%" cellpadding="5">
	                    <tr>
	                        <th></th>
	                        <th>Название блюда</th>
	                        <th>Кол-во</th>
	                        <th>Вес</th>
	                        <th>Цена</th>
	                        <th>Сумма</th>
	                    </tr>';

					foreach (Menu::where('menu_group_id', $request['id'])->get() as $key => $value) {
						echo '<tr id="'.$value->id.'">
	                        <th><a id="'.$value->id.'" href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true"></i></a></th>
	                        <th>'.$value->name.'</th>
	                        <th class="kolvo">'.$value->kolvo.'</th>
	                        <th class="weight">'.$value->weight.'</th>
	                        <th>'.$value->price.'</th>
	                        <th class="summ">'.$value->summ.'</th>
	                    </tr>';
					}

	                echo '</table>
	                   <form name="'.$id_group.'" class="new_add" method="POST" id="formsend" action="javascript:void(null);" onsubmit="send()">
                       <input type="text" id="name" name="name" placeholder="Название блюда">
                       <input type="text" id="kolvo" name="kolvo" placeholder="Кол-во">
                       <input type="text" id="weight" name="weight" placeholder="Вес">
                       <input type="text" id="price" name="price" placeholder="Цена">
                       <input type="text" class="summ-input" name="summ" readonly>
                       <input id="submit_send" value="Добавить" type="submit" class="add">
                </form>';
                unset($id_group);


    }


    public function totalInfo(){

    	if (Auth::id() !== null) {
			$auth_id = Auth::user();
		}else{
			$auth_id = 1;
		}

    	$summ = 0;
		$weight = 0;
		$kolvo = 0;
$test = "13,4343";

// Выводим количество гостей
    if (Auth::user()) {
        $totalguest = \App\Guest::getGuestsNumber(\Illuminate\Support\Facades\Auth::user()->events()->first()['id']);
    }else{
        $totalguest = 10;
    }

		foreach(User::find($auth_id)->group as $key => $value){
    		foreach(Menu_group::find($value->id)->menu as $key => $value){
    			$summ += $value->summ;
				$weight += $value->weight;
				$kolvo += $value->kolvo;
    		}
		}
		       echo '<table border="1" width="100%" cellpadding="5">
                    <tr>
                        <th>Вес на гостя</th>
                        <th>Сумма на 1 гостя</th>
                        <th>Сумма общая</th>
                    </tr>
                    <tr>
                        <th>'. number_format((float)$test, 2, '.', '').'</th>
                         <th>'. number_format((float)$test, 2, '.', '').'</th>
                         <th>'. number_format((float)$test, 2, '.', '').'</th>
                    </tr>
                </table>';
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



    public function addGroup(Request $request){

    	$data = $request->all();
		$data['user_id'] = Auth::id();
		$addGroup = Menu_group::create($data);

    	return response('Группа добавлена');
    }



    public function deleteGroup(Request $request){
    														// удалить и все элементы связаные с этой группой
    	$deleteGroup = Menu_group::find($request['id']);

    	if ($deleteGroup !== null){
    		$deleteGroup->delete();

    	$menu = Menu::where('menu_group_id', '=', $request['id']);
    	if ($menu !== null)
    	Menu::where('menu_group_id', '=', $request['id'])->delete();

    		return response('Группа удалена');
    	}else{
    		return response('Группа не удалена по неизвестной причине');
    	}
    	
    }



    public function store(Request $request){

		$data = $request->all();
		$menu = Menu::create($data);

		return response('Блюдо успешно добавлено');
	}


    public function deleteMenu(Request $request){

    	$menu = Menu::find($request['id']);
    	if($menu !== null){
			$menu->delete();
			return response('Меню успешно удалено');
    	}else{
    		return response('Ошибка, такого меню нет в списке');
    	}
    }

}
