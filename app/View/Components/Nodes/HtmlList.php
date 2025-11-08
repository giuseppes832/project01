<?php

namespace App\View\Components\Nodes;

use App\Models\Node as NodeModel;
use App\Models\Nodes\HtmlForm;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class HtmlList extends Component
{
    public $formNodes;

    public $nodes;




    /**
     * Create a new component instance.
     */
    public function __construct(
        public $selectedNode
        )
    {



        $this->formNodes = NodeModel::whereHasMorph(
            'html',
            [HtmlForm::class]
            )->get();

        $this->nodes = [];

        if ($this->selectedNode->html->binding_id) {

            $this->nodes = NodeModel::all();
        }


    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nodes.html-list');
    }
}
