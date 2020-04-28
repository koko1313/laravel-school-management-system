<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class School extends Model {

    protected $table = 'school';

    protected $fillable = ['school_name', 'description'];

    public static function getInfo() {
        return DB::select('SELECT * FROM school')[0];
    }

}