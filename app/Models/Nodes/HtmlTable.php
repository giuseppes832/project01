<?php

namespace App\Models\Nodes;

use App\Models\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function parentTable(): BelongsTo {
        return $this->belongsTo(HtmlTable::class, "html_table_id", "id");
    }

    public function parentTableSelect(): BelongsTo {
        return $this->belongsTo(HtmlSelect::class, "html_select_id", "id");
    }

    public function childrenTables(): HasMany {
        return $this->hasMany(HtmlTable::class, "html_table_id", "id");
    }

}
