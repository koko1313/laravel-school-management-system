@extends('layout.layout')

@section('title', 'Класове')

@section('heading1', 'Класове')

@section('content')

    <div class="col-md">
        <a href="{{route('classes.form')}}">Въвеждане на нов клас</a>

        @include('layout.messages')

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Клас</th>
                    <th scope="col">Паралелка</th>
                    <th scope="col">Класен ръководител</th>
                    <th scope="col">Завършил</th>
                    <th scope="col">Випуск</th>
                    <th scope="col">Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($classes as $class)
                    <tr>
                        <td>{{$class->class}}</td>
                        <td>{{$class->class_section}}</td>
                        <td>{{$class->class_teacher}}</td>
                        <td>
                            @if($class->is_graduated) {{"Да"}}
                            @else {{"Не"}}
                            @endif
                        </td>
                        <td>{{$class->graduating_year}}</td>
                        <td>
                            <a href="{{route('classes.edit', $class->id)}}"><i class="fas fa-edit"></i></a>
                            <a href="{{route('classes.delete', $class->id)}}" onClick="return confirm('Изтриване на {{$class->class . $class->class_section}} клас?\nЩе бъдат изтрити всички ученици от този клас, заедно с техните оценки!')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{$classes->links()}}
    </div>

@endsection