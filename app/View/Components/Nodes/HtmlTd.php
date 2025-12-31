<?php

namespace App\View\Components\Nodes;

use App\Models\Node as NodeModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HtmlTd extends Component
{
    public $nodes;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public \App\Models\Node $selectedNode
    )
    {

        $this->nodes = NodeModel::all();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nodes.html-td');
    }
}
