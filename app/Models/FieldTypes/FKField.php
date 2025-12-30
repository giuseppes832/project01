<?php

namespace App\Models\FieldTypes;

use App\Models\Field;
use App\Models\FieldTrait;
use App\Models\Resource;
use App\Models\ValueTypes\BooleanValue;
use App\Models\ValueTypes\FKValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class FKField extends Model
{

    use FieldTrait;

    protected $table = "f_k_fields";

    public function getValueClass() {
        return FKValue::class;
    }

    public function fkResource(): BelongsTo {
        return $this->belongsTo(Resource::class, "fk_resource_id", "id");
    }

    public function fkField(): BelongsTo {
        return $this->belongsTo(Field::class, "fk_field_id", "id");
    }


}
