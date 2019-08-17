<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    const RANDOM_TYPE = 'random';
    const SOLVEBYTOPIC_TYPE = 'topic';
    const MOCK_TYPE = 'quiz';

    protected $fillable = ['type', 'user_id', 'topic_id', 'course_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // for solve by topic types
    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }

    public function questions()
    {
        return $this->belongsToMany('App\Question', 'quiz_questions', 'quiz_id', 'question_id')->withPivot(['attempt']);
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function generateQuestions()
    {
        // create questions here, 1 question for random, 10 for sbt based on topic and 20 for mock.
    }

    public function duration()
    {
        // calculate duration for quiz based on difficulty level of questions in current instance.
    }
}
