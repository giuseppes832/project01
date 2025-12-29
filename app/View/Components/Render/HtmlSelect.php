<?php

namespace App\View\Components\Render;

use App\Models\Node;
use App\Models\SvIntegerValue;
use App\Utilities\CommonService;
use App\Utilities\FieldTypes;
use App\Utilities\Menu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class HtmlSelect extends Component
{

    public $options;

    public $value;

    public $fk;

    /**
     * Create a new component instance.
     */
    public function __construct(

        public Node $selectedNode
    )
    {

        if (Auth::user()->isInvitedUser()) {

            $commonService = app()->make(CommonService::class);
            $sharing = $commonService->getSharing();

            $authParentRows = $this->selectedNode->html->formBinding->resource->filteredRows($sharing->id, null);

            $options = [];

            foreach ($authParentRows as $authParentRow) {

                $options[] = $this->selectedNode->html->formFieldBinding->html->binding->values($authParentRow)->first();
            }

            $this->options = collect($options);

        } else {

            // Get all values of HtmlInputText
            $this->options = $this->selectedNode->html->formFieldBinding->html->binding->allValues;

        }



        $formRow = Menu::getRow();

        if ($formRow) {
            if (!$this->selectedNode->html->multiple) {

                // Get FK
                $fkValue = $this->selectedNode->html->binding->values($formRow)->first();

                if ($fkValue) {
                    $this->value = $fkValue->withValue->value;
                }

            } else {

                $fkValues = $this->selectedNode->html->binding->values($formRow)->get();

                if ($fkValues) {
                    $this->value = [];

                    foreach ($fkValues as $fkv) {
                        $this->value[] = $fkv->withValue->value;
                    }

                }

            }

        }

        if (Request::filled("parent_row_id")) {

            if (in_array(intval(Request::query("parent_row_id")), $this->options->pluck("row_id")->toArray())) {
                $this->value = intval(Request::query("parent_row_id"));

                $newOptions = [];
                foreach ($this->options as $option) {
                    if ($this->value === $option->row_id){
                        $newOptions[] = $option;
                    }

                }

                $this->options = $newOptions;

            }

        }


        // Authorization Check
        if (Auth::user()->isInvitedUser() && $this->selectedNode->html->subselect) {

            if (!Request::filled("parent_row_id")) {
                abort(403);
            }

            $commonService = app()->make(CommonService::class);
            $sharing = $commonService->getSharing();
            $verified = $commonService->isFilteringRowVerified(Request::query("parent_row_id"), $sharing->id);

            if (!$verified) {
                abort(403);
            }

        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.render.html-select');
    }
}
