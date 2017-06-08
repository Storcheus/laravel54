<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['user_id', 'country', 'city', 'address'];

    public $timestamps = false;

    /**
     * get.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}