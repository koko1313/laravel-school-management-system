<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable {

    protected $table = 'students';

    protected $fillable = ['egn', 'first_name', 'second_name', 'last_name', 'class_no', 'class_id', 'description', 'username', 'password', 'role_id'];

    protected $primaryKey = 'egn';

    public $incrementing = false;

    protected $guard = 'student';

    public static function getAll() {
        if(Teacher::isClassTeacher()) {
            $logged_teacher_id = Teacher::getLogged()->id;
            return DB::table('students_view')->where('class_teacher_id', $logged_teacher_id)->where('is_graduated', 'false')->paginate(15);
        }
        return DB::table('students_view')->orderBy('class')->orderBy('class_no')->paginate(15);
    }

    public static function get($egn) {
        $student = DB::select('SELECT * FROM students_view WHERE egn=?', [$egn]);
        if($student) return $student[0];
    }

    // връща всички ученици, на които логнатия преподавател преподава
    public static function getAllOwn() {
        $logged_teacher_id = Teacher::getLogged()->id;
        return DB::select('SELECT * FROM students_teachers_view WHERE teacher_id=? AND (class_id LIKE ? )', [$logged_teacher_id, SESSION::get('workingClassId')]);
    }

    public static function isOwn($student_egn) {
        $logged_teacher_id = Teacher::getLogged()->id;
        return count(DB::select('SELECT * FROM students_teachers_view WHERE teacher_id=? AND student_egn=?', [$logged_teacher_id, $student_egn])) > 0;
    }

    public static function getLogged() {
        return Auth::guard('student')->user();
    }

    public static function isStudent() {
        return Auth::guard('student')->check();
    }

    public static function existUser($username) {
        return sizeof(DB::select('SELECT * FROM students WHERE username=?', [$username])) > 0;
    }

}