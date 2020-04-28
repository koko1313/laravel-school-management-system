@if(Session::get('workingClassId') && (Session::get('workingSubjectId') || Auth::guard('student')->check()) && Session::get('workingTermId') && Session::get('workingForClass'))

    {{-- Учителят не преподава по този предмет --}}
    @if(Auth::guard('teacher')->check() && !\App\Models\Subject::isOwn(Session::get('workingSubjectId')))
        @component('layout.alert_warning')
            Не можете да въвеждате оценки, защото не преподавате по <b>{{Session::get('workingSubjectName')}}</b>.
        @endcomponent

    {{-- Не е избран текущия учебен срок --}}
    @elseif(isset($term_now) && Session::get('workingTermId') != $term_now->id)
        @if(Auth::guard('student')->check() || Auth::guard('administrator')->check())
            @component('layout.alert_warning')
                Не сте на текущия учебен срок. <br>
                Текущ учебен срок: <b>{{$term_now->term_label}}</b> <br>
            @endcomponent
        @else
            @component('layout.alert_warning')
                Не можете да въвеждате оценки, защото не сте на текущия учебен срок. <br>
                Текущ учебен срок: <b>{{$term_now->term_label}}</b> <br>
            @endcomponent
        @endif

    {{-- Не е на текущия "За клас" --}}
    @elseif(\App\Models\SchoolClass::get(Session::get('workingClassId'))->class != Session::get('workingForClass'))
        @if(Auth::guard('student')->check())
            @component('layout.alert_warning')
                В момента преглеждате оценки за изминали години.<br>
                В момента сте <b>{{Session::get('workingClassNumber')}}</b> клас.
            @endcomponent
        @elseif(Auth::guard('administrator')->check())
            @component('layout.alert_warning')
                В момента преглеждате оценки за изминали години.<br>
                <b>{{Session::get('workingClassName')}}</b> в момента са <b>{{Session::get('workingClassNumber')}}</b> клас.
            @endcomponent
        @else
            @component('layout.alert_warning')
                Не можете да въвеждате оценки, защото преглеждате оценки за изминали години.<br>
                <b>{{Session::get('workingClassName')}}</b> в момента са <b>{{Session::get('workingClassNumber')}}</b> клас.
            @endcomponent
        @endif

    {{-- Ако сме на годишните оценки и срока не е последния (Втори) --}}
    @elseif(Route::currentRouteName() == 'session_grades' && !\App\Models\Term::getLastTerm()->now)
        @if(Auth::guard('teacher')->check())
            @component('layout.alert_warning')
                Можете да въвеждате годишни оценки, само когато учебният срок е
                <b>{{\App\Models\Term::getLastTerm()->term_label}}</b>.
            @endcomponent
        @endif
    @endif
@endif