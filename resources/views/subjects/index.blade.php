@extends('layout.layout')

@section('title', 'Предмети')

@section('heading1', 'Предмети')

@section('content')

    <div class="col-md">
        <a href="{{route('subjects.form')}}">Въвеждане на нов предмет</a>

        @include('layout.messages')

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Предмет</th>
                    <th scope="col">Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subjects as $subject)
                    <tr>
                        <td>{{$subject->subject}}</td>
                        <td>
                            <a href="{{route('subjects.edit', $subject->id)}}"><i class="fas fa-edit"></i></a>
                            <a href="{{route('subjects.delete', $subject->id)}}" onClick="return confirm('Изтриване на {{$subject->subject}}?')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $subjects->links() }}
    </div>

@endsection