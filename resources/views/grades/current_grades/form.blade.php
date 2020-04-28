@extends('layout.layout')

@section('title', 'Текущи оценки')

@section('heading1', 'Текущи оценки')

@section('content')

    <div class="col-md-6 offset-md-3">

        @include('layout.messages')

        <form method="post">
            <div class="form-group">
                <b>Ученик:</b> {{$student->first_name .' '. $student->second_name .' '. $student->last_name}}
                <input type="hidden" name="student_egn" value="{{$student->egn}}">
            </div>

            <div class="form-group">
                <b>Предмет: </b> {{$subject->subject}}
                <input type="hidden" name="subject_id" value="{{$subject->id}}">
            </div>

            <div class="form-group">
                @if(isset($grade))
                    <label>За клас: <b>{{$for_class}}</b></label>
                    <input type="hidden" name="for_class" value="{{$for_class}}">
                @endif
            </div>

            @if(isset($grade_id))
                <div class="form-group">
                    <label>За клас: <b>{{$for_class}}</b></label>
                    <input type="hidden" name="for_class" value="{{$for_class}}">
                </div>
            @endif

            <div class="form-group">
                @if(isset($grade_id))
                    <label>Срок: <b>{{$for_term_label}}</b></label>
                    <input type="hidden" name="for_term_id" value="{{$for_term_id}}">
                @else
                    <label>Срок: <b>{{$term_now->term_label}}</b></label>
                @endif
            </div>

            <div class="form-group">
                <label>Оценка:</label>
                <div class="form-group text-center">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        @foreach($grades as $g)
                            <!-- При edit ако е избрана оценката -->
                            @if(isset($grade_id) && $grade_id == $g->id || (old('grade_id')==$g->id))
                                <label class="btn btn-outline-primary btn-lg btn-grades active">
                                    <input type="radio" name="grade_id" autocomplete="off" value="{{$g->id}}" checked> {{$g->grade}}
                                </label>
                            @else
                                <label class="btn btn-outline-primary btn-lg btn-grades">
                                    <input type="radio" name="grade_id" autocomplete="off" value="{{$g->id}}"> {{$g->grade}}
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
                @if(isset($grade_id))
                    <input type="hidden" name="grade_id_old" value="{{$grade_id}}">
                @endif
            </div>

            @if(isset($grade_id))
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