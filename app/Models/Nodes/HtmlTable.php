<?php

namespace App\Models\Nodes;

use App\Models\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HtmlTable extends Model
{


    use NodeTrait;

    protected $table = "html_tables";

    public function form(): BelongsTo {
        return $this->belongsTo(HtmlForm::class, "html_form_id", "id");
    }

    public function tr(): BelongsTo {
        return $this->belongsTo(HtmlTr::class, "html_tr_id", "id");
    }

}
