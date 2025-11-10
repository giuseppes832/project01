<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Value extends Model
{

    protected $table = "values";

    public function withValue(): MorphTo
    {
        return $this->morphTo();
    }

    public function field(): BelongsTo {
        return $this->belongsTo(Field::class, "field_id", "id");
    }

    public function relatedRow(): BelongsTo {
        return $this->belongsTo(Row::class, "row_id");
    }

}
