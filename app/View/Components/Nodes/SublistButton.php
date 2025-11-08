<?php

namespace App\View\Components\Nodes;

use App\Models\Node;
use App\Models\Nodes\HtmlList;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SublistButton extends Component
{

    public $nodes;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public $selectedNode
    )
    {


        $this->nodes = Node::whereHasMorph(
            'html',
            [HtmlList::class]
        )->get();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nodes.sublist-button');
    }
}
