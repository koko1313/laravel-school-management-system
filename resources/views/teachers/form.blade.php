@extends('layout.layout')

@section('title', 'Учители')

@section('heading1', 'Учители')

@section('content')

    <div class="col-md-6 offset-md-3">

        @include('layout.messages')

        <form method="post">
            <div class="form-group">
                <label>Име</label>
                <input type="text" name="first_name" class="form-control" placeholder="Име на учителя"
                       @if(isset($teacher) && !old('first_name'))
                            value="{{$teacher->first_name}}"
                       @else
                            value="{{old('first_name')}}"
                       @endif
                        >
            </div>
            <div class="form-group">
                <label>Фамилия</label>
                <input type="text" name="last_name" class="form-control" placeholder="Фамилия на учителя"
                       @if(isset($teacher) && !old('last_name'))
                            value="{{$teacher->last_name}}"
                       @else
                            value="{{old('last_name')}}"
                       @endif
                        >
            </div>
            <div class="form-group">
                <label>Потребителско име</label>
                <input type="text" name="username" class="form-control" placeholder="Потребителско име за вход в системата"
                        @if(isset($teacher))
                            value="{{$teacher->username}}"
                        @else
                            value="{{old('username')}}"
                        @endif
                        >
            </div>
            <div class="form-group">
                <label>Парола</label>
                <input type="text" name="password" class="form-control" placeholder="Парола за достъп до системата"
                        @if(isset($teacher))
                            value="{{$teacher->password}}"
                        @endif
                        >
            </div>

            @if(isset($teacher))
                {{method_field('PUT')}}
                <button class="btn btn-warning"><i class="fas fa-edit"></i> Редактирай</button>
                <a href="{{route('teachers')}}" class="btn btn-outline-primary">Отказ</a>
            @else
                <button class="btn btn-primary"><i class="fas fa-save"></i> Въведи</button>
                <a href="{{route('teachers')}}" class="btn btn-outline-primary"><span class="glyphicon glyphicon-search"></span> Назад</a>
            @endif

            {{csrf_field()}}
        </form>
    </div>

@endsection