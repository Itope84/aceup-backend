<?php

namespace App\Http\Requests\Super;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueIndex;

class SlideRequest extends FormRequest
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
            'topic_id' => ['required', 'exists:topics,id'],
            'index' => ['required', 'integer', 'min:1'],
            'body' => ['required'],
            'is_question' => ['boolean'], 
            'optios.*.key' => ['required'],
            'options.*.body' => ['required'],
            'options.*.is_answer' => ['boolean']
        ];

        if(!request()->id || \App\Slide::find(request()->id)->index != request()->index) {
            $rules['index'][] = new UniqueIndex('slides', 'topic_id', request()->topic_id);
        }

        if(isset(request()->is_question) && request()->is_question) {
            $optionRules = ['array', 'required'];
            $rules['options'] = $optionRules;
        }

        return $rules;
    }
}
