<?php

namespace App\Rules;

use App\Models\Node;
use App\Utilities\CommonService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class MyExists2 implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (Auth::user()->isInvitedUser()) {

            $nodeId = explode(".", $attribute)[1];
            $node = Node::find($nodeId);

            $commonService = app()->make(CommonService::class);
            $sharing = $commonService->getSharing();

            $authRows = $node->html->formBinding->filteredRows($sharing->id, null);

            $ids = $authRows->pluck("id")->toArray();

            if (!in_array($value, $ids)) {
                $fail('Il valore non è ammesso');
            }

        }


    }
}
