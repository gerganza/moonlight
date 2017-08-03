<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'Groups';

    protected $fillable = [
        'GroupName', 'GroupCode', 'description'
    ];
}
