@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ Список гостей ♥   @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно@endsection

@section('css_path')/css/ind.css @endsection

@section('extra_scripts')
    <script src="/js/pages/contacts.js"></script>
@endsection

@section('content')

    <div class="main">

        @include('layouts.mynote_bl')

                <?php

    if (Auth::user()) {
        $event_id = Auth::user()->events()->first()->id;
    }else{
        $event_id = 6;
    }

            $buttons = '<a href="#" class="add tooltip-holder">
                            <span class="tooltip">Добавить</span>
                            add
                        </a>

                        <a href="#" class="check tooltip-holder">
                            <span class="tooltip">Подтверждено</span>
                            check
                        </a>

                        <a href="#" class="edit contactsModalOpener tooltip-holder">
                            <span class="tooltip">Добавить/редактировать контакты</span>
                            edit
                        </a>';

            $female_buttons = '
                <a href="#" class="add tooltip-holder">
                                        <span class="tooltip">Добавить</span>
                                        add
                                    </a>
                                    <a href="#" class="check pink tooltip-holder">
                                        <span class="tooltip">Подтверждено</span>
                                        check
                                    </a>
                                    <a href="#" class="edit contactsModalOpener pink tooltip-holder">
                                        edit
                                        <span class="tooltip">Добавить/редактировать контакты</span>
                                    </a>';

        ?>

        <div class="mn_cont">
            <div class="guest-block">
                <h2>Контакты</h2>
                <form action="#" class="guest-form">
                    <fieldset>
                        <div class="item">
                            <div class="row">
                                <h3>КОНТАКТЫ ИЗ СПИСКА ГОСТЕЙ</h3>

                                <?php
                                    $guests = \App\Contact::getGuestContact($event_id);
                                ?>

                                @forelse($guests as $guest)
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input" gender="male" status="friends" guestid="{{$guest->id}}" value="{{$guest->name}}" placeholder="Введите имя гостя" required>
                                        {!!  $buttons  !!}
                                    </div>
                                @empty
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input new" gender="male" status="friends" placeholder="Введите имя гостя" required>
                                        {!!  $buttons  !!}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <h3>ДОБАВЛЕННЫЕ КОНТАКТЫ</h3>

                                <?php
                                    $contacts = \App\Contact::getContact($event_id);
                                ?>

                                @forelse($contacts as $contact)
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input" gender="male" status="friends" guestid="{{$contact->id}}" value="{{$contact->name}}" placeholder="Введите имя гостя" required>
                                        {!!  $female_buttons  !!}
                                    </div>
                                @empty
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input new" gender="male" status="friends" placeholder="Введите имя гостя" required>
                                        {!!  $female_buttons  !!}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>

       


    <div class="popup" id="register_modal" style="width: 400px; text-align: center; display: none;">
        <h3 style="display: inline;">Для сохранения данных необходима войти или зарегистрироваться</h3>
        <br>
        <a href="{{route('login')}}">Войти</a>
        <a href="{{route('wedding-create')}}">Зарегестрироваться</a>
    </div>

    </body>
    </html>

@endsection
