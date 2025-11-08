<?php

namespace App\Models\Nodes;

use App\Models\Node;
use App\Models\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class HtmlRow extends Model
{

    use NodeTrait;
    protected $table = "bootstrap_rows";


}
