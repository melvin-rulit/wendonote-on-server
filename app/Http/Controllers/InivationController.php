<?php

namespace App\Http\Controllers;
use App\User;
use App\Inivation;
use App\Invitee;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class InivationController extends Controller
{

	public function store(Request $request){

		$data = $request->all();
		$data['user_id'] = Auth::id();
		$data['send'] = '0';
		$data['status'] = '0';
		$inivation = Inivation::create($data);

		foreach ($request->rol as $key => $value) {
			if ($value != '')
				$budget = Invitee::create(['inivation_id' => $inivation->id, 'name' => $value]);
		}
		return response('Приглашение успешно добавлено');
	}

	public function view(Request $request){
		$view_inivation = Inivation::where([['id', $request->msg]])->get();
		foreach ($view_inivation as $key => $value) {
			echo '<p>'.$value['name'].'</p>';
			echo '<p>'.$value['text'].'</p>';
			echo '<p> Ссылка на приглашение '.$_SERVER['HTTP_HOST'].'/inivation/view/'.$value['id'].'</p>';
		}
	}

	public function send(Request $request){
		$events = Inivation::where([['id', $request->id],['user_id', Auth::id()]] )->get();
		return $events;
	}

    public function index()
    {
    	if (Auth::id() !== null) {
    		$event = User::find(Auth::id())->eventName;
    	}else{
    		$event = "Свадьба Иванова";
    	}
        	return view('pages/inivation', compact('event'));
    }

    public function user($id) {
    	$view_inivation = Inivation::where([['id', $id]])->get();
	    	if(count($view_inivation) == 0) return 'Приглашение не найдено';
	  		return view('pages/view')->with('view_inivation', $view_inivation);
	}

	public function viewYes(Request $request){
		$view_inivation = Inivation::where([['id', $request->id]])->get()->first();
		if ($view_inivation !== null){
			$view_inivation =Inivation::where([['id', $request->id]])->update(['status' => $request->status]);
		}

		return response('Спасибо, мы обязательно сообщим о Вашем решении :)');
	}

	public function edit(Request $request){
		$view_inivation = Inivation::where([['id', $request->msg]])->get();
		foreach ($view_inivation as $key => $value) {
			 echo '<div id="results"></div>';
		     echo '<div class="col-row">';
		     echo '<form method="POST" id="form_editsave" action="javascript:void(null);" onsubmit="edit()"><input class="hidden" type="hidden" name="id" value="'.$value['id'].'">';
		     echo '<div class="col l-12"><div class="row">';
		     echo '<input class="text" type="text" placeholder="Название приглашения" value="'.$value['name'].'" id="name" name="name">';
		     echo '</div></div><div class="col l-12"><div class="row">';
		     echo '<input class="text" type="text" placeholder="Текс приглашения" value="'.$value['text'].'" id="text" name="text">';
		     echo '</div></div><div class="col l-12 in">';

			$invitee = Inivation::find($value['id']);
			if(count($invitee->invitee) !== 0)
		     foreach ($invitee->invitee as $key => $value) {
		     	echo '<div class="row"><input class="text pole" id="pole" type="text" name="rol[]" value="'.$value['name'].'" placeholder="Введите имя гостя">';
		     	echo '<i class="fa fa-trash" aria-hidden="true"></i><i class="add-name fa fa-plus" aria-hidden="true"></i></div>';
		     }else{
			     echo '<div class="row"><input class="text pole" id="pole" type="text" name="rol[]" placeholder="Введите имя гостя">';
			     echo '<i class="fa fa-trash" aria-hidden="true"></i><i class="add-name fa fa-plus" aria-hidden="true"></i></div>';
		     }

		     echo '</div>
		          <input id="submit_edit" value="Изменить" type="submit"><input id="submit_otpravka" value="Отправить приглашение" type="submit"></form></div>';
		          
		}
	}

	public function editSave(Request $request){
		$data = Inivation::find($request->id);
		$data->name = $request->name;
		$data->text = $request->text;
		$data->save();
		
		Invitee::where('inivation_id', '=', $request->id)->delete();

		foreach ($request->rol as $key => $value) {
			if ($value != '')
				Invitee::create(['inivation_id' => $data->id, 'name' => $value]);
		}

		return response('Приглашение успешно измененно');
	}

}
