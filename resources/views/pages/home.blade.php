
@extends('layouts.app', ['menu_selected' => 'home'])

@section('meta_title')WedNote ♥ регистрация ♥  @endsection
@section('meta_description')✎  Первый в Украине организатор свадьбы онлайн. Всё, что необходимо для организации идеальной свадьбы ⚤ @endsection
@section('meta_keywords')блокнот, свадебный, организатор, органайзер, самостоятельно@endsection

@section('css_path')/css/ind.css @endsection

@section('content')
<div class="main">

    @include('layouts.mynote_bl')


    <div class="crtbt">
        <a href="{{route('wedding-create')}}"> создать мой блокнот</a>
        <a href="katalogreg.php">добавить в каталог</a>
    </div>
    <!--============================ Лид блоки ===========================-->
    <div class="lidspan">

        <div class="lid_dv">

            <div class="ch-item">
                <div class="ch-info-wrap">
                    <div class="ch-info">
                        <div class="ch-info-front ldbl1">
                            <img class="imgL" src="images/img1.jpg"> <h2>невесты</h2>
                            <p>
                                12.08.2015 Продумать
                                и обсудь стиль
                                и тематику свадьбы.
                                18.08.2015 Составить
                                список гостей.
                            </p>
                        </div>
                        <div class="ch-info-back ldbl1">
                            <h2>невесты</h2>
                            <p>
                                12.08.2015 Продумать
                                и обсудь стиль
                                и тематику свадьбы.
                                18.08.2015 Составить
                                список гостей.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="lid_dv">

            <div class="ch-item">
                <div class="ch-info-wrap">
                    <div class="ch-info">
                        <div class="ch-info-front ldbl2">
                            <img class="imgL" src="images/img2.jpg"> <h2>артисты</h2>
                            <p>
                                Заказать артистов на свадьбу
                            </p>
                        </div>
                        <div class="ch-info-back ldbl2">
                            <h2>артисты</h2>
                            <p>
                                Заказать артистов на свадьбу
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="lid_dv">

            <div class="ch-item">
                <div class="ch-info-wrap">
                    <div class="ch-info">
                        <div class="ch-info-front ldbl3">
                            <img class="imgR" src="images/img4.jpg"> <h2>торты</h2>
                            <p>
                                Заказать свадебный торт в Одессе
                            </p>
                        </div>
                        <div class="ch-info-back ldbl3">
                            <h2>торты</h2>
                            <p>
                                Заказать свадебный торт в Одессе
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="lid_dv">

            <div class="ch-item">
                <div class="ch-info-wrap">
                    <div class="ch-info">
                        <div class="ch-info-front ldbl4">
                            <img class="imgR" src="images/img6.jpg"> <h2>выездная регистрация</h2>
                            <p>
                                Организация выездных регистраций в Одессе
                            </p>
                        </div>
                        <div class="ch-info-back ldbl4">
                            <h2>выездная регистрация</h2>
                            <p>
                                Организация выездных регистраций в Одессе
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="lid_dv">

            <div class="ch-item">
                <div class="ch-info-wrap">
                    <div class="ch-info">
                        <div class="ch-info-front ldbl5">
                            <img class="imgL" src="images/img3.jpg"> <h2>Банктеные залы</h2>
                            <p>
                                Каталог банкетных залов в Одессе
                            </p>
                        </div>
                        <div class="ch-info-back ldbl5">
                            <h2>Банктеные залы</h2>
                            <p>
                                Каталог банкетных залов в Одессе
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="lid_dv">

            <div class="ch-item">
                <div class="ch-info-wrap">
                    <div class="ch-info">
                        <div class="ch-info-front ldbl6">
                            <img class="imgL" src="images/img5.jpg"> <h2>Last News</h2>
                            <p>
                                Последние новости и события WedNote
                            </p>
                        </div>
                        <div class="ch-info-back ldbl6">
                            <h2>Last News</h2>
                            <p>
                                Последние новости и события WedNote
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>



</div>


</body>
</html>
@endsection



