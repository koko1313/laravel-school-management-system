<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class SubjectsController extends Controller {

    public function index() {
        $subjects = Subject::getAll();
        return view('subjects.index', ['subjects' => $subjects]);
    }

    public function form() {
        return view('subjects.form');
    }

    public function store(Request $req) {
        $this->validateInput($req);

        $subject_name = $req['subject_name'];

        $subject = new Subject();
        $subject->subject = $subject_name;

        try {
            $subject->save();
            return redirect(route('subjects'))->with('success', Lang::get('constants.success_messages.subject.added'));
        } catch(QueryException $ex){
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.subject.exist'));
            }
            return back()->with('error', Lang::get('constants.error_messages.subject.insert_error'));
        }
    }

    public function edit($id) {
        $subject = Subject::get($id);
        return view('subjects.form', ['subject' => $subject]);
    }

    public function update($id, Request $req) {
        $this->validateInput($req);

        $subject_name = $req['subject_name'];

        try {
            if(Subject::where('id', $id)->update(['subject' => $subject_name]) > 0)
                return redirect()->route('subjects')->with('success', Lang::get('constants.success_messages.subject.updated'));

            return redirect()->route('subjects');
        } catch(QueryException $ex) {
            // дублиращ се запис
            if($ex->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', Lang::get('constants.error_messages.subject.exist'));
            }
            return back()->with('error', Lang::get('constants.error_messages.subject.update_error'));
        }
    }

    public function delete($id) {
        try {
            Subject::where('id', $id)->delete();
            return redirect()->back()->with('success', Lang::get('constants.success_messages.subject.deleted'));
        } catch(QueryException $ex) {
            // външен ключ сочи към него
            if($ex->errorInfo[1] == 1451) {
                return redirect()->back()->with('error', Lang::get('constants.error_messages.subject.subject_has_grades'));
            }
            return redirect()->back()->with('error', Lang::get('constants.error_messages.subject.delete_error'));
        }
    }

    private function validateInput($req) {
        $this->validate($req, [
            'subject_name' => 'required'
        ]);
    }

}