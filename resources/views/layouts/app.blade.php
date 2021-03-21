<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {{-- Dynamic stuff for the template load --}}
    <title>@yield('meta_title')</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">

    <link href="@yield('css_path')" rel="stylesheet" type="text/css">

    <link rel="shortcut icon" href="../img/favicon.ico" />
    <link href="/css/main.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/jquery.modal.css">

    <script>
        var isAuth = {{Auth::check() == true ? 'true' : 'false'}};
            window.laravel = {'csrfToken': '{{csrf_token()}}'};
    </script>

    <script src="/js/libs/jquery-1.10.2.min.js"></script>
    <script src="/js/libs/datepicker.js"></script>
    <script src="/js/libs/slick.min.js"></script>
    <script src="/js/libs/jquery.modal.js"></script>
    <script src="/js/libs/jquery.mask.min.js"></script>
    <script src="/js/libs/jquery.numeric.min.js"></script>
    <script src="/js/libs/select2.full.min.js"></script>
    <script src="/js/libs/jquery-ui.min.js"></script>
    <script src="/js/libs/tooltip.js"></script>

    <script src="/js/pages/misc.js"></script>

    @yield('extra_scripts')

</head>

<body lang="ru">
<div class="head">
    <a href="/" class="logo">WedNote</a>
    <div class="soc">
        <a href="vk......" target="_blank" class="vk"></a>
        <a href="fb......" target="_blank" class="fb"></a>
        <a href="yt......" target="_blank" class="yt"></a>
        <a href="ig......" target="_blank" class="ig"></a>
        <a href="tw......" target="_blank" class="t w"></a>
        <a href="gp......" target="_blank" class="gp"></a>
    </div>

    @if(!Auth::check())
        <a href='{{route('choose-role')}}' class='door'>регистрация</a>
        <a href='{{route('login')}}' class='door'>войти</a>
    @else
        <form action="{{route('logout')}}" method="get">
            <button class="exit" title="выйти"></button>
        </form>
        <a href="/mypage" class="door" title="мой профиль">{{Auth::user()->username}}</a>
        <a href="{{route('mynote')}}" class="door" title="мое событие"> {{ \Illuminate\Support\Facades\Auth::user()->events()->first()['name'] }}</a>

    @endif
@include('layouts.menu', ['selected' => $menu_selected])
</div>


@yield('content')