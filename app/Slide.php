<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $fillable = ['topic_id', 'index', 'body', 'is_question', 'options'];

    // Options should have property body and is_answer if it's the answer

    protected $casts = ['options' => 'array', 'index' => 'integer', 'topic_id' => 'integer'];

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

    public function attempts()
    {
        return $this->hasMany('App\SlideQuestionAttempt');
    }
}
