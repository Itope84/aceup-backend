<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    const EASY_LEVEL = 'easy';
    const MEDIUM_LEVEL = 'medium';
    const DIFFICULT_LEVEL = 'difficult';

    protected $casts = ['options' => 'array'];

    protected $fillable = ['body', 'options', 'difficulty', 'topic_id', 'explanation'];

    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }
}
