<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Class_Teacher extends Model {

    protected $table = 'class_teachers';

    protected $fillable = ['class_id', 'teacher_id'];

    public static function getAll() {
        return DB::table('class_teachers_view')->paginate('15');
    }

    public static function get($class_id, $teacher_id) {
        return DB::select('SELECT * FROM class_teachers_view WHERE class_id=? AND teacher_id=?', [$class_id, $teacher_id])[0];
    }

}