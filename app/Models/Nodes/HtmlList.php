<?php

namespace App\Models\Nodes;

use App\Models\Node;
use App\Models\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class HtmlList extends Model
{
    use NodeTrait;
    protected $table = "html_lists";
    

    public function node1() : BelongsTo {
        return $this->belongsTo(Node::class, "node_id1", "id");
    }

    public function node2() : BelongsTo {
        return $this->belongsTo(Node::class, "node_id2", "id");
    }

    public function binding() : BelongsTo {
        return $this->belongsTo(HtmlForm::class, "binding_id", "id");
    }

    public function defaultFilterBinding() : BelongsTo {
        return $this->belongsTo(Node::class, "default_filter_binding_id", "id");
    }

}
