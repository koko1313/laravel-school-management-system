<?php

namespace App\Models\Grades;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CurrentGrade extends Model {

    protected $table = 'current_grades';

    protected $fillable = ['student_egn', 'subject_id', 'grade_id', 'term_id', 'for_class', 'teacher_id'];

    public static function getAll() {
        $class_id = Session::get('workingClassId');
        $subject_id = Session::get('workingSubjectId');
        $term_id = Session::get('workingTermId');
        $for_class = Session::get('workingForClass');

        if(Student::isStudent()) {
            $logged_student_egn = Student::getLogged()->egn;
            //return DB::select('SELECT * FROM current_grades_view WHERE student_egn=? AND (term_id LIKE ? ) AND (for_class LIKE ? ) AND (grade_id IS NOT NULL) ORDER BY for_class DESC, class_now, term_id, class_no, subject', [$logged_student_egn, $term_id, $for_class]);
            return DB::table('current_grades_view')
                ->where([
                    ['student_egn', $logged_student_egn],
                    ['term_id', 'LIKE', $term_id],
                    ['for_class', 'LIKE', $for_class],
                    ['grade_id', '<>', NULL]
                ])
                ->orderByDesc('for_class')
                ->orderBy('class_now')
                ->orderBy('term_id')
                ->orderBy('class_no')
                ->orderBy('subject')
                ->paginate(15);
        }

        //return DB::select('SELECT * FROM current_grades_view WHERE (class_now_id LIKE ? ) AND (subject_id LIKE ? ) AND (term_id LIKE ? ) AND (for_class LIKE ? ) ORDER BY for_class DESC, class_now, term_id, class_no, subject', [$class_id, $subject_id, $term_id, $for_class]);
        return DB::table('current_grades_view')
            ->where([
                ['class_now_id', 'LIKE', $class_id],
                ['subject_id', 'LIKE', $subject_id],
                ['term_id', 'LIKE', $term_id],
                ['for_class', 'LIKE', $for_class]
            ])
            ->orderByDesc('for_class')
            ->orderBy('class_now')
            ->orderBy('term_id')
            ->orderBy('class_no')
            ->orderBy('subject')
            ->paginate(15);
    }

    public static function get($egn, $subject_id, $grade_id, $term_id, $for_class) {
        return DB::select('SELECT * FROM current_grades WHERE student_egn=? AND subject_id=? AND grade_id=? AND term_id=? AND for_class=?', [$egn, $subject_id, $grade_id, $term_id, $for_class])[0];
    }

}