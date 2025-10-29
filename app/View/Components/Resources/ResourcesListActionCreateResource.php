<?php

namespace App\View\Components\Resources;


use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\App as AppModel;

class ResourcesListActionCreateResource extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        )
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.resources.resources-list-action-create-resource');
    }
}
