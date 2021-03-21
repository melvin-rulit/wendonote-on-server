<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function showResetForm(Request $request)
    {
        if(!$request->has('token') || !$request->has('email'))
            return redirect()->route('recovery');

        $ctoken = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('created_at','>',Carbon::now()->subHours(24))
            ->first();

        if($ctoken == null || !Hash::check($request->token, $ctoken->token))
            return view('auth.reset')->withErrors(trans('passwords.token'));

        return view('auth.reset')->with(
            ['token' => $request->token, 'email' => $request->email]
        );
    }

    protected function validationErrorMessages()
    {
        return [
            'token.required' => 'Не был найден токен.',
            'email.required' => 'Не был найден e-mail.',
            'email.email' => 'Имейл некорректен',
            'password.required' => 'Пароль не был введен',
            'password.min' => 'Слишком короткий пароль!',
            'password.confirmed' => 'Пароли не совпадают!'
        ];
    }


}
