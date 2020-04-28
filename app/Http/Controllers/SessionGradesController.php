<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Grades\SessionGrade;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionGradesController extends Controller {

    public function index() {
        $session_grades = SessionGrade::getAll();

        // за филтрите
        $classes = SchoolClass::getAllForFilterOptions();

        if(Teacher::isTeacher()) $subjects = Subject::getAllOwn();
        else $subjects = Subject::getAll();

        return view('grades.session_grades.index', [
            'session_grades' => $session_grades,
            'classes' => $classes,
            'subjects' => $subjects
        ]);
    }

    public function form() {
        $students = Student::getAllForGradeInputOptions();
        $subjects = Subject::getAllOwn();
        $grades = Grade::getAll();
        return view('grades.session_grades.form', [
            'students' => $students,
            'subjects' => $subjects,
            'grades' => $grades
        ]);
    }

    public function store(Request $req) {
        $this->validateInput($req);

        $student_egn = $req->student_egn;
        $subject_id = $req->subject_id;
        $grade_id = $req->grade_id;
        $for_class = Student::get($student_egn)->class;
        $teacher_id = Teacher::getLogged()->id;
        $class_teacher_id = Student::get($student_egn)->class_teacher_id;

        $grade = new SessionGrade();
        $grade->student_egn = $student_egn;
        $grade->subject_id = $subject_id;
        $grade->grade_id = $grade_id;
        $grade->for_class = $for_class;
        $grade->teacher_id = $teacher_id;
        $grade->class_teacher_id = $class_teacher_id;

        if($grade->save()) {
            return redirect()->route('session_grades')->with('success', 'Оценката беше успешно добавена.');
        }

        return redirect()->back()->with('error', 'Проблем при добавянето на оценката.');
    }

    public function edit($egn, $subject_id, $grade_id, $for_class) {
        $students = Student::getAllForGradeInputOptions();
        $subjects = Subject::getAllOwn();
        $grades = Grade::getAll();

        return view('grades.session_grades.form', [
            'egn' => $egn,
            'subject_id' => $subject_id,
            'grade_id' => $grade_id,
            'students' => $students,
            'subjects' => $subjects,
            'grades' => $grades
        ]);
    }

    public function update($egn, $subject_id, $grade_id, $for_class, Request $req) {
        $this->validateInput($req);

        $student_egn_new = $req->student_egn;
        $subject_id_new = $req->subject_id;
        $grade_id_new = $req->grade_id;

        SessionGrade::where([
            ['student_egn', $egn],
            ['subject_id', $subject_id],
            ['grade_id', $grade_id],
            ['for_class', $for_class]
        ])->take(1)->update([
            'student_egn' => $student_egn_new,
            'subject_id' => $subject_id_new,
            'grade_id' => $grade_id_new
        ]);

        return redirect()->route('session_grades');
    }

    public function delete($egn, $subject_id, $grade_id, $for_class) {
        SessionGrade::where([
            ['student_egn', $egn],
            ['subject_id', $subject_id],
            ['grade_id', $grade_id],
            ['for_class', $for_class]
        ])->take(1)->delete();

        return redirect()->back();
    }

    private function validateInput($req) {
        $this->validate($req, [
            'student_egn' => 'required|not_in:0',
            'subject_id' => 'integer|min:1',
            'grade_id' => 'integer|min:1'
        ]);
    }

}