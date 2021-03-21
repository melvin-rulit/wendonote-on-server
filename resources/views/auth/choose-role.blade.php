@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ кто вы? ♥  @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно @endsection

@section('css_path')/css/reg.css @endsection

@section('content')

    <div class="main">
        @include('layouts.mynote_bl')

        <div class="mn_cont">
            <h1>Выберите вашу роль</h1>
            <a href="{{route('wedding-create')}}">Жених / Невеста</a> <br>
            <a href="#">Певец</a>
        </div>
    </div>

    </body>
    </html>
@endsection


