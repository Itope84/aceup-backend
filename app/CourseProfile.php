<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseProfile extends Model
{
    protected $fillable = ['user_id', 'points', 'course_id'];

    public function boot()
    {
        parent::boot();

        self::saved(function($profile) {
            
        });
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
