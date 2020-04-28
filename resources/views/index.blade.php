@extends('layout.layout')

@section('title', 'Начало')

@section('heading1'){{$school_name}}@endsection

@section('content')

    <div class="col-md-7 order-md-2">

        @include('layout.messages')

        @if(!Auth::guard('administrator')->check() && !Auth::guard('teacher')->check() && !Auth::guard('student')->check())
            <h2>Вход</h2>
            <form method="post" action="{{route('login')}}">
                <div class="form-group">
                    <label for="username">Потребителско име</label>
                    <div class="input-group mb-2 mb-sm-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <input type="text" name="username" class="form-control" value="" placeholder="Потребителско име" id="username">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Парола</label>
                    <div class="input-group mb-2 mb-sm-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        <input type="password" name="password" class="form-control" value="" placeholder="Парола" id="password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
                    <script src='https://www.google.com/recaptcha/api.js'></script>
                </div>

                <button class="btn btn-primary form-control">Вход <i class="fas fa-sign-out-alt"></i></button>
                {{csrf_field()}}
            </form>
        @else
            <h2>Добре дошли!</h2>
        @endif
    </div>

    <div class="col-md-5 order-md-1">
        <p><pre>{{$school_description}}</pre></p>
        <img class="rounded img-fluid" src="{{URL::asset('images/school_picture.jpg')}}">
    </div>

@endsection