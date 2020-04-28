<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Rules\Captcha;

class LoginController extends Controller {

    public function login(Request $req) {
        $this->validate($req, [
           'username' => 'required',
           'password' => 'required',
           'g-recaptcha-response' => new Captcha()
        ]);

        $username = $req['username'];
        $password = $req['password'];

        $student = Student::where([
            ['username', $username],
            ['password', $password]
        ])->first();

        $teacher = Teacher::where([
            ['username', $username],
            ['password', $password],
            ['role_id', 3]
        ])->first();

        $class_teacher = Teacher::where([
            ['username', $username],
            ['password', $password],
            ['role_id', 2]
        ])->first();

        $admin = Administrator::where([
            ['username', $username],
            ['password', $password]
        ])->first();

        if($student) Auth::guard('student')->login($student);
        else if($teacher) Auth::guard('teacher')->login($teacher);
        else if($class_teacher) Auth::guard('teacher')->login($class_teacher);
        else if($admin) Auth::guard('administrator')->login($admin);

        if($student || $teacher || $class_teacher || $admin) {
            return redirect()->route('index');
        } else {
            return redirect()->back()->with('error', Lang::get('constants.error_messages.invalid_username_or_password'));
        }
    }

    public function logout() {
        if(Auth::guard('teacher')->user()) $guard = 'teacher';
        else if(Auth::guard('administrator')->user()) $guard = 'administrator';
        else if(Auth::guard('student')->user()) $guard = 'student';

        if(isset($guard)) {
            Auth::guard($guard)->logout();
            session()->flush();
        }
        return redirect()->route('index');
    }

}