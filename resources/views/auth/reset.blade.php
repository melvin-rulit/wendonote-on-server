@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ восстановление пароля ♥  @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно @endsection

@section('css_path')/css/reg.css @endsection

@section('content')

    <div class="main">
        @include('layouts.mynote_bl')

        <div class="mn_cont">

            <script type="text/javascript" src="../js/plchldr.js"></script>

            @if(count($errors) == 0)
                <div class="reg_form">
                    <h2>Новый пароль</h2>
                    <form action="{{ route('new_password') }}" method="post">
                        <input type="password" name="password" class="reg_npt" placeholder="пароль">
                        <input type="password" name="password_confirmation" class="reg_npt" placeholder="повторите пароль">

                        <input type="hidden" name="email" value="{{$email}}">
                        <input type="hidden" name="token" value="{{$token}}">

                        {{csrf_field()}}

                        <button class="reg_bt">Восстановить</button>

                    </form>
                </div>
            @else
                <div class='reg_form'>
                    <div style='padding-top:100px;'>
                        <h2>{{$errors->first()}}</h2>
                        <a class='back_bt' href='{{route('new_password')."?token=".$token."&email=".$email}}'>⬅ НАЗАД</a>
                    </div>
                </div>
            @endif


        </div>
    </div>

    </body>
    </html>
@endsection
