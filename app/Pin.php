<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    // subscription the pin is used in, to determine who used the pin.
    public function subscription_used_in()
    {
        return $this->hasOne('App\Subscription');
    }
}
