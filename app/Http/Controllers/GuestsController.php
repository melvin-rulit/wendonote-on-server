<?php

namespace App\Http\Controllers;

use App\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class GuestsController extends Controller{

    /* Index page */

    /**
     * The method that just probably returns the index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.visitors', ['event_id' => Auth::check() ? Auth::user()->events()->first()->id : null]);
    }

    /* Ajax methods */

    /**
     * Returns the array that contains the rules for "Set guest" function validatation input
     * @return array
     */
    public function getSetGuestRules()
    {
        return [
            'gender' => [
                    'required',
                    Rule::in(['male', 'female'])
                ],
            'status' => [
                'required',
                Rule::in(['married', 'witness', 'relatives', 'friends'])
            ]
        ];
    }

    /**
     * Messages
     * @return array
     */
    public function getSetGuestMessageBag()
    {
        return [];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setGuest(Request $request)
    {
        if(!Auth::check())
            return response()->json(['error' => 'Forbidden']);

        $data = $request->only(['gender', 'status', 'new', 'text', 'guestid']);

        $validator = Validator::make($data, $this->getSetGuestRules(), $this->getSetGuestMessageBag());

        if($validator->fails())
            return response()->json(['error' => $validator->getMessageBag()->first()]);

        $event_id = Auth::user()->events()->first()->id;

        $data['text'] = strip_tags(trim($data['text']));

        if($data['new'] == 'true')
        {

            if(strlen(trim($data['text'])) <= 2 )
                return response()->json(['error' => 'the name of the guest is too short!']);

            $guest = Guest::create(
                [
                    'event_id' => $event_id,
                    'gender' => $data['gender'],
                    'status' => $data['status'],
                    'name' => $data['text']
                ]);

            if($guest == null)
                return response()->json(['error' => 'something with creating a guest went wrong!']);

            return response()->json(['success' => true, 'guestid' => $guest->id]);
        }else {
            $guest = Guest::where(
                [
                    'event_id' => $event_id,
                    'gender' => $data['gender'],
                    'status' => $data['status'],
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

    public function getGuestNumbers()
    {
        if(!Auth::check()) return response()->json(['error' => 'Auth required!']);

        $event = Auth::user()->events()->first();

        return response([
            'success' => true,
            'total' => Guest::getGuestsNumber($event->id),
            'total_male' => Guest::getGuestsNumberByGender($event->id, 'male'),
            'total_female' => Guest::getGuestsNumberByGender($event->id, 'female')
        ]);
    }


    /* Contacts stuff */

    public function getGuestContacts(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'permission denied!']);

        $guest = Guest::find(intval($request->input('guestid')));
        if($guest == null) return response()->json(['error' => 'permission denied!']);;

        if($guest->event_id != Auth::user()->events()->first()->id) return response()->json(['error' => 'permission denied!']);

        return response()->json(['success' => true, 'contacts' => $guest]);
    }

    public function updateGuestContacts(Request $request)
    {
        if(!Auth::check()) return response()->json(['error' => 'permission denied!']);

        $guest = Guest::find(intval($request->input('guestid')));
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