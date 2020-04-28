<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Term extends Model {

    protected $table = 'terms';

    protected $fillable = ['term', 'term_label', 'term_now'];

    public static function getAll() {
        return DB::select('SELECT * FROM terms');
    }

    public static function get($id) {
        return DB::select('SELECT * FROM terms WHERE id=?', [$id])[0];
    }

    public static function getTermNow() {
        return DB::select('SELECT * FROM terms WHERE now = 1')[0];
    }

    // връща последния учебен срок
    public static function getLastTerm() {
        return DB::select('SELECT * FROM terms ORDER BY term DESC LIMIT 1')[0];
    }

    public static function setActiveTerm($id) {
        if(DB::update('UPDATE terms SET now = 0 WHERE 1')) {
            if(DB::update('UPDATE terms SET now = 1 WHERE id=?', [$id])) {
                return true;
            }
        }
        return false;
    }

}