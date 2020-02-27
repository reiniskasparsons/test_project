<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\DB;

class DBConnectionHelper
{
    /**
     * Check database connection, if something is wrong return false
     *
     * @return bool
     */
    public static function checkDBConnection(){
        try {
            DB::connection()->getPdo();
            if(!DB::connection()->getDatabaseName()){
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
