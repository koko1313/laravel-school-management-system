<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ClassesController extends Controller {

    public function index() {
        $classes = SchoolClass::getAll();
        return view('classes.index', ['classes' => $classes]);
    }

    public function form() {
        $teachers = Teacher::getAll();
        return view('classes.form', ['teachers' => $teachers]);
    }

    public function store(Request $req) {
        $this->validateInput($req);

        $class = $req['class'];
        $class_section = $req['class_section'];
        $class_teacher_id = $req['class_teacher_id'];
        $graduating_year = $req['graduating_year'];

        if(Teacher::isClassTeacher($class_teacher_id)) return redirect()->back()->withInput()->with('error', Lang::get('constants.error_messages.teacher.already_class_teacher'));

        $school_class = new SchoolClass();
        $school_class->class = $class;
        $school_class->class_section = $class_section;
        $school_class->class_teacher_id = $class_teacher_id;
        $school_class->graduating_year = $graduating_year;

        try {
            $school_class->save();
            Teacher::setRoleToClassTeacher($class_teacher_id);
            return redirect(route('classes'))->with('success', Lang::get('constants.success_messages.class.added'));
        } catch(QueryException $ex){
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.class.exist'));
            }
            return back()->with('error', Lang::get('constants.error_messages.class.insert_error'));
        }
    }

    public function edit($id) {
        $class = SchoolClass::get($id);
        $teachers = Teacher::getAll();
        return view('classes.form', ['class' => $class, 'teachers' => $teachers]);
    }

    public function update($id, Request $req) {
        $this->validateInput($req);

        $class = $req['class'];
        $class_section = $req['class_section'];
        $class_teacher_id = $req['class_teacher_id'];
        $graduating_year = $req['graduating_year'];

        $school_class = SchoolClass::get($id);
        $old_class_teacher_id = $school_class->class_teacher_id;

        Teacher::setRoleToTeacher($old_class_teacher_id);
        Teacher::setRoleToClassTeacher($class_teacher_id);

        try {
            if(
                SchoolClass::where('id', $id)->update([
                    'class' => $class,
                    'class_section' => $class_section,
                    'class_teacher_id' => $class_teacher_id,
                    'graduating_year' => $graduating_year
                ])
            > 0) return redirect()->route('classes')->with('success', Lang::get('constants.success_messages.class.updated'));

            return redirect()->route('classes');
        } catch(QueryException $ex) {
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.class.exist'));
            }
            return back()->with('error', Lang::get('constants.error_messages.class.update_error'));
        }
    }

    public function delete($id) {
        $school_class = SchoolClass::get($id);
        $old_class_teacher_id = $school_class->class_teacher_id;
        Teacher::setRoleToTeacher($old_class_teacher_id);

        try {
            SchoolClass::where('id', $id)->delete();
            return redirect()->back()->with('success', Lang::get('constants.success_messages.class.deleted'));
        } catch(QueryException $ex) {
            return redirect()->back()->with('error', Lang::get('constants.error_messages.class.delete_error'));
        }
    }

    private function validateInput($req) {
        $this->validate($req, [
            'class' => 'required',
            'class_section' => 'required',
            'class_teacher_id' => 'required',
            'graduating_year' => 'required|size:4'
        ]);
    }

}