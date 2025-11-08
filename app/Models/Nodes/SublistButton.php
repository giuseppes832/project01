<?php

namespace App\Models\Nodes;

use App\Models\Node;
use App\Models\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class SublistButton extends Model
{

    use NodeTrait;

    protected $table = "sublist_buttons";


    public function listBinding() : BelongsTo {

        return $this->belongsTo(HtmlList::class, "list_binding_id", "id");

    }
}
