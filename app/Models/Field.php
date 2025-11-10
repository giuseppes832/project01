<?php

namespace App\Models;

use App\Models\Nodes\HtmlCheckbox;
use App\Models\Nodes\HtmlDate;
use App\Models\Nodes\HtmlTextarea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Schema;

class Field extends Model
{

    protected $table = "fields";

    public function withType(): MorphTo
    {
        return $this->morphTo();
    }

    public function resource() : BelongsTo {
        return $this->belongsTo(Resource::class, "resource_id", "id");
    }


    public function changeWithType($newFieldTypeClass) {


        if ($this->with_type_type !== $newFieldTypeClass) {

            if ($this->withType) {
                $this->withType->delete();
            }

            $newField = new $newFieldTypeClass;
            $newField->save();

            $newField->field()->save($this);

        }

    }

    public function values(Row $row) : HasMany {

        return $this->hasMany(Value::class, "field_id")->where("row_id", $row->id);
    }

    public function values0($rowId) : HasMany {
        return $this->hasMany(Value::class, "field_id")->where("row_id", $rowId);
    }

    public function allValues() : HasMany {
        return $this->hasMany(Value::class, "field_id");
    }

    public function bindedNodes($class) {
        $model = new $class;

        $column_names = Schema::getColumnListing($model->getTable());
        if (in_array('binding_id', $column_names)) {
            return $this->hasMany($class, "binding_id");
        } else {
            return null;
        }

    }




}
