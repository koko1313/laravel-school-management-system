<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subject extends Model {

    protected $table = 'subjects';

    protected $fillable = ['subject'];

    public static function getAll() {
        return DB::table('subjects')->orderBy('subject')->paginate(15);
    }

    public static function get($subject_id) {
        return DB::select('SELECT * FROM subjects WHERE id=? ORDER BY subject', [$subject_id])[0]; // ако е администратор
    }

    public static function getAllOwn() {
        if(Teacher::isTeacherOrClassTeacher()) {
            $logged_teacher_id = Teacher::getLogged()->id;
            return DB::select('SELECT * FROM teachers_subjects_view WHERE teacher_id=?', [$logged_teacher_id]);
        }
    }

    public static function isOwn($subject_id) {
        $logged_teacher_id = Teacher::getLogged()->id;
        return count(DB::select('SELECT * FROM teachers_subjects_view WHERE teacher_id=? AND subject_id=?', [$logged_teacher_id, $subject_id])) > 0;
    }
}