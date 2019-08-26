<?php

namespace App\Http\Requests\Super;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueIndex;

class TopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'course_id' => ['required', 'exists:courses,id'], 
            'index' => ['required', 'integer', 'min:1'], 
            'title' => ['required'],
            'introduction' => ['required']
        ];

        if(!request()->id || \App\Topic::find(request()->id)->index != request()->index) {
            $rules['index'][] = new UniqueIndex('topics', 'course_id', request()->course_id);
        }

        return $rules;
    }
}
