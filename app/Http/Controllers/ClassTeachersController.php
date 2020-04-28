<?php

namespace App\Http\Controllers;

use App\Models\Class_Teacher;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ClassTeachersController extends Controller {

    public function index() {
        $class_teachers = Class_Teacher::getAll();
        return view('class_teachers.index', ['class_teachers' => $class_teachers]);
    }

    public function form() {
        $classes = SchoolClass::getAll();
        $teachers = Teacher::getAll();
        return view('class_teachers.form', ['classes' => $classes, 'teachers' => $teachers]);
    }

    public function store(Request $req) {
        $this->validateInput($req);

        $class_id = $req['class_id'];
        $teacher_id = $req['teacher_id'];

        $class_teacher = new Class_Teacher();
        $class_teacher->class_id = $class_id;
        $class_teacher->teacher_id = $teacher_id;

        try {
            $class_teacher->save();
            return redirect(route('class_teachers'))->with('success', Lang::get('constants.success_messages.class_teacher.added'));
        } catch(QueryException $ex){
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.class_teacher.exist'));
            }
            return back()->with('error', Lang::get('constants.error_messages.class_teacher.insert_error'));
        }
    }

    public function edit($class_id, $teacher_id) {
        $class_teacher = Class_Teacher::get($class_id, $teacher_id);
        $classes = SchoolClass::getAll();
        $teachers = Teacher::getAll();

        return view('class_teachers.form', [
            'class_teachers' => $class_teacher,
            'classes' => $classes,
            'teachers' => $teachers
        ]);
    }

    public function update($class_id, $teacher_id, Request $req) {
        $this->validateInput($req);

        $class_id_new = $req['class_id'];
        $teacher_id_new = $req['teacher_id'];

        try {
            if(
                Class_Teacher::where([
                    ['class_id', $class_id],
                    ['teacher_id', $teacher_id]
                ])->update(['class_id' => $class_id_new, 'teacher_id' => $teacher_id_new])
            > 0) return redirect()->route('class_teachers')->with('success', Lang::get('constants.success_messages.class_teacher.updated'));

            return redirect()->route('class_teachers');
        } catch(QueryException $ex) {
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.class_teacher.exist'));
            }
            return back()->with('error', Lang::get('constants.error_messages.class_teacher.update_error'));
        }
    }

    public function delete($class_id, $teacher_id) {
        try {
            Class_Teacher::where([
                ['class_id', $class_id],
                ['teacher_id', $teacher_id]
            ])->delete();

            return redirect()->back()->with('success', Lang::get('constants.success_messages.class_teacher.deleted'));
        } catch(QueryException $ex) {
            return redirect()->back()->with('error', Lang::get('constants.error_messages.class_teacher.delete_error'));
        }
    }

    private function validateInput($req) {
        $this->validate($req, [
            'class_id' => 'required',
            'teacher_id' => 'required'
        ]);
    }

}