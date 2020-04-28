<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class StudentsController extends Controller {

    public function index() {
        $students = Student::getAll();
        return view('students.index', ['students' => $students]);
    }

    public function form() {
        if(Teacher::isClassTeacher()) $classes = Teacher::getOwnClass();
        else $classes = SchoolClass::getAll();

        return view('students.form', ['classes' => $classes]);
    }

    public function store(Request $req) {
        $this->validateInput($req);

        $egn = $req['egn'];
        $first_name = $req['first_name'];
        $second_name = $req['second_name'];
        $last_name = $req['last_name'];
        $class_no = $req['class_no'];
        $class_id = $req['class_id'];
        $username = $req['username'];
        $password = $req['password'];
        $description = $req['description'];
        $role_id = 4;

        $student = new Student();
        $student->egn = $egn;
        $student->first_name = $first_name;
        $student->second_name = $second_name;
        $student->last_name = $last_name;
        $student->class_no = $class_no;
        $student->class_id = $class_id;
        $student->username = $username;
        $student->password = $password;
        $student->description = $description;
        $student->role_id = $role_id;

        try {
            $student->save();
            return redirect(route('students'))->with('success', Lang::get('constants.success_messages.student.added'));
        } catch(QueryException $ex){
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.student.exist'));
            }
            return back()->with('error', Lang::get('constants.error_messages.student.insert_error'));
        }
    }

    public function edit($egn) {
        $student = Student::get($egn);

        if(Teacher::isClassTeacher()) $classes = Teacher::getOwnClass();
        else $classes = SchoolClass::getAll();

        return view('students.form', ['student' => $student, 'classes' => $classes]);
    }

    public function update($egn, Request $req) {
        $egn_new = $req['egn'];
        $first_name = $req['first_name'];
        $second_name = $req['second_name'];
        $last_name = $req['last_name'];
        $class_no = $req['class_no'];
        $class_id = $req['class_id'];
        $username = $req['username'];
        $password = $req['password'];
        $description = $req['description'];

        try {
            if(
                Student::where('egn', $egn)->update([
                    'egn' => $egn_new,
                    'first_name' => $first_name,
                    'second_name' => $second_name,
                    'last_name' => $last_name,
                    'class_no' => $class_no,
                    'class_id' => $class_id,
                    'username' => $username,
                    'password' => $password,
                    'description' => $description
                ])
            > 0) return redirect()->route('students')->with('success', Lang::get('constants.success_messages.student.updated'));

            return redirect()->route('students');
        } catch(QueryException $ex) {
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.student.exist'));
            }
            return back()->with('error', Lang::get('constants.error_messages.student.update_error'));
        }
    }

    public function delete($egn) {
        try {
            Student::where('egn', $egn)->delete();
            return redirect()->back()->with('success', Lang::get('constants.success_messages.student.deleted'));
        } catch(QueryException $ex) {
            return redirect()->back()->with('error', Lang::get('constants.error_messages.student.delete_error'));
        }
    }

    private function validateInput($req) {
        $this->validate($req, [
            'egn' => 'required|digits:10|unique:students',
            'first_name' => 'required',
            'second_name' => 'required',
            'last_name' => 'required',
            'class_no' => 'required',
            'class_id' => 'required',
            'username' => 'required|unique:administrators|unique:teachers|unique:students',
            'password' => 'required'
        ]);
    }

}