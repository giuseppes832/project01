<?php

namespace App\Models;

use App\Models\Nodes\HtmlSelect;
use App\Models\Nodes\HtmlSharingSelect;
use App\Models\ValueTypes\FK2Value;
use App\Models\ValueTypes\FKValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Resource extends Model
{
    protected $table = "resources";

    public function fields() : HasMany {
        return $this->hasMany(Field::class, "resource_id", "id");
    }



    public function rows() {
        return $this->hasMany(Row::class, "resource_id", "id");
    }

    public function row($id): HasOne {
        return $this->hasOne(Row::class, "resource_id", "id")->where("rows.id", $id);
    }

    public function filteredRows($value, $filters) {

        $rel = $this->hasMany(Row::class, "resource_id", "id");

        if ($value) {
            $rel->whereHas("values", function($query) use ($value) {
                $query->whereHasMorph("withValue", [FK2Value::class], function ($query) use ($value) {
                    $query->where("value", $value);
                });
            });
        }

        if ($filters) {
            $rel->whereHas("values", function($query) use ($filters) {

                $index = 0;
                foreach ($filters as $filterClass => $filterValue) {
                    if ($index) {
                        $query->orWhereHasMorph("withValue", [$filterClass], function($query) use ($filterValue, $filterClass) {
                            if ((HtmlSelect::class === $filterClass) || (HtmlSharingSelect::class === $filterClass)) {
                                $query->whereHas("row", function ($query) use ($filterValue) {
                                    $query->whereHas("values", function($query) use ($filterValue) {
                                        $query->whereHas("withValue", function ($query) use ($filterValue) {
                                            $query->where("value", "like", "%$filterValue%");
                                        });
                                    });
                                });
                            } else {
                                $query->where("value", "like", "%$filterValue%");
                            }
                        });
                    } else {
                        $query->whereHasMorph("withValue", [$filterClass], function($query) use ($filterValue, $filterClass) {
                            if (FKValue::class === $filterClass) {
                                $query->whereHas("row", function ($query) use ($filterValue) {
                                    $query->whereHas("values", function($query) use ($filterValue) {
                                        $query->whereHas("withValue", function ($query) use ($filterValue) {
                                            $query->where("value", "like", "%$filterValue%");
                                        });
                                    });
                                });
                            } else {
                                $query->where("value", "like", "%$filterValue%");
                            }
                        });
                    }

                    $index++;
                }
            });
        }

        return $rel->get();

    }

}
