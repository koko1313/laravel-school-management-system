@extends('layout.layout')

@section('title', 'Учители')

@section('heading1', 'Учители')

@section('content')

    <div class="col-md">
        <a href="{{route('teachers.form')}}">Въвеждане на нов учител</a>
    
        @include('layout.messages')
    
        <div class="table-responsive">
            <table class="table-mobile table-mobile-teachers table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Име</th>
                    <th scope="col">Фамилия</th>
                    <th scope="col">Потребителско име</th>
                    <th scope="col">Действие</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                        <tr>
                            <td>{{$teacher->first_name}}</td>
                            <td>{{$teacher->last_name}}</td>
                            <td>{{$teacher->username}}</td>
                            <td>
                                <a href="{{route('teachers.edit', $teacher->id)}}"><i class="fas fa-edit"></i></a>
                                <a href="{{route('teachers.delete', $teacher->id)}}" onClick="return confirm('Изтриване на {{$teacher->username}}?')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection