<?php

namespace App\Models\ValueTypes;

use App\Models\Sharing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FK2Value extends Model
{

    use \App\Models\ValueTrait;

    protected $table = "f_k2_values";

    public function sharing(): BelongsTo {
        return $this->belongsTo(Sharing::class, "value", "id");
    }
}
