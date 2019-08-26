<?php

namespace App\Rules;

use DB;
use Illuminate\Contracts\Validation\Rule;

class UniqueIndex implements Rule
{
    /**
     * Create a new rule instance.
     * @param mixed differentiator is topic_id or course_id or similar
     * @return void
     */
    public $table, $differentiator, $differentiator_value;
    public function __construct($table, $differentiator, $differentiator_value)
    {
        $this->table = $table;
        $this->differentiator = $differentiator;
        $this->differentiator_value = $differentiator_value;
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
        // check if this value doesn't already exist for items that have the same differentiator
        $existing = DB::table($this->table)->select()->where($this->differentiator, $this->differentiator_value)->where($attribute, $value)->count();
        
        return !$existing;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $model = str_singular($this->table);
        $diff = explode("_", $this->differentiator)[0];
        return "Sorry, a $model already exists with the same index in this $diff";
    }
}
