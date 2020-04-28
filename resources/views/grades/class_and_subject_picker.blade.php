@if(!Auth::guard('student')->check())
<div class="col-md-6 form-group form-inline">
    <button type="button" class="btn btn-outline-secondary form-group col-md-3 btn-wrap-text" data-toggle="modal" data-target="#classChoiceModal">
        <b>Клас:</b> &nbsp; <i>{{Session::get('workingClassName')}}</i>
    </button>

    <button type="button" class="btn btn-outline-secondary form-group col-md-8 offset-md-1 btn-wrap-text" data-toggle="modal" data-target="#subjectChoiceModal">
        <b>Предмет:</b> &nbsp; <i>{{Session::get('workingSubjectName')}}</i>
    </button>
</div>

<div class="modal fade" id="classChoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Изберете клас</h5>
            </div>
            <div class="modal-body">
                @foreach($classes as $class)
                    @if(isset($class->id)) <!-- ако е администратор -->
                        <button class="btn btn-outline-dark btn-lg btn-block" onClick="chooseClass({{$class->id}})">{{$class->class_and_section .', '. $class->graduating_year}}</button>
                    @else
                        <button class="btn btn-outline-dark btn-lg btn-block" onClick="chooseClass({{$class->class_id}})">{{$class->class_and_section}}</button>
                    @endif
                @endforeach
            </div>

            @if(Session::get('workingClassId') && Session::get('workingSubjectId') || !$classes)
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Назад</button>
            </div>
            @endif

        </div>
    </div>
</div>

<div class="modal fade" id="subjectChoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Изберете предмет</h5>
            </div>
            <div class="modal-body">
                @foreach($subjects as $subject)
                    @if(isset($subject->id))
                        <button class="btn btn-outline-dark btn-lg btn-block btn-wrap-text" onClick="chooseSubject({{$subject->id}})">{{$subject->subject}}</button>
                    @else
                        <button class="btn btn-outline-dark btn-lg btn-block btn-wrap-text" onClick="chooseSubject({{$subject->subject_id}})">{{$subject->subject}}</button>
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="subjectModalBack()">Назад</button>
            </div>
        </div>
    </div>
</div>

<script>
$( document ).ready(function() {
    // ако в сесията не е сетнат клас
    if(!'{{Session::get('workingClassId')}}') {
        $('#classChoiceModal').modal('show');
    }
    // ако в сесията не е сетнат предмет
    else if(!'{{Session::get('workingSubjectId')}}') {
        $('#subjectChoiceModal').modal('show');
    }
});

var class_id;
var subject_id;

function chooseClass(id) {
    class_id = id;
    $('#classChoiceModal').modal('hide');
    location.href = "?&class_id=" + class_id;
}

function chooseSubject(id) {
    subject_id = id;
    $('#subjectChoiceModal').modal('hide');
    location.href = "?&subject_id=" + subject_id;
}

function subjectModalBack() {
    if(!'{{Session::get('workingSubjectId')}}') {
        $('#classChoiceModal').modal('show');
    }
}
</script>
@endif