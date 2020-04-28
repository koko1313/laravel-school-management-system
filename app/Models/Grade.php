<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Grade extends Model {

    protected $table = 'grades';

    public static function getAll() {
        return DB::select('SELECT * FROM grades');
    }

}