<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['course_id', 'index', 'title', 'introduction'];

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function slides()
    {
        return $this->hasMany('App\Slide');
    }
}
