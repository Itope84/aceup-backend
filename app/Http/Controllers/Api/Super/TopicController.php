<?php

namespace App\Http\Controllers\Api\Super;

use App\Topic;
use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Resources\Super\TopicCollection;
use App\Http\Resources\Super\CourseCollection;
use App\Http\Resources\Super\TopicResource;
use App\Http\Requests\Super\TopicRequest;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        // TODO: Implement filters;
        return (new TopicCollection(Topic::with('course')->paginate(40)))->additional(['courses' => new CourseCollection(Course::all())]);
    }

    public function store(TopicRequest $request)
    {
        $data = $request->only(['course_id', 'index', 'title', 'introduction']);

        $topic = Topic::create($data);

        return new TopicResource($topic);
    }

    public function show(Topic $topic)
    {
        return new TopicResource($topic);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $data = $request->only(['course_id', 'index', 'title', 'introduction']);

        $topic->update($data);

        return new TopicResource($topic);
    }
}
