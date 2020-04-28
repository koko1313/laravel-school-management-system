@extends('layout.layout')

@section('title', 'Класове')

@section('heading1', 'Класове')

@section('content')

    <div class="col-md-6 offset-md-3">

        @include('layout.messages')

        <form method="post">
            <div class="form-group">
                <label>Клас</label>
                <input type="number" min="1" max="12" name="class" class="form-control" placeholder="Клас (с цифри)"
                   @if(isset($class))
                       value="{{$class->class}}"
                   @else
                       value="{{old('class')}}"
                   @endif

                    >
            </div>

            <div class="form-group">
                <label>Паралелка</label>
                <input type="text" maxlength="1" name="class_section" class="form-control" style="text-transform:uppercase" placeholder="Паралелка"
                    @if(isset($class))
                        value="{{$class->class_section}}"
                    @else
                        value="{{old('class_section')}}"
                    @endif
                    >
            </div>

            <div class="form-group">
                <select name="class_teacher_id" class="form-control">
                    <option value="">Класен ръководител</option>
                    @foreach($teachers as $teacher)
                        <option value="{{$teacher->id}}"
                            @if(isset($class) && $class->class_teacher_id==$teacher->id
                            || (old('class_teacher_id')==$teacher->id)) {{'selected'}} @endif>
                            {{$teacher->first_name}} {{$teacher->last_name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Випуск</label>
                <input type="text" name="graduating_year" class="form-control" placeholder="Випуск"
                    @if(isset($class))
                        value="{{$class->graduating_year}}"
                    @else
                        value="{{old('graduating_year')}}"
                    @endif
                    >
            </div>

            @if(isset($class))
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