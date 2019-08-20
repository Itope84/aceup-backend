<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'featured_image', 'color_scheme'];
    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }

    public function registrants()
    {
        return $this->hasMany('App\CourseProfile');
    }

    public function challenges()
    {
        return $this->hasMany('App\Challenge');
    }
}
