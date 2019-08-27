<?php

namespace App\Http\Requests\Super;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueIndex;
use App\Rules\OptionFormat;

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
        ];

        if(!request()->id || \App\Slide::find(request()->id)->index != request()->index) {
            $rules['index'][] = new UniqueIndex('slides', 'topic_id', request()->topic_id);
        }

        if(isset(request()->is_question) && request()->is_question) {
            $optionRules = ['required', 'array', new OptionFormat()];
            $rules['options'] = $optionRules;
        }

        return $rules;
    }
}
