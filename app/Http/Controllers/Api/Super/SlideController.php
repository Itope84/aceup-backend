<?php

namespace App\Http\Controllers\Api\Super;

use App\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Super\SlideRequest;
use App\Http\Resources\Super\SlideResource;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // check if request topic param is set, if so fetch slide for that topic, else, fetch all slides
        if(request()->topic) {
            $slides = Slide::whereTopicId(request()->topic)->orderBy('index')->paginate(10);
        } else {
            $slides = Slide::orderBy('index')->paginate(10);
        }
        return SlideResource::collection($slides);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlideRequest $request)
    {
        $data = $request->only(['topic_id', 'index', 'body', 'is_question', 'options']);

        $slide = Slide::create($data);

        return new SlideResource($slide);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function show(Slide $slide)
    {
        return (new SlideResource($slide))->additional(['topic' => $slide->topic]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function edit(Slide $slide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function update(SlideRequest $request, Slide $slide)
    {
        $data = $request->only(['topic_id', 'index', 'body', 'is_question', 'options']);

        $slide->update($data);

        return new SlideResource($slide);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        //
    }
}
