<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Utilities\HtmlNodeTypes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Node extends Model
{
    protected $table = "nodes";


    public function html(): MorphTo
    {
        return $this->morphTo();
    }

    public function matchingField(): MorphTo
    {
        return $this->morphTo();
    }

    public function children() : HasMany {

        return $this->hasMany(Node::class, "parent_id", "id");

    }


    public function getSelectedNodeRenderComponent() {

        $founded = null;

        foreach (HtmlNodeTypes::getValues() as $nodeType => $node) {

            if ($this->html_type === $node["class"]) {
                $founded = $node["render-component"];
            }

        }

        return $founded;

    }


    public function changeHtmlType($newFieldTypeClass) {


        if ($this->html_type !== $newFieldTypeClass) {

            if ($this->html_type) {
                $this->html->delete();
            }


            $newField = new $newFieldTypeClass;
            $newField->save();

            $newField->node()->save($this);

        }

    }


    public function parent() : BelongsTo {
        return $this->belongsTo(Node::class, "parent_id", "id");
    }

    public function app() : BelongsTo {

        return $this->belongsTo(App::class, "app_id", "id");

    }

    public function sharing($sharingId) : BelongsToMany {
        return $this->belongsToMany(Sharing::class, "shared_nodes", "node_id", "sharing_id")->where("sharing_id", $sharingId);
    }

}
