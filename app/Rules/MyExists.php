<?php

namespace App\Rules;

use App\Models\Node;
use App\Utilities\CommonService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MyExists implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $nodeId = explode(".", $attribute)[1];
        $node = Node::find($nodeId);

        $commonService = app()->make(CommonService::class);

        $defaultFilterValue = $commonService->getFilteringValue($node);

        if ($defaultFilterValue !== $value) {
            $fail('Il valore non è ammesso');
        }


    }
}
