<?php

namespace App\Models\FieldTypes;

use App\Models\FieldTrait;
use App\Models\ValueTypes\DateTimeValue;
use App\Models\ValueTypes\TimeValue;
use Illuminate\Database\Eloquent\Model;

class DateTimeField extends Model
{
    use FieldTrait;

    protected $table = "date_time_fields";

    public function getValueClass() {
        return DateTimeValue::class;
    }
}
