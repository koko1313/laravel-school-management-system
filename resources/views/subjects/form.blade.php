@extends('layout.layout')

@section('title', 'Предмети')

@section('heading1', 'Предмети')

@section('content')

    <div class="col-md-6 offset-md-3">

        @include('layout.messages')

        <form method="post">
            <div class="form-group">
                <label>Предмет</label>
                <input type="text" name="subject_name" class="form-control" placeholder="Наименование на учебен предмет"
                    @if(isset($subject))
                        value="{{$subject->subject}}"
                    @else
                       value="{{old('subject_name')}}"
                    @endif
                    >
            </div>

            @if(isset($subject))
                {{method_field('PUT')}}
                <button class="btn btn-warning"><i class="fas fa-edit"></i> Редактирай</button>
                <a href="{{URL::previous()}}" class="btn btn-outline-primary">Отказ</a>
            @else
                <button class="btn btn-primary"><i class="fas fa-save"></i> Въведи</button>
                <a href="{{URL::previous()}}" class="btn btn-outline-primary"><span class="glyphicon glyphicon-search"></span> Назад</a>
            @endif

            {{csrf_field()}}
        </form>
    </div>

@endsection