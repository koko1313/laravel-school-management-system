<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    public function index() {
        return view('index');
    }

    public function profile() {
        if(Auth::guard('student')->check()) {
            $student = Student::get(Auth::guard('student')->user()->egn);
            return view('users.profile', ['student' => $student]);
        } else
        if(Auth::guard('teacher')->check() && Auth::guard('teacher')->user()->role_id==2) {
            $class_teacher = Teacher::get(Auth::guard('teacher')->user()->id);
            $own_class = Teacher::getOwnClass($class_teacher->id);
            $class_teacher->class =  $own_class->class .' '. $own_class->class_section;
            return view('users.profile', ['class_teacher' => $class_teacher]);
        } else
        if(Auth::guard('teacher')->check()) {
            $teacher = Teacher::get(Auth::guard('teacher')->user()->id);
            return view('users.profile', ['teacher' => $teacher]);
        } else
        if(Auth::guard('administrator')->check()) {
            $administrator = Administrator::where('id', Auth::guard('administrator')->user()->id);
            return view('users.profile', ['administrator' => $administrator]);
        }
    }

}