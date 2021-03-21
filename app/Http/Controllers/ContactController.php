<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.contacts');
    }


    public function setContact(Request $request)
    {
        if(!Auth::check())
            return response()->json(['error' => 'Forbidden']);

        $data = $request->only(['gender', 'status', 'new', 'text', 'guestid']);

        //$validator = Validator::make($data, $this->getSetGuestRules(), $this->getSetGuestMessageBag());

        //if($validator->fails())
            //return response()->json(['error' => $validator->getMessageBag()->first()]);

        $event_id = Auth::user()->events()->first()->id;

        $data['text'] = strip_tags(trim($data['text']));

        if($data['new'] == 'true')
        {

            if(strlen(trim($data['text'])) <= 2 )
                return response()->json(['error' => 'the name of the guest is too short!']);

            $guest = Contact::create(
                [
                    'event_id' => $event_id,
                    'name' => $data['text']
                ]);

            if($guest == null)
                return response()->json(['error' => 'something with creating a guest went wrong!']);

            return response()->json(['success' => true, 'guestid' => $guest->id]);
        }else {
            $guest = Contact::where(
                [
                    'event_id' => $event_id,
                    'id' => intval($data['guestid'])
                ])->first();

            if($guest == null)
                return response()->json(['error' => 'something with creating a guest went wrong!']);

            $guest->name = $data['text'];

            $append = [];

            if($data['text'] == '')
            {
                $guest->delete();
                $append['removed'] = true;
            }
            else
                $guest->save();


            return response()->json(array_merge(['success' => true], $append));
        }
    }


        /* Contacts stuff */

    public function getContacts(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'permission denied!']);

        $guest = Contact::find(intval($request->input('guestid')));
        if($guest == null) return response()->json(['error' => 'permission denied!']);;

        if($guest->event_id != Auth::user()->events()->first()->id) return response()->json(['error' => 'permission denied!']);

        return response()->json(['success' => true, 'contacts' => $guest]);
    }

    public function updateContacts(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'permission denied!']);

        $guest = Contact::find(intval($request->input('guestid')));
        if($guest == null) return response()->json(['error' => 'permission denied!']);;

        if($guest->event_id != Auth::user()->events()->first()->id) return response()->json(['error' => 'permission denied!']);

        $contacts = $request->input('contacts');


        foreach ($contacts as $contact_key => $contact_value)
        {
            $guest->$contact_key = trim(strip_tags($contact_value));
        }

        print_r($guest);

        $guest->save();
        return response()->json(['success' => true]);
    }

}
