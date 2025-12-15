<?php

namespace App\Models;

use App\Models\Nodes\HtmlForm;
use App\Models\Nodes\HtmlSelect;
use App\Models\Nodes\HtmlSharingSelect;
use App\Models\ValueTypes\FKValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Row extends Model
{

    protected $table = "rows";

    public function form() : BelongsTo {
        return $this->belongsTo(HtmlForm::class, "form_id", "id");
    }

    public function getValue($node) {

        if ($node->html && $node->html->binding) {
            $genericValue = $node->html->binding->values($this)->first();
            if ($genericValue) {

                if (HtmlSelect::class === $node->html_type || HtmlSharingSelect::class === $node->html_type) {

                    if ($genericValue->withValue) {
                        $row = $genericValue->withValue->row($node->html_type);
                        $refValue = $node->html->formFieldBinding->html->binding->values($row)->first();

                        if ($refValue) {

                            if ($refValue->withValue) {
                                $value = $refValue->withValue;
                                return $value->value;
                            } else {
                                return null;
                            }

                        } else {
                            return null;
                        }
                    } else {
                        return null;
                    }

                } else {

                    if ($genericValue->withValue) {
                        $value = $genericValue->withValue;
                        return $value->value;
                    } else {
                        return null;
                    }

                }

            } else {
                return null;
            }
        }



    }

    public function fkValues() : HasMany {
        return $this->hasMany(FKValue::class, "value", "id");
    }

    public function values() : HasMany {
        return $this->hasMany(Value::class, "row_id", "id");
    }



}
