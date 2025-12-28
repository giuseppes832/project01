<?php

namespace App\View\Components\Nodes;

use App\Models\Field as FieldModel;
use App\Models\FieldTypes\TimestampField;
use App\Models\Resource;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HtmlForm extends Component
{

    public $resources;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public \App\Models\Node $selectedNode
    )
    {

        $this->resources = Resource::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nodes.html-form');
    }
}
