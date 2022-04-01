<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    protected $table = 'admins';
    protected $primaryKey = 'username';
    protected $hidden = [
        'password',
    ];
    public $incrementing = false;
}
