<?php

namespace App\Rules;

use App\Models\Node;
use App\Models\Row;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MyUnique implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $nodeId = explode(".", $attribute)[1];
        $valueClass = Node::find($nodeId)->html->binding->withType->getValueClass();

        $value0 = null;

        if("POST" === request()->method()) {
            $value0 = Row::whereHas("values", function ($query) use ($value, $valueClass) {
                $query->whereHasMorph("withValue", [$valueClass], function ($query) use ($value) {
                    $query->where("value", $value);
                });
            })->first();

        } elseif ("PUT" === request()->method()) {

            $currentValue = request()->nodes[$nodeId];

            $value0 = Row::whereHas("values", function ($query) use ($value, $valueClass, $currentValue) {
                $query->whereHasMorph("withValue", [$valueClass], function ($query) use ($value,$currentValue) {
                    $query->where("value", $value);
                    $query->where("value", "<>", $currentValue);
                });
            })->first();
        }

        if ($value0) {
            $fail('Il valore deve essere unico');
        }

    }
}
