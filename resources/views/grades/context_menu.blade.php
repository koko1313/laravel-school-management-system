<!--
 Очаква като параметри:
 $id - id-то на оценката, за да се сложи същото и на менюто (да отговарят едно за друго)
 $grades_page - името на страницата с оценките (current_grades, term_grades, session_grades)
 -->
<ul class="grade-context-menu" id="menu{{$id}}">
    <li>
        <div>
            @if($grades_page != 'session_grades')
                <a href="{{route($grades_page.'.edit', [
                $grade->student_egn,
                $grade->subject_id,
                $grade->grade_id,
                $grade->term_id,
                $grade->for_class
                ])}}">Редактирай</a>
            @else
                <a href="{{route($grades_page.'.edit', [
                $grade->student_egn,
                $grade->subject_id,
                $grade->grade_id,
                $grade->for_class
                ])}}">Редактирай</a>
            @endif
        </div>
    </li>
    <li>
        <div>
            @if($grades_page != 'session_grades')
                <a onclick="return confirm('Изтриване?')" href="{{route($grades_page.'.delete', [
                $grade->student_egn,
                $grade->subject_id,
                $grade->grade_id,
                $grade->term_id,
                $grade->for_class
                ])}}">Изтрий</a>
            @else
                <a onclick="return confirm('Изтриване?')" href="{{route($grades_page.'.delete', [
                $grade->student_egn,
                $grade->subject_id,
                $grade->grade_id,
                $grade->for_class
                ])}}">Изтрий</a>
            @endif
        </div>
    </li>
</ul>

<script>
    $("#{{$id}}").contextmenu(function() {
        $( ".grade-context-menu" ).hide();
        $( "#menu{{$id}}" ).show();
    });
</script>