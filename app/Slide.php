<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $fillable = ['topic_id', 'index', 'body', 'is_question', 'options'];

    protected $casts = ['options' => 'array', 'is_question' => 'boolean'];


    // setOptions accessor...
    public function setOptionsAttribute($value)
    {
        // logic for modifying that array here, do same for get
    }

    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }

    public function attempts()
    {
        return $this->hasMany('App\SlideQuestionAttempt');
    }
}
