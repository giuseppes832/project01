<?php

namespace App\View\Components\Nodes;

use App\Models\Node as NodeModel;
use App\Models\Nodes\HtmlForm;
use App\Models\Nodes\HtmlSelect;
use App\Models\Nodes\HtmlSharingSelect;
use App\Models\Nodes\HtmlTr;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HtmlTable extends Component
{
    public $formNodes;

    public $rowNodes;




    /**
     * Create a new component instance.
     */
    public function __construct(
        public \App\Models\Node $selectedNode
    )
    {

        $this->formNodes = NodeModel::whereHasMorph(
            'html',
            [HtmlForm::class]
        )->get();

        $this->rowNodes = NodeModel::whereHasMorph(
            'html',
            [HtmlTr::class]
        )->get();


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nodes.html-table');
    }
}
