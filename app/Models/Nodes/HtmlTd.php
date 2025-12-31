<?php

namespace App\Models\Nodes;

use App\Models\Node;
use App\Models\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HtmlTd extends Model
{

    public $parameters;

    use NodeTrait;

    protected $table = "html_tds";

    public function renderingNode() : BelongsTo {
        return $this->belongsTo(Node::class, "node_rendering_id", "id");
    }

    public function setParameters($parameters) {
        $this->parameters = $parameters;
    }

}
