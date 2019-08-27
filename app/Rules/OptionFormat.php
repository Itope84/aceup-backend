<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OptionFormat implements Rule
{
    // This rule is used to validate an array of options!
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $message = "";
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $options = $value;
        $answer = null;
        foreach($options as $key => $option) {
            
            if(!$option['key']) {
                $this->message = "The " . number_position($key + 1) . "option doesn't have a key!";
                return false;
            }
            if(!$option['body']) {
                $this->message = "Option " . $option['key'] . " Body is required";
                return false;
            }
            if(!!$option['is_answer']) {
                $answer = $option['key'];
            }
        }

        if(!$answer) {
            $this->message = "You have not marked any option as the correct answer.";
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
