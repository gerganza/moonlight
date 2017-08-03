<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'UserGroup';

    protected $fillable = [
        'UserID', 'GroupCode',
    ];

    public static function getUserGroup($id)
    {
        $usergroup = UserGroup::select('GroupCode')->where('UserID', $id)->first();

        if(isset($usergroup->GroupCode))
        {
            return $usergroup->GroupCode;
        }

        return 'USER';
    }
}
