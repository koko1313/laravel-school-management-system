@extends('layout.layout')

@section('title', 'Кой учител по какво преподава')

@section('heading1', 'Кой учител по какво преподава')

@section('content')

    <div class="col-md">
        <a href="{{route('teachers_subjects.form')}}">Въвеждане на нов учител-предмет</a>

        @include('layout.messages')

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">Предмет</th>
                <th scope="col">Преподавател</th>
                <th scope="col">Действие</th>
            </tr>
            </thead>
            <tbody>
            @foreach($teachers_subjects as $ts)
                <tr>
                    <td>{{$ts->subject}}</td>
                    <td>{{$ts->teacher}}</td>
                    <td>
                        <a href="{{route('teachers_subjects.edit', [$ts->subject_id, $ts->teacher_id])}}"><i class="fas fa-edit"></i></a>
                        <a href="{{route('teachers_subjects.delete', [$ts->subject_id, $ts->teacher_id])}}" onClick="return confirm('Изтриване на разпределението?')"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{$teachers_subjects->links()}}
    </div>

@endsection