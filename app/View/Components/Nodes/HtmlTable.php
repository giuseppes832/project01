<?php

namespace App\View\Components\Nodes;

use App\Models\Node as NodeModel;
use App\Models\Nodes\HtmlForm;
use App\Models\Nodes\HtmlSelect;
use App\Models\Nodes\HtmlSharingSelect;
use App\Models\Nodes\HtmlTr;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class HtmlTable extends Component
{
    public $formNodes;

    public $rowNodes;

    public $tables;

    public $selects;




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

        $this->tables = \App\Models\Nodes\HtmlTable::all();

        $this->selects = HtmlSelect::all();

        if ($this->selectedNode->html->html_table_id &&
            $this->selectedNode->html->parentTable &&
            $this->selectedNode->html->parentTable->row
        ) {

            $this->selects = NodeModel::whereHasMorph(
                'html',
                [\App\Models\Nodes\HtmlTd::class],
                function($query) {
                    $query->whereHas('renderingNode', function ($query) {
                        $query->whereHasMorph('html', [HtmlSelect::class]);
                    });
                })->where("parent_id", $this->selectedNode->html->parentTable->row->node->id)->get();
        }


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nodes.html-table');
    }
}
