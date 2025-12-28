<?php

namespace App\Models\Nodes;

use App\Models\Node;
use App\Models\NodeTrait;
use App\Models\Resource;
use App\Models\Row;
use App\Models\ValueTypes\FKValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class HtmlForm extends Model
{


    use NodeTrait;
    protected $table = "html_forms";


    public function resource(): BelongsTo {
        return  $this->belongsTo(Resource::class, "resource_id", "id");
    }


}
