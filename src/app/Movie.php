<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['title', 'length', 'year', 'rating','format'];
    protected $hidden = ['user_id',];
}
