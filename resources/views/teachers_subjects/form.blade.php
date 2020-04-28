@extends('layout.layout')

@section('title', 'Кой учител по какво преподава')

@section('heading1', 'Кой учител по какво преподава')

@section('content')

    <div class="col-md-6 offset-md-3">

        @include('layout.messages')

        <form method="post">
            <div class="form-group">
                <select name="subject_id" class="form-control">
                    <option value="">Предмет</option>
                    @foreach($subjects as $subject)
                        <option value="{{$subject->id}}"
                            @if(isset($teachers_subjects) && $teachers_subjects->subject_id==$subject->id
                            || (old('subject_id')==$subject->id)) {{'selected'}} @endif>
                            {{$subject->subject}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="teacher_id" class="form-control">
                    <option value="">Учител</option>
                    @foreach($teachers as $teacher)
                        <option value="{{$teacher->id}}"
                            @if(isset($teachers_subjects) && $teachers_subjects->teacher_id==$teacher->id
                            || (old('teacher_id')==$teacher->id)) {{'selected'}} @endif>
                            {{$teacher->first_name}} {{$teacher->last_name}}
                        </option>
                    @endforeach
                </select>
            </div>

            @if(isset($teachers_subjects))
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