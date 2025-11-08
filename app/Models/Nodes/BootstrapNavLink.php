<?php

namespace App\Models\Nodes;

use App\Models\Node;
use App\Models\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class BootstrapNavLink extends Model
{

    use NodeTrait;
    protected $table = "bootstrap_nav_links";

    public function ref() : BelongsTo {
        return $this->belongsTo(Node::class, "ref_id", "id");
    }
}
