<?php

Route::prefix('/')->group(function() {
    Route::get('/', 'HomeController@index')->name('index');
    Route::post('login', 'LoginController@login')->name('login');

    Route::group(['middleware' => 'loggedCheck'], function() {
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::get('profile', 'HomeController@profile')->name('profile');
    });
});

Route::prefix('teachers')->middleware('redirectIfNot:administrator')->group(function() {
    Route::get('/', 'TeachersController@index')->name('teachers');
    Route::get('form', 'TeachersController@form')->name('teachers.form');
    Route::post('form', 'TeachersController@store');
    Route::get('edit/{id}', 'TeachersController@edit')->name('teachers.edit');
    Route::put('edit/{id}', 'TeachersController@update');
    Route::get('delete/{id}', 'TeachersController@delete')->name('teachers.delete');
});

Route::prefix('subjects')->middleware('redirectIfNot:administrator')->group(function() {
    Route::get('/', 'SubjectsController@index')->name('subjects');
    Route::get('form', 'SubjectsController@form')->name('subjects.form');
    Route::post('form', 'SubjectsController@store');
    Route::get('edit/{id}', 'SubjectsController@edit')->name('subjects.edit');
    Route::put('edit/{id}', 'SubjectsController@update');
    Route::get('delete/{id}', 'SubjectsController@delete')->name('subjects.delete');
});

Route::prefix('teachers_subjects')->middleware('redirectIfNot:administrator')->group(function() {
    Route::get('/', 'TeachersSubjectsController@index')->name('teachers_subjects');
    Route::get('form', 'TeachersSubjectsController@form')->name('teachers_subjects.form');
    Route::post('form', 'TeachersSubjectsController@store');
    Route::get('edit/{subject_id}/{teacher_id}', 'TeachersSubjectsController@edit')->name('teachers_subjects.edit');
    Route::put('edit/{subject_id}/{teacher_id}', 'TeachersSubjectsController@update');
    Route::get('delete/{subject_id}/{teacher_id}', 'TeachersSubjectsController@delete')->name('teachers_subjects.delete');
});

Route::prefix('classes')->middleware('redirectIfNot:administrator')->group(function() {
    Route::get('/', 'ClassesController@index')->name('classes');
    Route::get('form', 'ClassesController@form')->name('classes.form');
    Route::post('form', 'ClassesController@store');
    Route::get('edit/{id}', 'ClassesController@edit')->name('classes.edit');
    Route::put('edit/{id}', 'ClassesController@update');
    Route::get('delete/{id}', 'ClassesController@delete')->name('classes.delete');
});

Route::prefix('class_teachers')->middleware('redirectIfNot:administrator')->group(function() {
    Route::get('/', 'ClassTeachersController@index')->name('class_teachers');
    Route::get('form', 'ClassTeachersController@form')->name('class_teachers.form');
    Route::post('form', 'ClassTeachersController@store');
    Route::get('edit/{class_id}/{teacher_id}', 'ClassTeachersController@edit')->name('class_teachers.edit');
    Route::put('edit/{class_id}/{teacher_id}', 'ClassTeachersController@update');
    Route::get('delete/{class_id}/{teacher_id}', 'ClassTeachersController@delete')->name('class_teachers.delete');
});

Route::prefix('students')->middleware('adminOrClassTeacherCheck')->group(function() {
    Route::get('/', 'StudentsController@index')->name('students');
    Route::get('form', 'StudentsController@form')->name('students.form');
    Route::post('form', 'StudentsController@store');
    Route::get('edit/{egn}', 'StudentsController@edit')->name('students.edit');
    Route::put('edit/{egn}', 'StudentsController@update');
    Route::get('delete/{egn}', 'StudentsController@delete')->name('students.delete');
});

Route::prefix('school_control')->middleware('redirectIfNot:administrator')->group(function() {
    Route::get('/', 'SchoolControlController@index')->name('school_control');
    Route::post('/', 'SchoolControlController@update');
    Route::get('/next_school_year', 'SchoolControlController@nextSchoolYear')->name('next_school_year');
});

Route::prefix('current_grades')->middleware('loggedCheck')->namespace('Grades')->group(function() {
    Route::get('/', 'CurrentGradesController@index')->name('current_grades');

    Route::group(['middleware' => 'redirectIfNot:teacher'], function() {
        Route::get('form/{student_egn}', 'CurrentGradesController@form')->name('current_grades.form');
        Route::post('form/{student_egn}', 'CurrentGradesController@store');
    });

    Route::group(['middleware' => 'redirectIfNot:administrator'], function() {
        Route::get('edit/{egn}/{subject_id}/{grade_id}/{term_id}/{for_class}', 'CurrentGradesController@edit')->name('current_grades.edit');
        Route::put('edit/{param}', 'CurrentGradesController@update')->where('param', '.+'); // без значение колко и какви параметри има
        Route::get('delete/{egn}/{subject_id}/{grade_id}/{term_id}/{for_class}', 'CurrentGradesController@delete')->name('current_grades.delete');
    });
});

Route::prefix('term_grades')->middleware('loggedCheck')->namespace('Grades')->group(function() {
    Route::get('/', 'TermGradesController@index')->name('term_grades');

    Route::group(['middleware' => 'redirectIfNot:teacher'], function() {
        Route::get('form/{student_egn}', 'TermGradesController@form')->name('term_grades.form');
        Route::post('form/{student_egn}', 'TermGradesController@store');
    });

    Route::group(['middleware' => 'redirectIfNot:administrator'], function() {
        Route::get('edit/{egn}/{subject_id}/{grade_id}/{term_id}/{for_class}', 'TermGradesController@edit')->name('term_grades.edit');
        Route::put('edit/{param}', 'TermGradesController@update')->where('param', '.+');
        Route::get('delete/{egn}/{subject_id}/{grade_id}/{term_id}/{for_class}', 'TermGradesController@delete')->name('term_grades.delete');
    });
});

Route::prefix('session_grades')->middleware('loggedCheck')->namespace('Grades')->group(function() {
    Route::get('/', 'SessionGradesController@index')->name('session_grades');

    Route::group(['middleware' => ['redirectIfNot:teacher', 'redirectIfNotLastTerm']], function() {
        Route::get('form/{student_egn}', 'SessionGradesController@form')->name('session_grades.form');
        Route::post('form/{student_egn}', 'SessionGradesController@store');
    });

    Route::group(['middleware' => 'redirectIfNot:administrator'], function() {
        Route::get('edit/{egn}/{subject_id}/{grade_id}/{for_class}', 'SessionGradesController@edit')->name('session_grades.edit');
        Route::put('edit/{param}', 'SessionGradesController@update')->where('param', '.+');
        Route::get('delete/{egn}/{subject_id}/{grade_id}/{for_class}', 'SessionGradesController@delete')->name('session_grades.delete');
    });
});