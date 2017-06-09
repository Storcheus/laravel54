<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'view_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['firstname', 'lastname', 'email', 'personal_code'];

    public $timestamps = false;

    /**
     * get all address for user.
     */
    public function address()
    {
        return $this->hasMany('App\Address');
    }
}