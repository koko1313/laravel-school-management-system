@extends('layout.layout')

@section('title', 'Профил')

@section('heading1', 'Профил')

@section('content')

    <div class="col-md-6 offset-md-3">

        @if(isset($student))
            <h2>Ученик</h2>
            <strong>Име:</strong> {{$student->first_name}}<br>
            <strong>Презиме:</strong> {{$student->second_name}}<br>
            <strong>Фамилия:</strong> {{$student->last_name}}<br>
            <strong>Номер в клас:</strong> {{$student->class_no}}<br>
            <strong>Клас:</strong> {{$student->class_and_section}}<br>
            <strong>Випуск:</strong> {{$student->graduating_year}}<br>
            <strong>Класен ръководител:</strong> {{$student->class_teacher}}
        @elseif(isset($class_teacher))
            <h2>Класен ръководител</h2>
            <strong>Име:</strong> {{$class_teacher->first_name}}<br>
            <strong>Фамилия:</strong> {{$class_teacher->last_name}}<br>
            <strong>Клас:</strong> {{$class_teacher->class}}<br>
        @elseif(isset($teacher))
            <h2>Учител</h2>
            <strong>Име:</strong> {{$teacher->first_name}}<br>
            <strong>Фамилия:</strong> {{$teacher->last_name}}<br>
        @elseif(isset($administrator))
            <h2>Администратор</h2>
        @endif

    </div>

@endsection