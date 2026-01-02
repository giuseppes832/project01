<?php

namespace App\View\Components\Render;

use App\Models\Node as NodeModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HtmlTd extends Component
{
    public $value;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public NodeModel $selectedNode
    )
    {
        $optionalParameters = $this->selectedNode->html->optionalParameters;
        $row = \App\Models\Row::find($optionalParameters["row_id"]);

        if ($row) {
            $this->value = $row->getValue0($this->selectedNode);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.render.html-td');
    }
}
