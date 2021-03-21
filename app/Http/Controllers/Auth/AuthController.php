<?php
/**
 * Created by PhpStorm.
 * User: ic
 * Date: 26.04.2017
 * Time: 15:22
 */

namespace app\Http\Controllers\Auth;

use App\Events\createEventFromSessionEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Menu_group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller{

    /* All register handle */

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRegisterPage($message = null)
    {
        if(!Session::has('event')) return redirect()->route('wedding-create');

        $params = [
            'message' => $message
        ];

        return view('auth.register', $params);
    }

    /* Register handle functions */

    /**
     * @return array
     */
    public function getRegisterRules()
    {
        return [
            'username' => 'required|min:2|max:50|unique:users',
            'email' => 'required|email|min:2|max:50|unique:users',
            'password' => 'required|min:6'
        ];
    }

    /**
     * @return array
     */
    public function getRegisterMessages()
    {
        return [
            'username.required' => 'Вы не ввели имя пользователя!',
            'username.min' => 'Имя пользователя слишком короткое!',
            'username.max' => 'Имя пользователя слишком длинное!',
            'username.unique' => 'Такое имя пользователя уже зарегестрировано в системе!',
            'email.required' => 'Вы не ввели e-mail!',
            'email.min' => 'Введенный e-mail слишком короткий!',
            'email.max' => 'Введенный e-mail слишком длинный!',
            'email.unique' => 'Такой e-mail уже зарегестрирован в системе!',
            'email.email' => 'Вы ввели неправильный адрес электронной почты!',
            'password.required' => 'Вы не ввели пароль!',
            'password.min' => 'Вы ввели слишком короткий пароль!'
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postRegisterPage(Request $request)
    {
        $data = $request->all();

        $rules = $this->getRegisterRules();
        $messages = $this->getRegisterMessages();

        $validator = Validator::make($data, $rules, $messages);

        if($validator->fails())
            return $this->getRegisterPage($validator->getMessageBag()->first());

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        Auth::login($user);

    // При успешной регистрации добавляем дефолтные записи в базу, криво но работает

  $arr = array('Холодные закуски', 'Фуршет', 'Салаты', 'Горячие закуски', 'Горячие основные блюда', 'Гарниры', 'Десерты', 'Безалкогольные напитки', 'Алкогольные напитки');

    foreach($arr as $value)
  {
        Menu_group::create([
            'name' => $value,
            'user_id' => Auth::id(),
        ]);
  } 

        event(new createEventFromSessionEvent($user->id));

        return $this->getRegisterPage('success');

    }

    /* All login handle */

    public function getLoginPage($message = null)
    {
        $params = [
            'message' => $message
        ];

        return view('auth.login', $params);
    }


    /* Password recovery stuff */

    public function getPasswordRecoveryPage()
    {
        return view('auth.recovery');
    }





    public function getLoginRules()
    {
        return [
            'username' => 'required',
            'password' => 'required|min:6'
        ];
    }

    public function getLoginMessages()
    {
        return [
            'username.required' => 'Вы не ввели имя пользователя',
            'password.required' => 'Вы не ввели пароль',
            'password.min' => 'Ввденный пароль слишком короткий'
        ];
    }

    public function postLoginPage(Request $request)
    {
        $data = $request->all();

        $rules = $this->getLoginRules();
        $messages = $this->getLoginMessages();

        $validator = Validator::make($data, $rules, $messages);

        if($validator->fails())
            return $this->getLoginPage($validator->getMessageBag()->first() );


        if(Auth::attempt(['username' => $data['username'], 'password' => $data['password']]) || Auth::attempt(['email' => $data['username'], 'password' => $data['password'] ]))
        {
            event(new createEventFromSessionEvent(Auth::user()->id));
            return $this->getLoginPage('success');
        }


        return $this->getLoginPage('Не найдено такого имени пользователя и пароля!');
    }

    /* Logout method */

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}