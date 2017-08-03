<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Profile extends Model
{
    protected $table = 'PROFILE';

    public static function getName($id)
    {
        $data = Profile::where('PROFILENO', $id)->get();

        foreach($data as $profile) {
            return $profile->NAME;
        }
    }
    
}
