<?php

namespace App\Models\FieldTypes;

use App\Models\FieldTrait;
use App\Models\ValueTypes\FK2Value;
use Illuminate\Database\Eloquent\Model;

class FK2Field extends Model
{
    use FieldTrait;

    protected $table = "f_k2_fields";

    public function getValueClass() {
        return FK2Value::class;
    }
}
