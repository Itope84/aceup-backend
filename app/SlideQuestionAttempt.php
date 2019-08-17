<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlideQuestionAttempt extends Model
{
    protected $fillable = ['user_id', 'attempt', 'slide_id'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function slide()
    {
        return $this->belongsTo('App\Slide');
    }
}
