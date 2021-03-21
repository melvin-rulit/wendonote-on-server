<link href="/css/notebl.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/js/spl1.js"></script>

<div class="note">
    <a href="/mynote" class="mynote">Мой блокнот</a>
    <a href="" class="spl_bt1"></a>
    <div class="spldv1">
        <script type="text/javascript" src="../js/spl2.js"></script>
        <div class="spldv2">
            <!--===================== Список дел =====================-->
            <h3><a href="{{route('joblist')}}">список дел</a></h3>
            <p>
                @if(!Auth::check())
                    <a href="{{route('joblist')}}">назначить дату свадьбы</a><br>
                    <a href="{{route('joblist')}}">спланировать бюджет</a><br>
                    <a href="{{route('joblist')}}">заказать кольца</a><br>
                    <a href="{{route('joblist')}}">выбрать платье</a><br>
                    <a href="{{route('joblist')}}">составить список гостей</a><br>
                @else
                    <?php
                        $jobs = \App\Http\Controllers\JobsController::getTop5Jobs();
                    ?>

                    @foreach($jobs as $job)
                            <a href="{{route('joblist')}}">{{$job->name}}</a><br>
                        @endforeach

                @endif
            </p>

            <!--===================== Календарь =====================-->
            <h3><a href="{{route('kalendar.index')}}">календарь</a></h3>
            <p >
                @if(!Auth::check())
                    <a href="{{route('joblist')}}">назначить дату свадьбы</a><br>
                    <a href="{{route('joblist')}}">спланировать бюджет</a><br>
                @else
                <?php $calendars = \App\Http\Controllers\CalendarController::getTop5CalendarEvent(Auth::id());?>

<?php if ($calendars !== null): ?>
                        @foreach($calendars as $calendar)
                            <a href="/">{{$calendar->event}}</a><br>
                    @endforeach
<?php endif ?>

                @endif
            </p>

            <!--===================== Список гостей =====================-->
            <h3><a href="{{ route('visitors_list') }}">список гостей</a></h3>
            <p>
                <a href="$delo.php">назначить дату свадьбы</a><br>
                <a href="$delo.php">спланировать бюджет</a>
            </p>

            <!--===================== пригласительные =====================-->
            <h3><a href="/inivation">пригласительные</a></h3>
            <p>
                <a href="$delo.php">назначить дату свадьбы</a><br>
                <a href="$delo.php">спланировать бюджет</a>
            </p>

            <!--===================== Рассадка гостей =====================-->

            <h3><a href="#">рассадка гостей</a></h3>
            <p>
                <a href="$delo.php">назначить дату свадьбы</a><br>
                <a href="$delo.php">спланировать бюджет</a>
            </p>

            <!--===================== Расчёт меню =====================-->
            <h3><a href="{{route('menu.index')}}">расчёт меню</a></h3>
            <p>
            </p>

            <!--===================== Опросы гостей =====================-->
            <h3><a href="#">опросы гостей</a></h3>
            <p>
                <a href="$delo.php">назначить дату свадьбы</a><br>
                <a href="$delo.php">спланировать бюджет</a>
            </p>

            <!--===================== расписание =====================-->
            <h3><a href="/day">расписание</a></h3>
            <p>
                <a href="#">расписание дня</a><br>
            </p>

            <!--===================== контакты =====================-->
            <h3><a href="/contacts">контакты</a></h3>
            <p>
                <a href="$delo.php">назначить дату свадьбы</a><br>
                <a href="$delo.php">спланировать бюджет</a>
            </p>

            <!--===================== заметки =====================-->
            <h3><a href="{{route('notes')}}">заметки</a></h3>
            <p>
                <a href="#">добавить новую заметку</a><br>
            </p>

            <h3><a href="{{route('admin.index')}}" style="color: red;">Управление каталогом</a></h3>


        </div>
    </div>

    <div class="budget">
        <h3>БЮДЖЕТ</h3>
        <div class="bdg_shkala"></div>
    </div>

</div>







