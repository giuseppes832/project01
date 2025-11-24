<?php

namespace App\View\Components\Render;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Utilities\FieldTypes;
use App\Models\Node as NodeModel;
use App\Utilities\Menu;
use App\Utilities\Permission;


class InputText extends Component
{

    public $value;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public NodeModel $selectedNode
        )
    {

        $row = Menu::getRow();

        if ($row) {
            $this->value = $row->getValue($this->selectedNode);
        }


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.render.input-text');
    }
}
