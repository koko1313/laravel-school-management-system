@extends('layout.layout')

@section('title', 'На кой клас кои учители преподават')

@section('heading1', 'На кой клас кои учители преподават')

@section('content')

    <div class="col-md-6 offset-md-3">

        @include('layout.messages')

        <form method="post">
            <div class="form-group">
                <select name="class_id" class="form-control">
                    <option value="">Клас</option>
                    @foreach($classes as $class)
                        <option value="{{$class->id}}"
                            @if(isset($class_teachers) && $class_teachers->class_id==$class->id
                            || (old('class_id')==$class->id)) {{'selected'}} @endif>
                            {{$class->class_and_section}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="teacher_id" class="form-control">
                    <option value="">Учител</option>
                    @foreach($teachers as $teacher)
                        <option value="{{$teacher->id}}"
                            @if(isset($class_teachers) && $class_teachers->teacher_id==$teacher->id
                            || (old('teacher_id')==$teacher->id)) {{'selected'}} @endif>
                            {{$teacher->first_name .' '. $teacher->last_name}}
                        </option>
                    @endforeach
                </select>
            </div>

            @if(isset($class_teachers))
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