<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resource extends Model
{
    protected $table = "resources";

    public function fields() : HasMany {
        return $this->hasMany(Field::class, "resource_id", "id");
    }

}
