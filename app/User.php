<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['firstname', 'lastname', 'email', 'personal_code'];

    public $timestamps = false;
}