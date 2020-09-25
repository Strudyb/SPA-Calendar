<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

//    public function post()
//    {
//        return $this->belongsTo('App\Models\Post');
//    }

    public function specificResourcePath()
    {
        return '/comments/' . $this->id;
    }
}
