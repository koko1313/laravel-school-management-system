<?php

namespace App\Models\Grades;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SessionGrade extends Model {

    protected $table = 'session_grades';

    protected $fillable = ['student_egn', 'subject_id', 'grade_id', 'for_class', 'teacher_id', 'class_teacher_id'];

    public static function getAll() {
        $class_id = Session::get('workingClassId');
        $subject_id = Session::get('workingSubjectId');
        $for_class = Session::get('workingForClass');

        if(Student::isStudent()) {
            $logged_student_egn = Student::getLogged()->egn;

            return DB::table('session_grades_view')
                ->where([
                    ['student_egn', $logged_student_egn],
                    ['for_class', 'LIKE', $for_class],
                    ['grade_id', '<>', NULL]
                ])
                ->orderByDesc('for_class')
                ->orderBy('class_now')
                ->orderBy('class_no')
                ->orderBy('subject')
                ->paginate(15);
        }

        return DB::table('session_grades_view')
            ->where([
                ['class_now_id', 'LIKE', $class_id],
                ['subject_id', 'LIKE', $subject_id],
                ['for_class', 'LIKE', $for_class]
            ])
            ->orderByDesc('for_class')
            ->orderBy('class_now')
            ->orderBy('class_no')
            ->orderBy('subject')
            ->paginate(15);
    }

    public static function get($egn, $subject_id, $grade_id, $for_class) {
        return DB::select('SELECT * FROM session_grades WHERE student_egn=? AND subject_id=? AND grade_id=? AND for_class=?', [$egn, $subject_id, $grade_id, $for_class])[0];
    }

}