<?php

namespace App\Models\Nodes;

use App\Models\Field;
use App\Models\Node;
use App\Models\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class HtmlSelect extends Model
{

    use NodeTrait;
    protected $table = "html_selects";

    public function binding() : BelongsTo {

        return $this->belongsTo(Field::class, "binding_id", "id");

    }

    public function formFieldBinding() : BelongsTo {

        return $this->belongsTo(Node::class, "form_field_binding_id", "id");

    }

    public function formBinding() : BelongsTo {

        return $this->belongsTo(HtmlForm::class, "form_binding_id", "id");

    }
}
