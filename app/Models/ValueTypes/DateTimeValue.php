<?php

namespace App\Models\ValueTypes;

use Illuminate\Database\Eloquent\Model;

class DateTimeValue extends Model
{
    use \App\Models\ValueTrait;

    protected $table = "date_time_values";
}
