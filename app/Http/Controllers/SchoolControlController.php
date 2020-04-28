<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;

class SchoolControlController extends Controller {

    public function index() {
        $terms = Term::getAll();
        $school_info = School::getInfo();
        return view('school_control.index', ['terms' => $terms, 'school_info' => $school_info]);
    }

    public function update(Request $req) {
        if($req->has('change_school_term_button')) {
            $term_id = $req->term_id;
            if(Term::setActiveTerm($term_id)) {
                return redirect()->back()->with('success', Lang::get('constants.success_messages.school.term_updated'));
            }
            return redirect()->back()->with('error', Lang::get('constants.error_messages.school.update_term_error'));
        } else
        if($req->has('change_school_details_button')) {
            $school_name = $req->school_name;
            $school_description = $req->school_description;

            if($req->hasFile('image')) {
                $this->validate($req, ['image' => 'image|mimes:jpeg']);
                Input::file('image')->move('images', "school_picture.jpg");
            }

            try {
                if(School::where('id', 1)->update(['school_name' => $school_name, 'description' => $school_description]) > 0)
                    return redirect()->back()->with('success', Lang::get('constants.success_messages.school.school_details_updated'));

                return redirect()->back();
            } catch(QueryException $ex) {
                return redirect()->back()->with('error', Lang::get('constants.error_messages.school.update_school_details_error'));
            }
        }
    }

    public function nextSchoolYear() {
        Term::setActiveTerm(1);
        SchoolClass::setAllFinishedClasses();
        SchoolClass::incrementAllClasses();

        return redirect()->back()->with('success', Lang::get('constants.success_messages.school.school_year_incremented'));
    }

}