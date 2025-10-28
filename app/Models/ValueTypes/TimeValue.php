<?php

namespace App\Models\ValueTypes;

use Illuminate\Database\Eloquent\Model;

class TimeValue extends Model
{
    use \App\Models\ValueTrait;

    protected $table = "time_values";
}
