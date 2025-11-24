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
        $this->rows = $commonService->getHtmlListFilteredRows($this->selectedNode);


    }






    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.render.html-list');
    }
}
