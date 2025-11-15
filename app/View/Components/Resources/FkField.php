<?php

namespace App\View\Components\Resources;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FkField extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public \App\Models\Field $selectedField
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.resources.fk-field');
    }
}
