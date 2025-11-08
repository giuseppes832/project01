<?php

namespace App\View\Components\Render;

use App\Models\Node as NodeModel;
use App\Utilities\CommonService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class HtmlList extends Component
{

    public $rows;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public NodeModel $selectedNode
        )
    {

        $commonService = app()->make(CommonService::class);
        $node = $this->selectedNode;

        $rows = null;

        $filteringNode = $node->html->defaultFilterBinding;
        $defaultFilterValue = null;
        if ($filteringNode) {
            $defaultFilterValue = $commonService->getFilteringValue($filteringNode);
        }

        $filteringString = Request::query("filter");
        $filters = [];
        if ($filteringString) {
            $filters[$node->html->node1->html->binding->withType->getValueClass()] = $filteringString;
            $filters[$node->html->node2->html->binding->withType->getValueClass()] = $filteringString;
        }

        $rows = $node->html->binding->filteredRows($defaultFilterValue, $filters);


        $this->rows = $rows;


    }






    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.render.html-list');
    }
}
