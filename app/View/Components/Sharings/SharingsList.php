<?php

namespace App\View\Components\Sharings;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\App as AppModel;

class SharingsList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $sharings
        )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sharings.sharings-list');
    }
}
