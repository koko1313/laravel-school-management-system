@extends('layout.layout')

@section('title', 'На кой клас кои учители преподават')

@section('heading1', 'На кой клас кои учители преподават')

@section('content')

<div class="col-md">
    <a href="{{route('class_teachers.form')}}">Въвеждане на нов клас-учител</a>

    @include('layout.messages')

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">Клас</th>
            <th scope="col">Учител</th>
            <th scope="col">Действие</th>
        </tr>
        </thead>
        <tbody>
        @foreach($class_teachers as $class_teacher)
            <tr>
                <td>{{$class_teacher->class_and_section}}</td>
                <td>{{$class_teacher->teacher}}</td>
                <td>
                    <a href="{{route('class_teachers.edit', [$class_teacher->class_id, $class_teacher->teacher_id])}}"><i class="fas fa-edit"></i></a>
                    <a href="{{route('class_teachers.delete', [$class_teacher->class_id, $class_teacher->teacher_id])}}" onClick="return confirm('Изтриване на разпределението?')"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$class_teachers->links()}}
</div>

@endsection