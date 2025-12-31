<?php

namespace App\View\Components\Render;

use App\Models\Node as NodeModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HtmlTr extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public NodeModel $selectedNode
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.render.html-tr');
    }
}
