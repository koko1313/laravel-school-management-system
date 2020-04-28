<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <a class="navbar-brand" href="{{route('index')}}"><i class="fas fa-graduation-cap" style="font-size: 20pt"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item {{Route::is('index') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('index')}}">Начало</a>
            </li>

            @auth('administrator')
                
                <!--
                <li class="nav-item {{Route::is('teachers', 'teachers.form', 'teachers.edit') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('teachers')}}">Учители</a>
                </li>
                -->

                <li class="nav-item dropdown {{Route::is('teachers', 'teachers.form', 'teachers.edit', 'teachers_subjects', 'teachers_subjects.form', 'teachers_subjects.edit') ? 'active' : ''}}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Учители
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item {{Route::is('teachers', 'teachers.form', 'teachers.edit') ? 'active' : ''}}" href="{{route('teachers')}}">Учители</a>
                        <a class="dropdown-item {{Route::is('teachers_subjects', 'teachers_subjects.form', 'teachers_subjects.edit') ? 'active' : ''}}" href="{{route('teachers_subjects')}}">Кой учител какво преподава</a>
                    </div>
                </li>

                <li class="nav-item {{Route::is('subjects', 'subjects.form', 'subjects.edit') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('subjects')}}">Предмети</a>
                </li>

                <!--
                <li class="nav-item {{Route::is('teachers_subjects', 'teachers_subjects.form', 'teachers_subjects.edit') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('teachers_subjects')}}">Кой учител какво преподава</a>
                </li>
                -->

                <!--
                <li class="nav-item {{Route::is('classes', 'classes.form', 'classes.edit') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('classes')}}">Класове</a>
                </li>

                <li class="nav-item {{Route::is('class_teachers', 'class_teachers.form', 'class_teachers.edit') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('class_teachers')}}">На кой клас кои учители преподават</a>
                </li>
                -->

                <li class="nav-item dropdown {{Route::is('classes', 'classes.form', 'classes.edit', 'class_teachers', 'class_teachers.form', 'class_teachers.edit') ? 'active' : ''}}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Класове
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item {{Route::is('classes', 'classes.form', 'classes.edit') ? 'active' : ''}}" href="{{route('classes')}}">Класове</a>
                        <a class="dropdown-item {{Route::is('class_teachers', 'class_teachers.form', 'class_teachers.edit') ? 'active' : ''}}" href="{{route('class_teachers')}}">На кой клас кои учители преподават</a>
                    </div>
                </li>
            @endauth

            @if(Auth::guard('teacher')->check() || Auth::guard('student')->check())
                <li class="nav-item {{Route::is('current_grades', 'current_grades.form', 'current_grades.edit') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('current_grades')}}">Текущи оценки</a>
                </li>

                <li class="nav-item {{Route::is('term_grades', 'term_grades.form', 'term_grades.edit') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('term_grades')}}">Срочни оценки</a>
                </li>

                <li class="nav-item {{Route::is('session_grades', 'session_grades.form', 'session_grades.edit') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('session_grades')}}">Годишни оценки</a>
                </li>
            @endif

            @if(Auth::guard('administrator')->check() || (Auth::guard('teacher')->check() && Auth::guard('teacher')->user()->role_id==2))
                <li class="nav-item {{Route::is('students', 'students.form', 'students.edit') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('students')}}">Ученици</a>
                </li>
            @endif

            @auth('administrator')
                <li class="nav-item {{Route::is('school_control') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('school_control')}}">Управление на училището</a>
                </li>

                <li class="nav-item dropdown {{Route::is('current_grades', 'current_grades.form', 'current_grades.edit', 'term_grades', 'term_grades.form', 'term_grades.edit', 'session_grades', 'session_grades.form', 'session_grades.edit') ? 'active' : ''}}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Оценки
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('current_grades')}}">Текущи оценки</a>
                        <a class="dropdown-item" href="{{route('term_grades')}}">Срочни оценки</a>
                        <a class="dropdown-item" href="{{route('session_grades')}}">Годишни оценки</a>
                    </div>
                </li>
            @endauth
        </ul>

        @if(Auth::guard('administrator')->check() || Auth::guard('teacher')->check() || Auth::guard('student')->check())
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item"><a class="nav-link" href="{{route('profile')}}">
                @if(Auth::guard('administrator')->user())
                    {{Auth::guard('administrator')->user()->username}}
                @elseif(Auth::guard('teacher')->user())
                    {{Auth::guard('teacher')->user()->first_name .' '. Auth::guard('teacher')->user()->last_name}}
                @elseif(Auth::guard('student')->user())
                    {{Auth::guard('student')->user()->first_name .' '. Auth::guard('student')->user()->last_name}}
                @endif
            </a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('logout')}}"><i class="fas fa-sign-out-alt"></i> Изход</a></li>
        </ul>
        @endif
    </div>
</nav>