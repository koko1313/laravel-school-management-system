<?php

namespace App\Http\Controllers;

use App\Models\Grades\CurrentGrade;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CurrentGradesController extends Controller {

    public function index() {
        $current_grades = CurrentGrade::getAll();

        // за филтрите
        $classes = SchoolClass::getAllForFilterOptions();
        $terms = Term::getAll();;

        if(Teacher::isTeacher()) $subjects = Subject::getAllOwn();
        else $subjects = Subject::getAll();

        return view('grades.current_grades.index', [
            'current_grades' => $current_grades,
            'classes' => $classes,
            'terms' => $terms,
            'subjects' => $subjects
        ]);
    }

    public function form() {
        $students = Student::getAllForGradeInputOptions();
        $subjects = Subject::getAllOwn();
        $term_now = Term::getTermNow();
        $grades = Grade::getAll();

        return view('grades.current_grades.form', [
            'students' => $students,
            'subjects' => $subjects,
            'term_now' => $term_now,
            'grades' => $grades
        ]);
    }

    public function store(Request $req) {
        $this->validateInput($req);

        $student_egn = $req->student_egn;
        $subject_id = $req->subject_id;
        $grade_id = $req->grade_id;
        $term_now_id = $req->term_now_id;
        $for_class = Student::get($student_egn)->class;
        $teacher_id = Teacher::getLogged()->id;

        $grade = new CurrentGrade();
        $grade->student_egn = $student_egn;
        $grade->subject_id = $subject_id;
        $grade->grade_id = $grade_id;
        $grade->term_id = $term_now_id;
        $grade->for_class = $for_class;
        $grade->teacher_id = $teacher_id;

        if($grade->save()) {
            return redirect()->route('current_grades')->with('success', 'Оценката беше успешно добавена.');
        }

        return redirect()->back()->with('error', 'Проблем при добавянето на оценката.');
    }

    public function edit($egn, $subject_id, $grade_id, $term_id) {
        $students = Student::getAllForGradeInputOptions();
        $subjects = Subject::getAllOwn();
        $term_now = Term::getTermNow();
        $grades = Grade::getAll();

        return view('grades.current_grades.form', [
            'egn' => $egn,
            'subject_id' => $subject_id,
            'grade_id' => $grade_id,
            'term_id' => $term_id,
            'students' => $students,
            'subjects' => $subjects,
            'term_now' => $term_now,
            'grades' => $grades
        ]);
    }

    public function update($egn, $subject_id, $grade_id, $term_id, Request $req) {
        $this->validateInput($req);

        $student_egn_new = $req->student_egn;
        $subject_id_new = $req->subject_id;
        $grade_id_new = $req->grade_id;
        $term_now_id = $req->term_now_id;

        CurrentGrade::where([
            ['student_egn', $egn],
            ['subject_id', $subject_id],
            ['grade_id', $grade_id],
            ['term_id', $term_id]
        ])->take(1)->update([
            'student_egn' => $student_egn_new,
            'subject_id' => $subject_id_new,
            'grade_id' => $grade_id_new,
            'term_id' => $term_now_id
        ]);

        return redirect()->route('current_grades');
    }

    public function delete($egn, $subject_id, $grade_id, $term_id) {
        CurrentGrade::where([
            ['student_egn', $egn],
            ['subject_id', $subject_id],
            ['grade_id', $grade_id],
            ['term_id', $term_id]
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