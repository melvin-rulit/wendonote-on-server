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

            @if(count($errors) == 0 && $success == null)
            <div class="reg_form">
                <h2>Восстановить пароль</h2>
                <form action="{{route('recovery')}}" method="post">
                    <input type="email" name="email" class="reg_npt" placeholder="email" required>
                    <hr>

                    {{csrf_field()}}

                    <button class="reg_bt">Восстановить</button>
                </form>
                @elseif(count($errors) > 0)
                    <div class='reg_form'>
                        <div style='padding-top:100px;'>
                            <h2>{{$errors->first()}}</h2>
                            <a class='back_bt' href='{{route('recovery')}}'>⬅ НАЗАД</a>
                        </div>
                    </div>
                    @elseif($success != null)
                    <div class='reg_form'>
                        <div style='padding-top:100px;'>
                            <h2>{{$success}}</h2>
                            <a class='back_bt' href='{{route('home')}}'>⬅ НАЗАД</a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    </body>
    </html>
@endsection
