<?php

namespace App\Models\Nodes;

use App\Models\Node;
use App\Models\NodeTrait;
use App\Models\Row;
use App\Models\ValueTypes\FKValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class HtmlForm extends Model
{


    use NodeTrait;
    protected $table = "html_forms";


    public function rows() {
        return $this->hasMany(Row::class, "form_id", "id");
    }

    public function row($id): HasOne {
        return $this->hasOne(Row::class, "form_id", "id")->where("rows.id", $id);
    }

    public function filteredRows($value, $filters) {

        $rel = $this->hasMany(Row::class, "form_id", "id");

        if ($value) {
            $rel->whereHas("values", function($query) use ($value) {
                $query->whereHasMorph("withValue", [FKValue::class], function ($query) use ($value) {
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
