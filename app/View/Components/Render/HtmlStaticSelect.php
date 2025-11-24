<?php

namespace App\View\Components\Render;

use App\Models\Node;
use app\Utilities\Menu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HtmlStaticSelect extends Component
{
    public $options;

    public $value;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Node $selectedNode
    )
    {


        $csvOptions = [];
        if ($this->selectedNode->html->binding && $this->selectedNode->html->binding->withType) {
            $csvOptions = explode("\n", $this->selectedNode->html->binding->withType->options);
        }

        $this->options = [];

        foreach ($csvOptions as $csvOption) {

            $key = explode(",", $csvOption)[0];
            $label = explode(",", $csvOption)[1];

            $this->options[] = (object)[
                "key" => $key,
                "label" => $label
            ];

        }










        $formRow = Menu::getRow();

        if (!$this->selectedNode->html->multiple) {
            if ($formRow) {
                $genericValue = $this->selectedNode->html->binding->values($formRow)->first();
                if ($genericValue) {
                    $withValue = $genericValue->withValue;

                    if ($withValue) {
                        $this->value = $withValue->value;
                    }
                }
            }
        } else {
            if ($formRow) {
                $genericValues = $this->selectedNode->html->binding->values($formRow)->get();

                $this->value = [];

                foreach ($genericValues as $genericValue) {

                    $withValue = $genericValue->withValue;

                    if ($withValue) {
                        $this->value[] =  $withValue->value;
                    }
                }

            }

        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.render.html-static-select');
    }
}
