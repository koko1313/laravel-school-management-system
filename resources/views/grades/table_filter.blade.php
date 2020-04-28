<div id="filters">

    @include('grades.alerts')

    <button class="d-md-none btn btn-outline-secondary form-control" data-toggle="collapse" data-target="#filters-colapse">
        @if(Auth::guard('student')->check())
            {{Session::get('workingForClass')}} клас / {{Session::get('workingTermName')}} срок
        @else
            {{Session::get('workingClassName')}} / {{Session::get('workingSubjectName')}}
        @endif
    </button>

    <!-- Ако е сетнат workingClassId го скриваме -->
    <div id="filters-colapse" class="@if(Session::get('workingClassId') && (Session::get('workingSubjectId') || Auth::guard('student')->check() )) collapse d-md-block @endif">
        <div class="row">
            @include('grades.class_and_subject_picker')

            @if(isset($terms))
            <div class="col-md form-group form-inline" data-toggle="tooltip" title="Преглед на оценки за изминали срокове">
                <div class="form-group col p-0">
                    <label class="col-sm-5">Срок:</label>

                    <select id="gradesFilterByTerm" onChange="gradesFilterByTerm(this.value)" class="form-control col-sm-7">
                        @foreach($terms as $term)
                            <option value="{{$term->id}}" @if(Session::get('workingTermId') == $term->id) {{'selected'}} @endif >{{$term->term_label}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif

            <div class="col-md form-group form-inline" data-toggle="tooltip" title="Преглед на оценки за изминали години">
                <div class="form-group col p-0">
                    <label class="col-sm-5">За клас:</label>

                    <select id="gradesFilterByFor_class" onChange="gradesFilterByForClass(this.value)" class="form-control col-sm-7">
                        <!--
                        @foreach($all_classes_as_numbers as $class)
                            <option value="{{$class->class}}"
                                @if(Session::get('workingForClass') == $class->class) {{'selected'}}
                                @elseif(!Session::get('workingForClass') && Session::get('workingClassNumber') == $class->class) {{'selected'}} @endif
                            >{{$class->class}}</option>
                        @endforeach
                        -->

                        @for($class=1; $class<=12; $class++)
                            <option value="{{$class}}"
                                @if(Session::get('workingForClass') == $class) {{'selected'}}
                                @elseif(!Session::get('workingForClass') && Session::get('workingClassNumber') == $class) {{'selected'}} @endif
                            >{{$class}}</option>
                        @endfor
                    </select>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
$( document ).ready(function() {
    if(!'{{Session::get('workingTermId')}}') $("#gradesFilterByTerm").change();
    if('{{Auth::guard('student')->check()}}' && '{{Session::get('workingClassId')}}' && '{{Session::get('workingForClass')}}' == 0 ||
        '{{Session::get('workingClassId')}}' && '{{Session::get('workingForClass')}}' == 0 && '{{Session::get('workingSubjectId')}}'
        ) $("#gradesFilterByFor_class").change();
});

function gradesFilterByTerm(term_id) {
    insertParam('term_id', term_id);
}

function gradesFilterByForClass(for_class) {
    insertParam('for_class', for_class);
}

function insertParam(key, value) {
    key = encodeURI(key); value = encodeURI(value);

    var kvp = document.location.search.substr(1).split('&');

    var i=kvp.length; var x;
    while(i--) {
        x = kvp[i].split('=');

        if (x[0]==key) {
            x[1] = value;
            kvp[i] = x.join('=');
            break;
        }
    }

    if(i<0) {kvp[kvp.length] = [key,value].join('=');}

    //this will reload the page, it's likely better to store this until finished
    document.location.search = kvp.join('&');
}
</script>