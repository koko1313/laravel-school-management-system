@extends('layout.layout')

@section('title', 'Текущи оценки')

@section('heading1', 'Текущи оценки')

@section('content')
<div class="col">
    @include('grades.table_filter')

    @include('layout.messages')

    <table id="filteredTable" class="table table-striped table-hover">
        <thead>
            <tr>
                @if(!Auth::guard('student')->check())
                    <th scope="col">№</th>
                    <th scope="col">Ученик</th>
                @else
                    <th scope="col">Предмет</th>
                @endif

                <th scope="col">Оценки</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($all_grades as $grade)
                <tr>
                    @if(!Auth::guard('student')->check())
                        <td>{{$grade->class_no}}</td>
                        <td>{{$grade->student_name}}</td>
                    @else
                        <td>{{$grade->subject}}</td>
                    @endif

                    <td class="grades">
                        @for($i=0,
                            $grades = explode(',', $grade->grade),
                            $grades_id = explode(',', $grade->grade_id),
                            $created_at = explode(',', $grade->created_at);
                            $i<sizeof(explode(',', $grade->grade));
                            $i++)
                        <div class="grade">
                            @if(Auth::guard('administrator')->check())
                                <?php
                                    $random_id = str_random(5);
                                    $grade->grade_id = $grades_id[$i];
                                ?>

                                <span class="own-grade" id="{{$random_id}}" title="{{$created_at[$i]}}">
                                    {{$grades[$i]}}
                                </span>

                                @include('grades.context_menu', ['grades_page' => 'current_grades', 'id' => $random_id])
                            @else
                                <span title="{{$created_at[$i]}}">{{$grades[$i]}}</span>
                            @endif
                        </div>
                        @endfor
                    </td>

                    <td>
                        @if(Auth::guard('teacher')->check() && \App\Models\Subject::isOwn(Session::get('workingSubjectId')))
                            @if(Session::get('workingClassNumber') == $grade->for_class && Session::get('workingTermId') == $term_now->id)
                                <a href="{{route('current_grades.form', $grade->student_egn)}}"><i class="grade-add-btn fas fa-plus"></i></a>
                            @endif
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    {{$all_grades->links()}}
</div>
@endsection