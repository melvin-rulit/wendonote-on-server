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
use App\Note;
use App\Job_category;
use App\Notes_category;
use App\Budget;
use Illuminate\Support\Facades\Validator;

class NotesController extends Controller
{


    public function index($new_job_category = null)
    {
        if(Auth::check())
        {
            $job_categories = Auth::user()->events()->first()->notes_categories()->get();
        }else {
            $job_categories = Default_Job_Categories::all();
        }

        $params = [
            'job_categories' => $job_categories,
            'new_job_category' => $new_job_category
        ];

        return view('pages.notes', $params);
    }


    public function getNote(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);

        $job = Note::find(intval($request->input('job_id')));
        if($job == null) return response()->json(['error' => 'No job found!']);


        $job->Calendar_Event;
        $job->budget;
        $job->currentDate  = Carbon::now();

        return response()->json(['job' => $job]);
    }


    public function saveNote(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);

        $job = Note::find(intval($request->input('job_id')));
        if($job == null) return response()->json(['error' => 'No job found!']);

        $job->name = trim(strip_tags($request->input('job_name')));
        $job->note = trim(strip_tags($request->input('job_note')));
        $job->seqid = trim(strip_tags($request->input('job_date')));


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

        return response()->json(['success' => 'true']);
    }


    public function createNoteCategory(Request $request)
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
        
        $job_category = Notes_category::create(
            array_merge($data, ['event_id' => Auth::user()->events()->first()->id])
        );
        
        return $this->index($job_category);
    }


    public function createNewNote(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth has found!']);

        $data = $request->all();

        $job_category = Notes_category::find(intval($data['job_category_id']));
        if($job_category == null) return response()->json(['error' => 'No job category found!']);

        if($job_category->Event->user_id != Auth::user()->id) return response()->json(['error' => 'Forbidden!']);

        $new_job = Note::create([
            'category_id' => $job_category->id,
            'name' => $data['job_name'] == null ? 'Новая заметка' : $data['job_name'],
            'note' => $data['job_note'] == null ? '...' : $data['job_note'],
            'seqid' => $data['job_date'] == null ? '...' : $data['job_date']
        ]);

        return response()->json(['success' => true]);
    }


    public function getNoteCards(Request $request){

        if(!Auth::check()) return 'error (Ath)';

        $job_category_id = $request->input('job_category_id');
        if(!$job_category_id) return 'error (Not found #1)';

        $job_category = Notes_category::find($job_category_id);
        if(!$job_category) return 'error (not found #2)';

        if($job_category->Event->user_id != Auth::user()->id)
            return 'error (fuck off)';


        return view('dynamic.note_card', ['job_category' => $job_category]);
    }


    public function setNoteDone(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);

        $job = Note::find(intval($request->input('job_id')));
        if($job == null) return response()->json(['error' => 'No job found!']);

        $job->done = true;
        $job->save();
         
        return response()->json(['success' => 'true']);
    }



    public function setNoteNotDone(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);

        $job = Note::find(intval($request->input('job_id')));
        if($job == null) return response()->json(['error' => 'No job found!']);

        $job->done = false;
        $job->save();

        return response()->json(['success' => 'true']);
    }


    public function deleteNoteOnly(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'No auth found!']);

        $job = Note::find(intval($request->input('job_id')));
        if($job == null) return response()->json(['error' => 'No job found!']);

        $job->delete();
        return response()->json(['success' => 'true']);
    }


}
