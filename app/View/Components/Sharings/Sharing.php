<?php

namespace App\View\Components\Sharings;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Sharing as SharingModel;
use App\Models\Role;
use App\Utilities\SharingTypes;

class Sharing extends Component
{

    public $Utility;

    public $sharingFormComponent;

    public $roles;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public SharingModel $selectedSharing
        )
    {

        $this->Utility = SharingTypes::class;


        $type = SharingTypes::getSectedSharingType($this->selectedSharing);

        if ($type) {
            $this->sharingFormComponent = SharingTypes::$values[$type]["component"];
        }

        $this->roles = Role::all();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sharings.sharing');
    }
}
