<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sharing extends Model
{

    protected $table = "sharings";

    public function sharingType(): MorphTo
    {
        return $this->morphTo();
    }


    public function changeSharingType($newSharingTypeClass) {


        if ($this->sharing_type_type !== $newSharingTypeClass) {

            if ($this->sharing_type_type) {
                $this->sharingType->delete();
            }

            $newField = new $newSharingTypeClass;
            $newField->save();

            $newField->sharing()->save($this);

        }

    }


    public function role() : BelongsTo {
        return $this->belongsTo(Role::class, "role_id", "id");
    }


}
