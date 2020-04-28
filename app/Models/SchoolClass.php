<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SchoolClass extends Model {

    protected $table = 'classes';

    protected $fillable = ['class', 'class_section', 'class_teacher_id', 'graduating_year'];

    public static function getAll() {
        return DB::table('classes_view')->paginate(15);
    }

    public static function getAllOwn() {
        if(Teacher::isTeacherOrClassTeacher()) {
            $logged_teacher_id = Teacher::getLogged()->id;
            return DB::select('SELECT * FROM class_teachers_view WHERE teacher_id=? GROUP BY class_id', [$logged_teacher_id]);
        }
    }

    public static function getAllAsNumbers() {
        return DB::select('SELECT * FROM classes_view GROUP BY class');
    }

    public static function get($id) {
        return DB::select('SELECT * FROM classes_view WHERE id=?', [$id])[0];
    }

    public static function incrementAllClasses() {
        return DB::update('UPDATE classes SET class=class+1 WHERE class < 12');
    }

    public static function setAllFinishedClasses() {
        $graduaring_classes = DB::select('SELECT * FROM classes WHERE class = "12"'); // всички завършили
        foreach($graduaring_classes as $class) {
            $class_id = $class->id;
            $class_teacher_id = $class->class_teacher_id;

            Teacher::setRoleToTeacher($class_teacher_id); // правим им класните ръководители да са нормални учители
            DB::delete('DELETE FROM class_teachers WHERE class_id=?', [$class_id]); // изтриваме разпределението на кой клас - кои учители преподават за този клас
        }

        DB::update('UPDATE classes SET is_graduated=true WHERE class=?', [12]); // правим всички 12-ти класове завършили
    }

}