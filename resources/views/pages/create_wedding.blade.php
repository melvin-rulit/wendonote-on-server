
@extends('layouts.app', ['menu_selected' => 'home'])

@section('meta_title')WedNote ♥ создание свадебного блокнота ♥  @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤  @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно@endsection

@section('css_path')/css/wedcrt.css @endsection

@section('content')
    <div class="main">

        @include('layouts.mynote_bl')

            <div class="mn_cont">

                <div class="crt_wed"><h1>МОЙ БЛОКНОТ</h1></div>
                <div class="shrt_descr">
                    <h2>Организация торжества</h2>
                    <p>Каждой паре обязательно хочется, чтобы свадебное торжество
                        прошло идеально и необычно.<br>
                        Самостоятельно и без забот организовать торжество поможет WedNote.
                    </p>
                    <a class="bt_blue" href="manual.php" target="blanc">КАК ЭТО РАБОТАЕТ?</a>
                </div>

                <script type="text/javascript" src="../js/plchldr.js"></script>


                <div class="iv_form_start">

                        @if(count($errors) > 0)
                            <h3 style="color: red; text-align: center">{{ $errors->first() }}</h3>
                        @endif

                        <h2>Создать событие</h2>
                        <form action="{{route('wedding-create')}}" method="post">

                            <div class="inpnm names">НАЗВАНИЕ*</div>
                            <input type="text" name="name" value='{{old('name')}}' class="iv_frm_inpt" required placeholder="Введите название вашего события">

                            <div class="inpnm event">ВИД СОБЫТИЯ</div>
                            <!-- <select type="text" list="ev_type" name="event_type" value="{{old('event_type')}}"  required class="iv_frm_inpt2" placeholder="Введите или выберите вид вашего события"> -->
                            <select id="ev_type" name="event_type"  data-placeholder="Введите или выберите вид вашего события">
                                @foreach($event_types as $event_type)
                                    <option value="{{$event_type->name}}">{{$event_type->name}}</option>
                                @endforeach
                            </select>
                            <div class="inpnm dates">ДАТА</div>
                            <input type="text" name="date" value="{{old('date')}}" class="iv_frm_inpt date" required placeholder="дд.мм.гггг">
                            <!-- <input type="date" name="date" value="{{old('date')}}" class="iv_frm_inpt" required placeholder="дд.мм.гггг"> -->
                            <div class="inpnm city">ГОРОД</div>
                            <!-- <input type="text" list="ev_twn" name="city" value="{{old('city')}}" required   class="iv_frm_inpt2" placeholder="Введите или выберите город"> -->
                            <select id="ev_twn" name="city"  placeholder="Введите или выберите город">
                                @foreach($cities as $city)
                                    <option value="{{$city->name}}">{{$city->name}}</option>
                                @endforeach
                            </select>

                            {{csrf_field()}}

                            <button class="iv_frm_bt">ПРОДОЛЖИТЬ</button>

                        </form>
                </div>


            </div>

    </div>


    </body>
    </html>
@endsection





