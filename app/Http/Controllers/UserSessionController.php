<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Administrator;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Term;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class UserSessionController extends Controller {

    private static $class_id;
    private static $subject_id;
    private static $term_id;
    private static $for_class;

    private static function getInput() {
        self::$class_id = Input::get('class_id');
        self::$subject_id = Input::get('subject_id');
        self::$term_id = Input::get('term_id', 0);
        self::$for_class = Input::get('for_class', 0);
    }

    // добавя в сесията всичко, с което работим в момента
    public static function setCurrentWorking() {
        self::getInput();

        if(Student::isStudent()) {
            self::$class_id = Student::getLogged()->class_id;
            self::$subject_id = '%';
        }

        self::setWorkingTermId();
        self::setWorkingForClass();
        self::setWorkingClass();
        self::setWorkingSubject();
    }

    private static function setWorkingClass() {
        $class_id = self::$class_id;
        $for_class = self::$for_class;

        if($class_id != '%' && $class_id!=0) {
            $workingClass = SchoolClass::get($class_id);
            
            if(Administrator::isAdministrator()) {
                $workingClassName = $workingClass->class . ' ' . $workingClass->class_section . ' ' . $workingClass->graduating_year;
            } else {
                $workingClassName = $workingClass->class . ' ' . $workingClass->class_section;
            }

            $workingClassNumber = $workingClass->class;

            Session::put('workingClassId', $class_id);
            Session::put('workingClassName', $workingClassName);
            Session::put('workingClassNumber', $workingClassNumber);
            Session::put('workingForClass', $for_class);

            Session::forget('workingSubjectId');
        }
    }

    private static function setWorkingSubject() {
        $subject_id = self::$subject_id;

        if($subject_id != '%' && $subject_id!=0) {
            $workingSubjectName = Subject::get($subject_id)->subject;
            Session::put('workingSubjectId', $subject_id);
            Session::put('workingSubjectName', $workingSubjectName);
        }
    }

    private static function setWorkingTermIdToNow() {
        Session::put('workingTermId', Term::getTermNow()->id);
        Session::put('workingTermName', Term::getTermNow()->term_label);
    }

    private static function setWorkingTermId() {
        $term_id = self::$term_id;

        if(!Session::has('workingTermId')) {
            self::setWorkingTermIdToNow();
        }

        // ако е зададено и е различно от сегашното
        if($term_id!= 0 && Session::get('workingTermId') != $term_id) {
            Session::put('workingTermId', $term_id);
            Session::put('workingTermName', Term::get($term_id)->term_label);
        }
    }

    private static function setWorkingForClass() {
        $for_class = self::$for_class;

        // ако е зададено и е различно от сегашното
        if($for_class!= 0 && Session::get('workingForClass') != $for_class) {
            Session::put('workingForClass', $for_class);
        }

        if(!Student::isStudent() && !Session::get('workingForClass')) {
            Session::put('workingForClass', $for_class);
            self::setWorkingTermIdToNow();
        }
    }

}