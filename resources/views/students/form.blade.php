@extends('layout.layout')

@section('title', 'Ученици')

@section('heading1', 'Ученици')

@section('content')

    <div class="col-md-6 offset-md-3">

        @include('layout.messages')

        <form method="post">
            <div class="form-group">
                <label>ЕГН</label>
                <input type="number" name="egn" class="form-control" placeholder="ЕГН на ученика"
                    @if(isset($student))
                        value="{{$student->egn}}"
                    @else
                       value="{{old('egn')}}"
                    @endif
                    >
            </div>
            <div class="form-group">
                <label>Име</label>
                <input type="text" name="first_name" class="form-control" placeholder="Име на ученика"
                    @if(isset($student))
                        value="{{$student->first_name}}"
                    @else
                        value="{{old('first_name')}}"
                    @endif
                    >
            </div>
            <div class="form-group">
                <label>Презиме</label>
                <input type="text" name="second_name" class="form-control" placeholder="Презиме на ученика"
                    @if(isset($student))
                        value="{{$student->second_name}}"
                    @else
                        value="{{old('second_name')}}"
                    @endif
                    >
            </div>
            <div class="form-group">
                <label>Фамилия</label>
                <input type="text" name="last_name" class="form-control" placeholder="Фамилия на ученика"
                    @if(isset($student))
                        value="{{$student->last_name}}"
                    @else
                        value="{{old('last_name')}}"
                    @endif
                    >
            </div>
            <div class="form-group">
                <label>Номер в клас</label>
                <input type="number" min="1" name="class_no" class="form-control" placeholder="Номер в клас"
                    @if(isset($student))
                        value="{{$student->class_no}}"
                    @else
                        value="{{old('class_no')}}"
                    @endif
                    >
            </div>
            <div class="form-group">
                <select name="class_id" class="form-control">
                    <option value="">Клас</option>
                    @if(Auth::guard('teacher')->check())
                        <option value="{{$classes->id}}"
                        @if(isset($student) && $student->class_id==$classes->id
                        || (old('class_id')==$classes->id)) {{'selected'}} @endif>
                            {{$classes->class .' '. $classes->class_section}}
                        </option>
                    @else
                        @foreach($classes as $class)
                            <option value="{{$class->id}}"
                            @if(isset($student) && $student->class_id==$class->id
                            || (old('class_id')==$class->id)) {{'selected'}} @endif>
                                {{$class->class_and_section}}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label>Потребителско име</label>
                <input type="text" name="username" class="form-control" placeholder="Потребителско име за вход в системата"
                    @if(isset($student))
                        value="{{$student->username}}"
                    @endif
                    >
            </div>
            <div class="form-group">
                <label>Парола</label>
                <input type="text" name="password" class="form-control" placeholder="Парола за достъп до системата"
                    @if(isset($student))
                        value="{{$student->password}}"
                    @else
                        value="{{old('password')}}"
                    @endif
                >
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea class="form-control" rows="4" maxlength="500" name="description" placeholder="Телефон, Адрес, ...">@if(isset($student)){{$student->description}}@else{{old('description')}}@endif</textarea>
            </div>

            @if(isset($student))
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