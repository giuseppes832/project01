<?php

namespace App\Models\ValueTypes;

use App\Models\Nodes\HtmlSelect;
use App\Models\Nodes\HtmlSharingSelect;
use App\Models\Row;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class FKValue extends Model
{
    use \App\Models\ValueTrait;

    protected $table = "f_k_values";

    public function row($type) {
        if (HtmlSelect::class === $type) {
            return $this->belongsTo(Row::class, "value", "id")->first();
        } else if (HtmlSharingSelect::class === $type) {
            return $this->belongsTo(Row::class, "value", "id")->first();
        }
    }
}
