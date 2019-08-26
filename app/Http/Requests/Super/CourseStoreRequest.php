<?php

namespace App\Http\Requests\Super;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // The super middleware is already being applied
        return Auth::user()->is_super();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // TODO: Apply regex to color_scheme
        return [
            'title' => ['required'],
            'description' => ['required'], 
            'featured_image' => ['required', 'string'], 
            'color_scheme' => ['required']
        ];
    }
}
