<?php

namespace App\Http\Requests\Super;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => ['required', 'unique:users'], 
            'password' => ['required', 'string', 'min:6', 'confirmed'], 
            'first_name' => ['required'],
            'last_name' => ['required']
        ];
    }
}
