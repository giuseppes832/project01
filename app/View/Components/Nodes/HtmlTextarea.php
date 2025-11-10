<?php

namespace App\View\Components\Nodes;

use App\Models\Field as FieldModel;
use App\Models\FieldTypes\TextField;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HtmlTextarea extends Component
{

    public $fields;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public $selectedNode
    )
    {

        $this->fields = FieldModel::whereHasMorph(
            'withType',
            [TextField::class]
        )->get();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nodes.html-textarea');
    }
}
