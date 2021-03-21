@extends('layouts.app', ['menu_selected' => ''])

@section('meta_title')WedNote ♥ Список гостей ♥   @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно@endsection

@section('css_path')/css/ind.css @endsection

@section('extra_scripts')
    <script src="/js/pages/guests.js"></script>
@endsection

@section('content')

    <div class="main">

        @include('layouts.mynote_bl')


        <?php
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


        {{--

         <a href="#" class="reject pink tooltip-holder">
                                        <span class="tooltip">Отклонено</span>
                                        reject
                                    </a>

                                     <a href="#" class="refresh tooltip-holder">
                                        <span class="tooltip">Обновить</span>
                                        refresh
                                    </a>


        --}}


        <div class="mn_cont">
            <script>
                $('body').addClass('pink-bg');
            </script>
            <div class="guest-block">
                <h2>Список гостей</h2>
                <form action="#" class="guest-form">
                    <fieldset>
					<span class="total">
						Всего
						<span class="num" id="total-guest-count">{{\App\Guest::getGuestsNumber($event_id)}}</span>
					</span>
                        <div class="item">

                            <div class="row">
                                <h3>
                                    <div class="total-holder">
                                        <span class="total-text">ВСЕГО <span class="num" id="male-guest-count">{{\App\Guest::getGuestsNumberByGender($event_id, 'male')}}</span></span>
                                        <span class="status-ico minus">&nbsp;</span>
                                    </div>
                                    Жених
                                </h3>
                                <div class="input-holder">

                                    <?php
                                        $guest = \App\Guest::getGuests($event_id, 'male', 'married')
                                    ?>
                                    @if($guest == null)
                                        <input type="text" class="text guests-input new" gender="male" status="married" placeholder="Введите имя" >
                                    @else
                                        <input type="text" class="text guests-input" guestid="{{$guest->id}}"gender="male" status="married" placeholder="Введите имя" value="{{$guest->name}}" >
                                    @endif

                                </div>
                            </div>
                            <div class="row">
                                <h3>Свидетели</h3>

                                <?php
                                    $guests = \App\Guest::getGuests($event_id, 'male', 'witness')
                                ?>

                                @forelse($guests as $guest)
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input" gender="male" status="witness" guestid="{{$guest->id}}" value="{{$guest->name}}" placeholder="Введите имя гостя" required>
                                        {!!  $buttons  !!}
                                    </div>
                                @empty
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input new valid" gender="male" status="witness" placeholder="Введите имя гостя" required>
                                        {!!  $buttons  !!}
                                    </div>
                                @endforelse

                            </div>
                            <div class="row">
                                <h3>РОДСТВЕННИКИ ЖЕНИХА</h3>

                                <?php
                                    $guests = \App\Guest::getGuests($event_id, 'male', 'relatives')
                                ?>

                                @forelse($guests as $guest)
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input" gender="male" status="relatives" guestid="{{$guest->id}}" value="{{$guest->name}}" placeholder="Введите имя гостя" required>
                                        {!!  $buttons  !!}
                                    </div>
                                @empty
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input new" gender="male" status="relatives" placeholder="Введите имя гостя" required>
                                        {!!  $buttons  !!}
                                    </div>
                                @endforelse

                            </div>

                           {{-- <div class="row-total">
                                <span class="total-text">ВСЕГО <span class="num">28</span></span>
                            </div>--}}


                            <div class="row">
                                <h3>ДРУЗЬЯ ЖЕНИХА</h3>

                                <?php
                                    $guests = \App\Guest::getGuests($event_id, 'male', 'friends')
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
                        <div class="item pink">
                            <div class="row">
                                <h3>
                                    <div class="total-holder">
                                        <span class="total-text">ВСЕГО <span class="num" id="female-guest-count">{{\App\Guest::getGuestsNumberByGender($event_id, 'female')}}</span></span>
                                        <span class="status-ico minus">&nbsp;</span>
                                    </div>
                                    Невеста
                                </h3>
                                <div class="input-holder">
                                    <?php
                                        $guest = \App\Guest::getGuests($event_id, 'female', 'married')
                                    ?>
                                    @if($guest == null)
                                        <input type="text" class="text guests-input new" gender="female" status="married" placeholder="Введите имя" >
                                    @else
                                        <input type="text" class="text guests-input" gender="female" status="married" guestid="{{$guest->id}}" placeholder="Введите имя" value="{{$guest->name}}" >
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <h3>Свидетельницы</h3>

                                <?php
                                    $guests = \App\Guest::getGuests($event_id, 'female', 'witness')
                                ?>

                                @forelse($guests as $guest)
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input" gender="female" status="witness" guestid="{{$guest->id}}" value="{{$guest->name}}" placeholder="Введите имя гостя" required>
                                        {!!  $female_buttons !!}
                                    </div>
                                @empty
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input new valid" gender="female" status="witness" placeholder="Введите имя гостя" required>
                                        {!!  $female_buttons  !!}
                                    </div>
                                @endforelse

                            </div>
                            <div class="row">
                                <h3>РОДСТВЕННИКИ НЕВЕСТЫ</h3>
                                <?php
                                  $guests = \App\Guest::getGuests($event_id, 'female', 'relatives')
                                ?>

                                @forelse($guests as $guest)
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input" gender="female" status="relatives" guestid="{{$guest->id}}" value="{{$guest->name}}" placeholder="Введите имя гостя" required>
                                        {!!  $female_buttons !!}
                                    </div>
                                @empty
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input new" gender="female" status="relatives" placeholder="Введите имя гостя" required>
                                        {!!  $female_buttons  !!}
                                    </div>
                                @endforelse
                            </div>
{{--
                            <div class="row-total">
                                <span class="total-text">ВСЕГО <span class="num">28</span></span>
                            </div>--}}

                            <div class="row">
                                <h3>ДРУЗЬЯ НЕВЕСТЫ</h3>
                                <?php
                                $guests = \App\Guest::getGuests($event_id, 'female', 'friends')
                                ?>

                                @forelse($guests as $guest)
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input" gender="female" status="friends" guestid="{{$guest->id}}" value="{{$guest->name}}" placeholder="Введите имя гостя" required>
                                        {!!  $female_buttons !!}
                                    </div>
                                @empty
                                    <div class="input-holder">
                                        <input type="text" class="text guests-input new" gender="female" status="friends" placeholder="Введите имя гостя" required>
                                        {!!  $female_buttons  !!}
                                    </div>
                                @endforelse
                            </div>


                        </div>
                        {{--<div class="submit-row">
                            <button class="btn btn-pink">СОХРАНИТЬ</button>
                        </div>--}}
                    </fieldset>
                </form>
            </div>

        </div>

    </div>

    <div id="contacts-popup" style="display:none;">
        <h3>Контакты</h3>
        <span class="name">Владислав Пушка</span>
        <form class="contacts-form">
            <fieldset>
                <div class="form-row phone">
                    <input type="text" class="text" placeholder="телефон">
                    <span><img src="images/ico4.png" alt="image description"></span>
                    <a href="#" class="addto tooltip-holder">
                        <span class="tooltip">Добавить</span>
                        add
                    </a>
                </div>
                <div class="form-row email">
                    <input type="text" class="text" placeholder="email">
                    <span><img src="images/ico5.png" alt="image description"></span>
                    <a href="#" class="addto tooltip-holder">
                        <span class="tooltip">Добавить</span>
                        add
                    </a>
                </div>
                <div class="form-row viber">
                    <input type="text" class="text" placeholder="Viber">
                    <span><img src="images/viber.png" alt="image description"></span>
                    <a href="#" class="addto tooltip-holder">
                        <span class="tooltip">Добавить</span>
                        add
                    </a>
                </div>
                <div class="form-row telegram">
                    <input type="text" class="text" placeholder="Telegram">
                    <span><img src="images/telegram.png" alt="image description"></span>
                    <a href="#" class="addto tooltip-holder">
                        <span class="tooltip">Добавить</span>
                        add
                    </a>
                </div>
                <div class="form-row insta">
                    <input type="text" class="text" placeholder="instagram">
                    <span><img src="images/ico6.png" alt="image description"></span>
                    <a href="#" class="addto tooltip-holder">
                        <span class="tooltip">Добавить</span>
                        add
                    </a>
                </div>
                <div class="form-row facebook">
                    <input type="text" class="text" placeholder="facebook">
                    <span><img src="images/ico7.png" alt="image description"></span>
                    <a href="#" class="addto tooltip-holder">
                        <span class="tooltip">Добавить</span>
                        add
                    </a>
                </div>
<!--                 <div class="form-row vkontakte">
                    <input type="text" class="text" placeholder="vkontakte">
                    <span><img src="images/ico8.png" alt="image description"></span>
                    <a href="#" class="addto tooltip-holder">
                        <span class="tooltip">Добавить</span>
                        add
                    </a>
                </div>
                <div class="form-row od">
                    <input type="text" class="text" placeholder="однокласники">
                    <span><img src="images/ico9.png" alt="image description"></span>
                    <a href="#" class="addto tooltip-holder">
                        <span class="tooltip">Добавить</span>
                        add
                    </a>
                </div> -->
                <a href="#" rel="modal:close" class="btn btn-pink">добавить</a>
            </fieldset>
        </form>
    </div>


    {{--
        Register please modal
    --}}


    <div class="popup" id="register_modal" style="width: 400px; text-align: center; display: none;">
        <h3 style="display: inline;">Для сохранения данных необходима войти или зарегистрироваться</h3>
        <br>
        <a href="{{route('login')}}">Войти</a>
        <a href="{{route('wedding-create')}}">Зарегестрироваться</a>
    </div>


    </body>
    </html>

@endsection
