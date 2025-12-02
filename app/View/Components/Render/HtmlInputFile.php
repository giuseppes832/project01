<?php

namespace App\View\Components\Render;

use App\Models\Node as NodeModel;
use app\Utilities\Menu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class HtmlInputFile extends Component
{
    public $value;

    public $row;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public NodeModel $selectedNode
    )
    {

        $row = Menu::getRow();

        if ($row) {
            $this->row = $row;
            $timestamp = $row->getValue($this->selectedNode);
            $this->value = Storage::allFiles($timestamp);
        }


    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.render.html-input-file');
    }
}
