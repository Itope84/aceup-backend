<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    const EASY_LEVEL = 'easy';
    const MEDIUM_LEVEL = 'medium';
    const DIFFICULT_LEVEL = 'difficult';

    protected $casts = ['options' => 'array', 'topic_id' => 'integer'];

    protected $fillable = ['body', 'options', 'difficulty', 'topic_id', 'explanation'];

    // setOptions mutator...
    public function setOptionsAttribute($value)
    {
        // logic for modifying that array here, do same for get
        /* Ensure that each option has the form:
        { $option;
        key: unique,
        body: html,
        is_answer: cast to boolean
        }
         */
        if (is_array($value) && count($value)) {
            $options = [];
            foreach ($value as $option) {
                $option = collect($option)->only(['key', 'body', 'is_answer'])->toArray();
                $option['is_answer'] = (bool) $option['is_answer'];
                $options[] = $option;
            }

            $this->attributes['options'] = json_encode($options);
        }
    }

    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }

    public function quizzes()
    {
        return $this->belongsToMany('App\Quiz', 'quiz_questions', 'question_id', 'quiz_id')->withPivot(['attempt']);
    }
}
