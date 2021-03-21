<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class CalendarController extends Controller
{


	public function send(Request $request){
if (empty($request->message)){
    $events = Calendar::where('user_id', Auth::id())->get();
}else{

    $events = Calendar::where([['deadline', $request->message],['user_id', Auth::id()]] )->get();
}


      if (count($events)) {

    foreach ($events as $event) {
        echo '<table class="tb_org"><tbody><tr jodid="'; echo $event['job_id'];echo '"><td class="org_td1">'; echo $event['deadline'];
        echo '</td><td class="org_td2">'; echo $event['event'];
        echo '</td><td class="org_td3"><a class="kld_mesto" href="+"></a>'; echo $event['place'];
        echo '</td><td class="org_td4">'; echo $event['description'];
        echo '</td><td class="org_td0" jobid="'; if ($event['job_id'] == 0) {
            echo $event['id'];
        }else{echo $event['job_id'];} echo '"><a href="javascript:void(0);" class="delete">X</a>';
        echo '</td></tr></tbody></table>';
      };
    }else{
        echo '<table class="tb_org"><tbody><tr><td class="org_td1">На текущий день нет активных задач, выберите другой день или добавте новое событие ';
        echo '</td></tr></tbody></table>';
    }
   }


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Calendar::where('user_id', Auth::id())
               ->take(10)
               ->get();

        return view('pages/kalendar')->with('posts', $posts);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   	    $calendar = new Calendar;
        $calendar->user_id = Auth::id();
        $calendar->job_id = $request->job_id;
        $calendar->event = $request->job_event;
        $calendar->place = $request->job_place;
        $calendar->description = $request->job_description;
        $calendar->done = '0';
        $calendar->creation = Carbon::now();
        $calendar->deadline = $request->job_deadline;
        $calendar->save();

        return redirect('/kalendar')->with('success', 'Post Created');
    }


    public function deleteJob(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);


        $calendar_delete_id = Calendar::where('id', '=', intval($request->input('jobid')))->get()->first();
        if($calendar_delete_id !== null)
            $calendar_delete_id->delete();

        $calendar_delete_job_id = Calendar::where('job_id', '=', intval($request->input('jobid')))->get()->first();
        if($calendar_delete_job_id !== null)
            $calendar_delete_job_id->delete();
        
        return redirect('/kalendar')->with('success', 'Событие успешно удаленно');
    }



        public static function getTop5CalendarEvent($id)
    {

	    $top_event = DB::table('calendars')->where('user_id', $id)->take(5)->get();

        if(count($top_event) == 0) return null;

        return $top_event;
    }
}
