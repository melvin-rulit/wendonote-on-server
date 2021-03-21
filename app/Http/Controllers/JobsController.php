<?php

namespace App\Http\Controllers;

use App\Calendar_Event;
use App\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Event as Event_Model;
use App\Default_Job_Categories;
use App\Default_Jobs;
use App\Job;
use App\Job_category;
use App\Budget;
use Illuminate\Support\Facades\Validator;


class JobsController extends Controller
{
    /* Pages Methods*/

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($new_job_category = null)
    {
        if(Auth::check())
        {
            $job_categories = Auth::user()->events()->first()->job_categories()->get();
        }else {
            $job_categories = Default_Job_Categories::all();
        }

        $params = [
            'job_categories' => $job_categories,
            'new_job_category' => $new_job_category
        ];

        return view('pages.joblist', $params);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function createJobCategory(Request $request)
    {
        if(!Auth::check()) return redirect()->back();
        
        $data = $request->only(['name', 'color']);
        
        $rules = [
          'name' => 'required|min:1|max:100', 
            'color' => 'required'
        ];
        
        $messages = [
            'name.required' => 'Поле с имененем группы не заполнено!',
            'name.min' => 'Поле с именем не может быть пустым!',
            'name.max' => 'Поле с именем не может превышать 100 символов!',
            'color.required' => 'Поле с цветом обязательно!'
        ];
        
        $validator = Validator::make($data, $rules, $messages);
        
        if($validator->fails())
        {
            echo $validator->getMessageBag()->first();
            return '';
        }
        
        $job_category = Job_category::create(
            array_merge($data, ['event_id' => Auth::user()->events()->first()->id])
        );
        
        return $this->index($job_category);
    }

    /* Ajax Methods */

    /**
     * @param Request $request
     * @return string
     */
    public function swapJobs(Request $request)
    {
        if(!Auth::check()) return 'Error 1';

        $data = $request->all();

        $job_category = Auth::user()->events()->first()->job_categories()->where('id', $data['category_id'])->first();
        if($job_category == null) return 'Error 2';

        $i = 0;
        $sequence = $data['sequence'];
        $jobs = $job_category->Jobs()->orderBy('seqid')->get();

        foreach ($jobs as $job)
        {
            $job->seqid = $sequence[$job->id];
            $job->save();
            $i++;
        }


        return 'Success!    ';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJob(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);

        $job = Job::find(intval($request->input('job_id')));
        if($job == null) return response()->json(['error' => 'No job found!']);

        if($job->Job_category->Event->user_id != Auth::user()->id) return response()->json(['error' => 'Forbidden.']);

        $job->Calendar_Event;
        $job->budget;
        $job->currentDate  = Carbon::now();

        return response()->json(['job' => $job]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveJob(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);

        $job = Job::find(intval($request->input('job_id')));
        if($job == null) return response()->json(['error' => 'No job found!']);

        if($job->Job_category->Event->user_id != Auth::user()->id) return response()->json(['error' => 'Forbidden.']);

        $job->name = trim(strip_tags($request->input('job_name')));
        $job->note = trim(strip_tags($request->input('job_note')));

        $calendar_event = clone $job->Calendar_Event;

        $calendar_event->creation = Carbon::createFromFormat('d.m.Y', $request->input('job_date'));
        $calendar_event->deadline = Carbon::createFromFormat('d.m.Y', $request->input('job_deadline'));
        $calendar_event->save();


        $calendar_save = Calendar::where('job_id', '=', intval($request->input('job_id')))->get()->first();
        if($calendar_save !== null)

        Calendar::where('job_id', intval($request->input('job_id')))
          ->update([
            'event' => trim(strip_tags($request->input('job_name'))),
            'description' => trim(strip_tags($request->input('job_note'))),
            'creation' => Carbon::createFromFormat('d.m.Y', $request->input('job_date')),
            'deadline' => Carbon::createFromFormat('d.m.Y', $request->input('job_deadline'))
      ]);

        if($job->budget == null)
        {
            $budget = Budget::create(['job_id' => $job->id]);
        }else $budget = $job->budget;

        $job_qty = intval($request->input('job_qty'));
        $job_price = intval($request->input('job_price'));
        $job_dif = intval($request->input('job_dif'));

        if($job_price > $job_qty){
            $job_price = $job_qty;
            $job_dif = 0;
        }

        if($job_qty - $job_price != $job_dif)
            $job_dif = $job_qty - $job_price;

        $budget->qty = $job_qty;
        $budget->price = $job_price;
        $budget->difference = $job_dif;

        $job->save();
        $budget->save();

        return response()->json(['success' => 'true']);
    }

    /**
     Удалить из списка дел и из календаря
     */
    public function deleteJob(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);

        $job = Job::find(intval($request->input('job_id')));
        if($job == null) return response()->json(['error' => 'No job found!']);

        if($job->Job_category->Event->user_id != Auth::user()->id) return response()->json(['error' => 'Forbidden.']);

        $job->delete();

        $calendar_delete = Calendar::where('job_id', '=', intval($request->input('job_id')))->get()->first();
        if($calendar_delete !== null)
            $calendar_delete->delete();

        return response()->json(['success' => 'true']);
    }

    /**
     Удалить оба
     */
        public function deleteJobOnly(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);

        $job = Job::find(intval($request->input('job_id')));
        if($job == null) return response()->json(['error' => 'No job found!']);

        if($job->Job_category->Event->user_id != Auth::user()->id) return response()->json(['error' => 'Forbidden.']);

        $job->delete();
        return response()->json(['success' => 'true']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setJobDone(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);

        $job = Job::find(intval($request->input('job_id')));
        if($job == null) return response()->json(['error' => 'No job found!']);

        if($job->Job_category->Event->user_id != Auth::user()->id) return response()->json(['error' => 'Forbidden.']);

        $job->done = true;
        $job->save();

        $calendar_done = Calendar::where('job_id', '=', intval($request->input('job_id')))->get()->first();

        if($calendar_done !== null)
            Calendar::where('job_id', intval($request->input('job_id')))
              ->update([
                'done' => true,
          ]);
         
        return response()->json(['success' => 'true']);
        }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setJobNotDone(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);

        $job = Job::find(intval($request->input('job_id')));
        if($job == null) return response()->json(['error' => 'No job found!']);

        if($job->Job_category->Event->user_id != Auth::user()->id) return response()->json(['error' => 'Forbidden.']);

        $job->done = false;
        $job->save();

        $calendar_notdone = Calendar::where('job_id', '=', intval($request->input('job_id')))->get()->first();

        if($calendar_notdone !== null)
            Calendar::where('job_id', intval($request->input('job_id')))
              ->update([
                'done' => false,
          ]);

        return response()->json(['success' => 'true']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function getJobCards(Request $request){

        if(!Auth::check()) return 'error (Ath)';

        $job_category_id = $request->input('job_category_id');
        if(!$job_category_id) return 'error (Not found #1)';

        $job_category = Job_category::find($job_category_id);
        if(!$job_category) return 'error (not found #2)';

        if($job_category->Event->user_id != Auth::user()->id)
            return 'error (fuck off)';


        return view('dynamic.job_card', ['job_category' => $job_category]);
    }

    //New job creation

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNewJobData(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);

        $job_category = Job_category::find(intval($request->input('job_category_id')));
        if($job_category == null) return response()->json(['error' => 'This job category is not found!']);

        if($job_category->event->user_id != Auth::user()->id) return response()->json(['error' => 'Forbidden!']);



        return response()->json([
            'event' => $job_category->event,
            'time' => [
                'current' => Carbon::now(),
                'deadline' => Calendar_Event::countDeadLine($job_category->event, null, 1)
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewJob(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth has found!']);

        $data = $request->all();
        dump($data);

        $job_category = Job_category::find(intval($data['job_category_id']));
        if($job_category == null) return response()->json(['error' => 'No job category found!']);

        if($job_category->Event->user_id != Auth::user()->id) return response()->json(['error' => 'Forbidden!']);

        $new_job = Job::create([
            'category_id' => $job_category->id,
            'name' => $data['job_name'] == null ? 'Новое дело' : $data['job_name'],
            'note' => $data['job_note'] == null ? '...' : $data['job_note'],
            'seqid' => 0
        ]);

        $creation = trim($data['job_date']) == '' ?
            Carbon::now()
            :
            Carbon::createFromFormat('d.m.Y', $request->input('job_date'));


        $deadline = trim($data['job_deadline']) == '' ?
            Calendar_Event::countDeadLine($job_category->Event, null, 1)
            :
            Carbon::createFromFormat('d.m.Y', $request->input('job_deadline'));;

        Calendar_Event::create([
            'job_id' => $new_job->id,
            'creation' => $creation,
            'deadline' => $deadline
        ]);

        if (trim($data['job_deadline']) !== ''){

            $calendar = new Calendar;
            $calendar->user_id = Auth::id();
            $calendar->job_id = $new_job->id;
            $calendar->event = $data['job_name'] == null ? 'Новое дело' : $data['job_name'];
            $calendar->place = 'Киев';
            $calendar->description = $data['job_note'] == null ? '...' : $data['job_note'];
            $calendar->done = '0';
            $calendar->creation = $creation;
            $calendar->deadline = Carbon::createFromFormat('d.m.Y', $request->input('job_deadline'));
            $calendar->save();
        }

        $budget = Budget::create(['job_id' => $new_job->id]);

        $job_qty = intval($request->input('job_qty'));
        $job_price = intval($request->input('job_price'));
        $job_dif = intval($request->input('job_dif'));

        if($job_price > $job_qty){
            $job_price = $job_qty;
            $job_dif = 0;
        }

        if($job_qty - $job_price != $job_dif)
            $job_dif = $job_qty - $job_price;

        $budget->qty = $job_qty;
        $budget->price = $job_price;
        $budget->difference = $job_dif;

        $budget->save();

            
        return response()->json(['success' => true]);
    }

    /* Static methods */

    public static function getTop5Jobs()
    {
        if(!Auth::check()) return null;

        $user = Auth::user();
        $event = $user->events()->first();


        $jobs = DB::table('events')
            ->join('job_categories', 'events.id', '=', 'job_categories.event_id')
            ->join('jobs', 'job_categories.id', '=', 'jobs.category_id')
            ->join('calendar_events', 'jobs.id', '=', 'calendar_events.job_id')
            ->where('events.id', '=', $event->id)
            ->select('jobs.name')
            ->orderBy('calendar_events.deadline', 'desc')
            ->limit(5)
            ->get();


        if(count($jobs) == 0) return null;

        return $jobs;
    }

    /* Delete job feature */

    function deleteJobCategory(Request $request)
    {
        if(!Auth::check()) return redirect()->back();

        $job_category_id = intval($request->input('job_category_id'));


        $event = Auth::user()->events()->first();

        $qq = true;

        foreach ($event->job_categories()->get() as $job_category)
        {
            if($job_category->id == $job_category_id)
            {
                $qq = false;
                break;
            }
        }

        if($qq) return response()->json(['error' => 'Forbidden!']);

        Job_category::destroy($job_category_id);

        return response()->json(['success' => true]);
    }

    public function sendCalendarOnly(Request $request){

         if(!Auth::check()) return null;

        $data = $request->all();

            $calendar = new Calendar;
            $calendar->user_id = Auth::id();
            $calendar->job_id = 0;
            $calendar->event = $data['job_name'] == null ? 'Новое дело' : $data['job_name'];
            $calendar->place = 'Киев';
            $calendar->description = $data['job_note'] == null ? '...' : $data['job_note'];
            $calendar->done = '0';
            $calendar->creation = $data['job_date'];
            $calendar->deadline = Carbon::Now();
            $calendar->save();

    }
}
