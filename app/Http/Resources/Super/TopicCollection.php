<?php

namespace App\Http\Resources\Super;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TopicCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (\App\Topic $topic) {
            return collect([
                'id' => $topic->id,
                'course_id' => $topic->course_id,
                'course' => $topic->course->title,
                'index' => $topic->index,
                'title' => $topic->title,
                'introduction' => $topic->introduction,
            ]);
        });
        return parent::toArray($request);
    }
}
