@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ вход ♥  @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно @endsection

@section('css_path')/css/reg.css @endsection

@section('content')

    <div class="main">
        @include('layouts.mynote_bl')

        <div class="mn_cont">

            <script type="text/javascript" src="../js/plchldr.js"></script>

            @if($message == null)
            <div class="reg_form">
                <h2>Вход</h2>
                <form action="{{ route('post-login') }}" method="post">
                    <input type="text" name="username" class="reg_npt" placeholder="логин">
                    <input type="password" name="password" class="reg_npt" placeholder="пароль">

                    {{ csrf_field() }}

                    <button class="reg_bt">ВХОД</button>
                </form>
                <a href="{{ route('choose-role') }}" class="recover">регистрация</a>
                <br>
                <a href="{{ route('recovery') }}" class="recover">забыли пароль?</a>

                @elseif($message != 'success')
                    <div class='reg_form'>
                        <div style='padding-top:100px;'>
                            <h2>{{ $message }}</h2>
                            <a class='back_bt' href='javascript:window.history.back()'>⬅ НАЗАД</a>
                        </div>
                    </div>
                @else
                    <div class='reg_form'>
                        <div style='padding-top:100px;'>
                            <h2>Вы успешно вошли, через 2 секунды вы будете переадресованы на главную страницу</h2>
                            <script>
                                setTimeout(function () {
                                    window.location.href='/';
                                }, 2000);
                            </script>
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>

    </body>
    </html>
@endsection


