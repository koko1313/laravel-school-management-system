<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teacher_subject extends Model {

    protected $table = 'teachers_subjects';

    protected $fillable = ['teacher_id', 'subject_id'];

    public static function getAll() {
        return DB::table('teachers_subjects_view')->paginate(15);
    }

    public static function get($subject_id, $teacher_id) {
        return DB::select('SELECT * FROM teachers_subjects_view WHERE subject_id=? AND teacher_id=?', [$subject_id, $teacher_id])[0];
    }

}