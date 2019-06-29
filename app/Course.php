<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }

    public function registrants()
    {
        return $this->hasMany('App\CourseProfile');
    }
}
