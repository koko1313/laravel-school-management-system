<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Administrator extends Authenticatable {

    protected $table = 'administrators';

    protected $guard = 'administrator';

    public static function existUser($username) {
        return sizeof(DB::select('SELECT * FROM administrators WHERE username=?', [$username])) > 0;
    }

    public static function isAdministrator() {
        return Auth::guard('administrator')->check();
    }
}