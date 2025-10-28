<?php

namespace App\Models\FieldTypes;

use App\Models\FieldTrait;
use App\Models\ValueTypes\TimeValue;
use Illuminate\Database\Eloquent\Model;

class TimeField extends Model
{
    use FieldTrait;

    protected $table = "time_fields";

    public function getValueClass() {
        return TimeValue::class;
    }

}
