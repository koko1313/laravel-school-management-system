<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserSessionController;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Term;
use App\Models\Grades\TermGrade;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class TermGradesController extends Controller {

    public function index() {
        UserSessionController::setCurrentWorking();

        $all_grades = TermGrade::getAll();
        $terms = Term::getAll();
        $term_now = Term::getTermNow();
        $all_classes_as_numbers = SchoolClass::getAllAsNumbers(); // за филтъра за предишни класове

        if(Teacher::isTeacherOrClassTeacher()) $classes = SchoolClass::getAllOwn();
        else $classes = SchoolClass::getAll();

        if(Teacher::isTeacher()) $subjects = Subject::getAllOwn();
        // ако е класен и избрания клас в сесията не е неговия клас
        else if(Teacher::isClassTeacher() && Session::get('workingClassId') != Teacher::getOwnClass()->id) $subjects = Subject::getAllOwn();
        else $subjects = Subject::getAll();

        return view('grades.term_grades.index', [
            'all_grades' => $all_grades,
            'all_classes_as_numbers' => $all_classes_as_numbers,
            'classes' => $classes,
            'terms' => $terms,
            'subjects' => $subjects,
            'term_now' => $term_now
        ]);
    }

    public function form($student_egn) {
        $student = Student::get($student_egn);
        $subject = Subject::get(Session::get('workingSubjectId'));
        $term_now = Term::getTermNow();
        $grades = Grade::getAll();

        return view('grades.term_grades.form', [
            'student' => $student,
            'subject' => $subject,
            'term_now' => $term_now,
            'grades' => $grades
        ]);
    }

    public function store(Request $req) {
        $this->validateInput($req);

        $student_egn = $req->student_egn;
        $subject_id = $req->subject_id;

        if(!Student::isOwn($student_egn) || !Subject::isOwn($subject_id)) return redirect()->back()->withInput()->with('error', Lang::get('constants.error_messages.grade.insert_error'));

        $grade_id = $req->grade_id;
        $term_now_id = Term::getTermNow()->id;
        $for_class = Student::get($student_egn)->class;
        $teacher_id = Teacher::getLogged()->id;

        $grade = new TermGrade();
        $grade->student_egn = $student_egn;
        $grade->subject_id = $subject_id;
        $grade->grade_id = $grade_id;
        $grade->term_id = $term_now_id;
        $grade->for_class = $for_class;
        $grade->teacher_id = $teacher_id;

        try {
            $grade->save();
            return redirect()->route('term_grades')->with('success', Lang::get('constants.success_messages.grade.added'));
        } catch(QueryException $ex) {
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.grade.exist'));
            }
            return redirect()->back()->with('error', Lang::get('constants.error_messages.grade.insert_error'));
        }
    }

    public function edit($egn, $subject_id, $grade_id, $term_id, $for_class) {
        $grades = Grade::getAll();

        $grade = TermGrade::get($egn, $subject_id, $grade_id, $term_id, $for_class);
        $student = Student::get($egn);
        $subject = Subject::get($subject_id);
        $for_term = Term::get($grade->term_id);

        return view('grades.term_grades.form', [
            'student' => $student,
            'subject' => $subject,
            'grade_id' => $grade->grade_id,
            'for_term_label' => $for_term->term_label,
            'for_term_id' =>$for_term->id,
            'for_class' => $grade->for_class,
            'grades' => $grades
        ]);
    }

    public function update(Request $req) {
        $this->validateInput($req);

        $student_egn = $req->student_egn;
        $subject_id = $req->subject_id;
        $grade_id_old = $req->grade_id_old;
        $for_term_id = $req->for_term_id;
        $for_class = $req->for_class;

        $grade_id_new = $req->grade_id;

        try {
            if(
                TermGrade::where([
                    ['student_egn', $student_egn],
                    ['subject_id', $subject_id],
                    ['grade_id', $grade_id_old],
                    ['term_id', $for_term_id],
                    ['for_class', $for_class]
                ])->take(1)->update([
                    'grade_id' => $grade_id_new,
                ])
            > 0) return redirect()->route('term_grades')->with('success', Lang::get('constants.success_messages.grade.updated'));

            return redirect()->route('term_grades');
        } catch(QueryException $ex) {
            return back()->with('error', Lang::get('constants.error_messages.grade.update_error'));
        }
    }

    public function delete($egn, $subject_id, $grade_id, $term_id, $for_class) {
        try {
            TermGrade::where([
                ['student_egn', $egn],
                ['subject_id', $subject_id],
                ['grade_id', $grade_id],
                ['term_id', $term_id],
                ['for_class', $for_class]
            ])->take(1)->delete();

            return redirect()->back()->with('success', Lang::get('constants.success_messages.grade.deleted'));
        } catch(QueryException $ex) {
            return redirect()->back()->with('error', Lang::get('constants.success_messages.grade.delete_error'));
        }
    }

    private function validateInput($req) {
        $this->validate($req, [
            'student_egn' => 'required',
            'subject_id' => 'required',
            'grade_id' => 'required'
        ]);
    }

}