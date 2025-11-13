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

            $authParentRows = $this->selectedNode->html->formBinding->filteredRows($sharing->id, null);

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

                $fkValue = $this->selectedNode->html->binding->values($formRow)->first();

                $row = $this->selectedNode->html->formBinding->row($fkValue->withValue->value)->first();

                if ($row) {
                    $genericValue = $this->selectedNode->html->formFieldBinding->html->binding->values($row)->first();

                    if ($genericValue) {
                        $this->value = $genericValue->row_id;
                    }
                }

            } else {

                $fkValues = $this->selectedNode->html->binding->values($formRow)->get();

                $this->value = [];

                foreach ($fkValues as $fkv) {

                    $row = $this->selectedNode->html->formBinding->row($fkv->withValue->value)->first();

                    if ($row) {
                        $genericValue = $this->selectedNode->html->formFieldBinding->html->binding->values($row)->first();

                        if ($genericValue) {
                            $this->value[] = $genericValue->row_id;
                        }
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

        // Security Check 1
        if (Auth::user()->isInvitedUser() && $this->selectedNode->html->subselect && !Request::filled("parent_row_id")) {
            abort(403);
        }

        // Security Check 2
        $commonService = app()->make(CommonService::class);
        if (Auth::user()->isInvitedUser() && $this->selectedNode->html->subselect && !$commonService->getFilteringValue($this->selectedNode)) {
            // Unused
            abort(403);
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
