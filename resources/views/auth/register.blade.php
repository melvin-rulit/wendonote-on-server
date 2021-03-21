@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ регистрация ♥  @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно @endsection

@section('css_path')/css/reg.css @endsection

@section('content')

    <div class="main">
        @include('layouts.mynote_bl')

        <div class="mn_cont">

            <div class="shrt_descr">
                <h2>Регистрация</h2>
                <p>
                    Пройдите короткую и простую процедуру регистрации для полноценного использования WedNote
                </p>
                <a class="bt_blue" href="manual.php" target="blanc">КАК ЭТО РАБОТАЕТ?</a>
            </div>

            <script type="text/javascript" src="../js/plchldr.js"></script>

            @if($message == null)
                <div class="reg_form">
                    <h2>Регистрация</h2>
                    <form action="{{route('post-register')}}" method="post">
                        <input type="text" name="username" class="reg_npt" placeholder="логин" title="Принимаются только латинские буквы" required>
                        <input type="password" name="password" class="reg_npt" placeholder="пароль" title="Пароль должен состоять минимум из 6ти символов" required>
                        <input type="text" name="email" class="reg_npt" placeholder="email" title="Введите e-mail" required>

                        {{csrf_field()}}

                        <button class="reg_bt">РЕГИСТРАЦИЯ</button>
                    </form>

                    <a href="{{route('recovery')}}" class="recover">забыли пароль?</a>

                    <hr>

                    <span class="title">
                        Уже зарегистрированы? <a href="{{route('login')}}" class="enter">ВОЙТИ</a>
                    </span>
                </div>
            @elseif($message != 'success')
                <div class='reg_form'>
                    <div style='padding-top:100px;'>
                        <h2>{{ $message }}</h2>
                        <a class='back_bt' href='javascript:history.back()'>⬅ НАЗАД</a>
                        <a href="{{route('recovery')}}" class="recover">забыли пароль?</a>
                    </div>
                </div>
                @else

                <div class='reg_form'>
                    <div style='padding-top:100px;'>
                        <h2>Регистрация прошла успешно, через 2 секунды вы будете переадресованы</h2>
                        <script>
                            setTimeout(function () {
                                window.location.href='{{ route('wedding-create') }}';
                            }, 2000);
                        </script>
                    </div>
                </div>

            @endif

        </div>
    </div>

    </body>
    </html>
@endsection



