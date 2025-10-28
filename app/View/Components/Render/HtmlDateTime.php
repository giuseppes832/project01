<?php

namespace App\View\Components\Render;

use App\Models\Node as NodeModel;
use app\Utilities\Menu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HtmlDateTime extends Component
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
            $genericValue = $this->selectedNode->html->binding->values($row)->first();
            $value = $genericValue->withValue;

            if ($value) {
                $this->value =  $value->value;
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.render.html-date-time');
    }
}
