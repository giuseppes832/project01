<?php

namespace App\Models\Nodes;

use App\Models\Field;
use App\Models\Node;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class HtmlTime extends Model
{
    protected $table = "html_times";

    public function node(): MorphOne
    {
        return $this->morphOne(Node::class, 'html');
    }

    public function binding() : BelongsTo {

        return $this->belongsTo(Field::class, "binding_id", "id");

    }

    public function transformInput($inputValue) {
        return $inputValue?date_create_from_format('H:i', $inputValue):null;
    }
}
