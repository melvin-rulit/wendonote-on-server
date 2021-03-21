
@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ Мой блокнот ♥  @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно@endsection

@section('css_path')/css/mynote.css @endsection

@section('content')
<div class="main">

    @include('layouts.mynote_bl')

    <div class="mn_cont">

        @if (!Auth::check())

        <div class="shrt_descr">
            <h2><img src="/images/ico2.png" alt="image description">МОЙ БЛОКНОТ</h2>
            <p>
                Вы вошли на сайт как гость. Пройдите короткую и простую процедуру <a href="/registration.php">регистрации</a> или <a href="/enter.php">войдите</a> для полноценного использования WedNote
            </p>
            <a class="bt_blue" href="/manual.php" target="blanc">КАК ЭТО РАБОТАЕТ?</a>
        </div>

        <a href="{{route('joblist')}}" class="sp_del">
            <h3>cписок дел</h3>

            <div class="schal_del" title="прогресс"></div>

            <ul>
                <li>назначить дату свадьбы</li>
                <li>спланировать бюджет</li>
                <li>заказть кольца</li>
                <li>выбрать платье</li>
            </ul>
        </a>

        <a href="/enter.php" class="budjet">
            <div class="schal_budjet"></div>
            <h3>бюджет</h3>
        </a>

        <a href="{{ route('kalendar.index') }}" class="calend">
            <h3>календарь</h3>
            <ul>
                <li>08.08.2016</li>
                <li>168 дней</li>
                <li>12.12.2016</li>
            </ul>
        </a>

        <a href="{{route('visitors_list')}}" class="sp_guests">
            <h3>список гостей</h3>
        </a>

        <a href="/enter.php" class="calc_menu">
            <h3>расчёт меню</h3>
        </a>

        <a href="/enter.php" class="intrv_guests">
            <h3>опросы гостей</h3>
        </a>

        <a href="/enter.php" class="schedule">
            <h3>расписание</h3>
        </a>

        <a href="/enter.php" class="contacts_evt">
            <h3>контакты</h3>
        </a>

        <a href="/enter.php" class="notes_evt">
            <h3>заметки</h3>
        </a>

    </div>

        @else
    <div class="shrt_descr">
        <h2 class="mynotes">Мой блокнот</h2>
        <p>
            Здравствуйте <B>{{ Auth::user()->name }}</b>! Вы находитесь на странице блокнота
            <b>"{{Auth::user()->events()->first()['name']}}"</b> Мы внесли для вас самые необходимые списки дел и действий для вашего торжества. Вы можете их настроить, удалить или добавить.
        </p>
        <a class="bt_blue" href="manual.php" target="blanc">КАК ЭТО РАБОТАЕТ?</a>
    </div>

    <a href="{{route('joblist')}}" class="sp_del">
        <h3>cписок дел</h3>

        <div class="schal_del" title="прогресс"></div>

        <ul>
            <li>назначить дату свадьбы</li>
            <li>спланировать бюджет</li>
            <li>заказть кольца</li>
            <li>выбрать платье</li>
        </ul>
    </a>

    <a href="/budjet.php" class="budjet">
        <div class="schal_budjet"></div>
        <h3>бюджет</h3>
    </a>

    <a href="/" class="calend">
        <h3>календарь</h3>
        <ul>
            <li>08.08.2016</li>
            <li>168 дней</li>
            <li>12.12.2016</li>
        </ul>
    </a>

    <a href="{{route('visitors_list')}}" class="sp_guests">
        <h3>список гостей</h3>
    </a>

    <a href="/calc_menu.php" class="calc_menu">
        <h3>расчёт меню</h3>
    </a>

    <a href="/interviev_guests.php" class="intrv_guests">
        <h3>опросы гостей</h3>
    </a>

    <a href="/raspisanie.php" class="schedule">
        <h3>расписание</h3>
    </a>

    <a href="/contacts_evt.php" class="contacts_evt">
        <h3>контакты</h3>
    </a>

    <a href="/notes_evt.php" class="notes_evt">
        <h3>заметки</h3>
    </a>

        @endif
</div>

    </body>
    </html>

@endsection

