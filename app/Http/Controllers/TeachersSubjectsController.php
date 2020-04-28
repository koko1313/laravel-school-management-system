<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Teacher_subject;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TeachersSubjectsController extends Controller {

    public function index() {
        $teachers_subjects = Teacher_subject::getAll();
        return view('teachers_subjects.index', ['teachers_subjects' => $teachers_subjects]);
    }

    public function form() {
        $teachers = Teacher::getAll();
        $subjects = Subject::getAll();
        return view('teachers_subjects.form', ['teachers' => $teachers, 'subjects' => $subjects]);
    }

    public function store(Request $req) {
        $this->validateInput($req);

        $teacher_id = $req['teacher_id'];
        $subject_id = $req['subject_id'];

        $teacher_subject = new Teacher_subject();
        $teacher_subject->teacher_id = $teacher_id;
        $teacher_subject->subject_id = $subject_id;

        try {
            $teacher_subject->save();
            return redirect(route('teachers_subjects'))->with('success', Lang::get('constants.success_messages.teacher_subject.added'));
        } catch(QueryException $ex){
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.teacher_subject.exist'));
            }
            return back()->with('error', Lang::get('constants.error_messages.teacher_subject.insert_error'));
        }
    }

    public function edit($subject_id, $teacher_id) {
        $teachers_subjects = Teacher_subject::get($subject_id, $teacher_id);
        $teachers = Teacher::getAll();
        $subjects = Subject::getAll();

        return view('teachers_subjects.form', [
            'teachers_subjects' => $teachers_subjects,
            'teachers' => $teachers,
            'subjects' => $subjects
        ]);
    }

    public function update($subject_id, $teacher_id, Request $req) {
        $this->validateInput($req);

        $teacher_id_new = $req['teacher_id'];
        $subject_id_new = $req['subject_id'];

        try {
            if(
                Teacher_subject::where([
                    ['subject_id', $subject_id],
                    ['teacher_id', $teacher_id]
                ])->update(['subject_id' => $subject_id_new, 'teacher_id' => $teacher_id_new])
            > 0) return redirect()->route('teachers_subjects')->with('success', Lang::get('constants.success_messages.teacher_subject.updated'));

            return redirect()->route('teachers_subjects');
        } catch(QueryException $ex) {
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.teacher_subject.exist'));
            }
            return back()->with('error', Lang::get('constants.error_messages.teacher_subject.update_error'));
        }
    }

    public function delete($subject_id, $teacher_id) {
        try {
            Teacher_subject::where([
                ['subject_id', $subject_id],
                ['teacher_id', $teacher_id]
            ])->delete();

            return redirect()->back()->with('success', Lang::get('constants.success_messages.teacher_subject.deleted'));
        } catch(QueryException $ex) {
            return redirect()->back()->with('error', Lang::get('constants.success_messages.teacher_subject.delete_error'));
        }
    }

    private function validateInput($req) {
        $this->validate($req, [
            'teacher_id' => 'required',
            'subject_id' => 'required'
        ]);
    }

}