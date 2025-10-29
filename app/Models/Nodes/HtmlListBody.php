<?php

namespace App\Models\Nodes;

use App\Models\Field;
use App\Models\Node;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class HtmlListBody extends Model
{
    protected $table = "html_list_bodies";

    public function node(): MorphOne
    {
        return $this->morphOne(Node::class, 'html');
    }

}
