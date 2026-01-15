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


    public function filteredRows($value, $othersFilters) {


        $rel = $this->hasMany(Row::class, "resource_id", "id");

        if (isset($value["node"]) && isset($value["filterValue"])) {

            $node = $value["node"];
            $filterValue = $value["filterValue"];

            if (HtmlSelect::class === $node->node->html_type) {
                $rel->whereHas("values", function($query) use ($filterValue) {
                    $query->whereHasMorph("withValue", [FKValue::class], function ($query) use ($filterValue) {
                        $query->where("value", $filterValue);
                    });
                });
            } else if (HtmlSharingSelect::class === $node->node->html_type) {
                $rel->whereHas("values", function($query) use ($filterValue) {
                    $query->whereHasMorph("withValue", [FK2Value::class], function ($query) use ($filterValue) {
                        $query->where("value", $filterValue);
                    });
                });
            }

        }

        if ($othersFilters) {
            $rel->whereHas("values", function($query) use ($othersFilters) {

                $index = 0;
                foreach ($othersFilters as $otherFilter) {

                    $filterClass = $otherFilter["class"];
                    $filterValue = $otherFilter["value"];

                    if ($index) {
                        $query->orWhereHasMorph("withValue", [$filterClass], function($query) use ($filterValue, $filterClass) {
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
