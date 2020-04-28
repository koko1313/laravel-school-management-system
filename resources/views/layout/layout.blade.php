<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="text/css" rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::asset('css/font-awesome-all.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::asset('css/jquery-ui.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::asset('css/style.css')}}">

    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{URL::asset('images/favicon.png')}}">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <script src="{{URL::asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{URL::asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{URL::asset('js/popper.min.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/script.js')}}"></script>
</head>
<body>

<!-- div class wrapper ни е нужно за sticky-footerа -->
<div class="wrapper"> 
    <div class="container-fluid">
        @include('layout.nav')
    </div>

    <div class="container">

        <h1>@yield('heading1')</h1>

        <div class="row">
            @yield('content')
        </div>
    </div>

    <div class="push"></div>
</div>

<footer class="container-fluid text-center">
    <p>{{$school_name}}</p>
</footer>

<!--
<div class="container">
    <p class="float-left"><em><small>Разработил: <a href="https://www.facebook.com/kaloyanvelichkov" target="_blank">Калоян Величков</a></small></em></p>
    <p class="float-right"><em><small>Версия: 2.0</small></em></p>
</div>
-->

</body>
</html>