<?php

namespace App\Models\Nodes;

use App\Models\Field;
use App\Models\Node;
use App\Models\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class HtmlInputText extends Model
{

    use NodeTrait;

    protected $table = "html_input_texts";

    public function binding() : BelongsTo {

        return $this->belongsTo(Field::class, "binding_id", "id");

    }

}
