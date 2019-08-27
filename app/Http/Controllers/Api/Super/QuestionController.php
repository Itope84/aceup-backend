<?php

namespace App\Http\Controllers\Api\Super;

use App\Question;
use App\Http\Requests\Super\QuestionRequest;
use App\Http\Resources\Super\QuestionResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function index()
    {
        // check if request topic param is set, if so fetch question for that topic, else, fetch all questions
        if(request()->topic) {
            $questions = Question::whereTopicId(request()->topic)->latest()->paginate(10);
        } else {
            $questions = Question::latest()->paginate(10);
        }
        return QuestionResource::collection($questions);
    }

    public function store(QuestionRequest $request)
    {
        $data = $request->only(['body', 'options', 'difficulty', 'topic_id', 'explanation']);

        $question = Question::create($data);

        return new QuestionResource($question);
    }

    public function show(Question $question)
    {
        return (new QuestionResource($question))->additional(['topic' => $question->topic]);
    }

    public function update(QuestionRequest $request, Question $question)
    {
        $data = $request->only(['body', 'options', 'difficulty', 'topic_id', 'explanation']);

        $question->update($data);

        return new QuestionResource($question);
    }
}
