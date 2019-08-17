<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = ['challenger_id', 'opponent_id', 'course_id'];

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function challenger()
    {
        return $this->belongsTo('App\User', 'challenger_id');
    }

    public function opponent()
    {
        return $this->belongsTo('App\User', 'opponent_id');
    }

    public function questions()
    {
        return $this->belongsToMany('App\Question', 'challenge_questions', 'challenge_id', 'question_id')->withPivot(['challenger_attempt', 'opponent_attempt']);
    }
}
