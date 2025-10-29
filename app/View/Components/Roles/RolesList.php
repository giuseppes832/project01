<?php

namespace App\View\Components\Roles;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\App as AppModel;

class RolesList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $roles
        )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.roles.roles-list');
    }
}
