<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class UserResetPassword extends Model
{
    protected $table = 'user_reset_password';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
