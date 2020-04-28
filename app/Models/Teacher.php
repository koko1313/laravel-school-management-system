<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable {

    protected $table = 'teachers';

    protected $fillable = ['first_name', 'last_name', 'username', 'password', 'role_id'];

    protected $guard = 'teacher';

    public static function getAll() {
        return DB::select('SELECT * FROM teachers ORDER BY first_name, last_name');
    }

    public static function get($id) {
        return DB::select('SELECT * FROM teachers WHERE id=? ORDER BY first_name, last_name', [$id])[0];
    }

    public static function setRoleToClassTeacher($id) {
        DB::update('UPDATE teachers SET role_id = 2 WHERE id=?', [$id]);
    }

    public static function setRoleToTeacher($id) {
        DB::update('UPDATE teachers SET role_id = 3 WHERE id=?', [$id]);
    }

    public static function getOwnClass($teacher_id = 0) {
        if($teacher_id == 0) $teacher_id = Teacher::getLogged()->id;
        $class = DB::select('SELECT * FROM classes WHERE class_teacher_id=?', [$teacher_id]);
        if($class) return $class[0];
    }

    public static function getLogged() {
        return Auth::guard('teacher')->user();
    }

    public static function isClassTeacher($id = 0) {
        if($id != 0) {
            return DB::select('SELECT * FROM teachers WHERE id=?', [$id])[0]->role_id == 2;
        }
        return Auth::guard('teacher')->check() && Auth::guard('teacher')->user()->role_id == 2;
    }

    public static function isTeacher() {
        return Auth::guard('teacher')->check() && Auth::guard('teacher')->user()->role_id == 3;
    }

    public static function isTeacherOrClassTeacher() {
        return self::isTeacher() || self::isClassTeacher();
    }

    public static function existUser($username) {
        return sizeof(DB::select('SELECT * FROM teachers WHERE username=?', [$username])) > 0;
    }

}