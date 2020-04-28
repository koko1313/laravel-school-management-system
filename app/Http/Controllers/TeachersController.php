<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TeachersController extends Controller {

    public function index() {
        $teachers = Teacher::getAll();
        return view('teachers.index', ['teachers' => $teachers]);
    }

    public function form() {
        return view('teachers.form');
    }

    public function store(Request $req) {
        $this->validateInput($req);

        $first_name = $req['first_name'];
        $last_name = $req['last_name'];
        $username = $req['username'];
        $password = $req['password'];
        $role_id = 3;

        $teacher = new Teacher();
        $teacher->first_name = $first_name;
        $teacher->last_name = $last_name;
        $teacher->username = $username;
        $teacher->password = $password;
        $teacher->role_id = $role_id;

        try {
            $teacher->save();
            return redirect(route('teachers'))->with('success', Lang::get('constants.success_messages.teacher.added'));
        } catch(QueryException $ex){
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.teacher.exist'));
            }
            return back()->with('error', Lang::get('constants.error_messages.teacher.insert_error'));
        }
    }

    public function edit($id) {
        $teacher = Teacher::get($id);
        return view('teachers.form', ['teacher' => $teacher]);
    }

    public function update($id, Request $req) {
        $this->validateInput($req);

        $first_name = $req['first_name'];
        $last_name = $req['last_name'];
        $username = $req['username'];
        $password = $req['password'];

        try {
            if(
                Teacher::where('id', $id)->update([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'username' => $username,
                    'password' => $password])
            > 0) return redirect()->route('teachers')->with('success', Lang::get('constants.success_messages.teacher.updated'));

            return redirect()->route('teachers');
        } catch(QueryException $ex) {
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.teacher.exist'));
            }
            return back()->with('error', Lang::get('constants.error_messages.teacher.update_error'));
        }
    }

    public function delete($id) {
        try {
            Teacher::where('id', $id)->delete();
            return redirect()->back()->with('success', Lang::get('constants.success_messages.teacher.deleted'));
        } catch(QueryException $ex) {
            // външен ключ сочи към него
            if($ex->errorInfo[1] == 1451) {
                return redirect()->back()->with('error', Lang::get('constants.error_messages.teacher.teacher_has_grades'));
            }
            return redirect()->back()->with('error', Lang::get('constants.error_messages.teacher.delete_error'));
        }
    }

    private function validateInput($req) {
        $this->validate($req, [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:administrators|unique:teachers|unique:students',
            'password' => 'required'
        ]);
    }

}