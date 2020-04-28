@extends('layout.layout')

@section('title', 'Ученици')

@section('heading1', 'Ученици')

@section('content')

    <div class="col-md">
        <a href="{{route('students.form')}}">Въвеждане на нов ученик</a>
    
        @include('layout.messages')

        <div class="table-responsive">
            <table id="filteredTable" class="table-mobile table-mobile-students table table-striped table-hover table-hover-pointer">
                <thead>
                <tr>
                    <th scope="col">ЕГН</th>
                    <th scope="col">Име</th>
                    <th scope="col">Презиме</th>
                    <th scope="col">Фамилия</th>
                    <th scope="col">Номер в клас</th>
                    <th scope="col">Клас</th>
                    <th scope="col">Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr data-toggle="modal" data-target="#studentDescriptionModal{{$student->egn}}" onClick="e.stopPropagation()">
                        <td>{{$student->egn}}</td>
                        <td>{{$student->first_name}}</td>
                        <td>{{$student->second_name}}</td>
                        <td>{{$student->last_name}}</td>
                        <td>{{$student->class_no}}</td>
                        <td>{{$student->class_and_section}}</td>
                        <td>
                            <a href="{{route('students.edit', $student->egn)}}"><i class="fas fa-edit"></i></a>
                            <a href="{{route('students.delete', $student->egn)}}" onClick="return confirm('Изтриване на {{$student->egn}}?\nЩе бъдат изтрити и всички оценки за този ученик!')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $students->links() }}
    </div>

    @foreach($students as $student)
        <div class="modal fade" id="studentDescriptionModal{{$student->egn}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{$student->first_name .' '. $student->second_name .' '. $student->last_name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <pre>
                        <b>Име:</b> {{$student->first_name}}
                        <b>Презиме:</b> {{$student->second_name}}
                        <b>Фамилия:</b> {{$student->last_name}}
                        <b>ЕГН:</b> {{$student->egn}}
                        <b>Номер в клас:</b> {{$student->class_no}}
                        <b>Клас:</b> {{$student->class_and_section}}
                        <b>Випуск:</b> {{$student->graduating_year}} @if($student->is_graduated) - <b style="color: red">Завършил</b> @endif 
                        <b>Потребителско име:</b> {{$student->username}}
                        <b>Описание:</b>
                        {{$student->description}}
                    </pre>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-warning" href="{{route('students.edit', $student->egn)}}"><i class="fas fa-edit"></i> Редактирай</a>
                    <a class="btn btn-danger" href="{{route('students.delete', $student->egn)}}" onClick="return confirm('Изтриване на {{$student->egn}}?\nЩе бъдат изтрити и всички оценки за този ученик!')"><i class="fas fa-trash-alt"></i> Изтрий</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                </div>
            </div>
        </div>
        </div>
    @endforeach

@endsection