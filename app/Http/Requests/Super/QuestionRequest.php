<?php

namespace App\Http\Requests\Super;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OptionFormat;

class QuestionRequest extends FormRequest
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
            'body' => ['required'],
            'difficulty' => ['required', 'in:easy,medium,difficult'],
            'options' => ['required', 'array', 'min:2', new OptionFormat()]
        ];

        return $rules;
    }
}
