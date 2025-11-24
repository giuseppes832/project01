<?php

namespace App\View\Components\Render;

use App\Utilities\CommonService;
use App\Utilities\Menu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;
use App\Models\Sharing;
use App\Models\Node as NodeModel;

class SharingSelect extends Component
{

    public $sharings;
    public $value;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public NodeModel $selectedNode
        )
    {

        if (Auth::user()->isInvitedUser()) {

            $commonService = app()->make(CommonService::class);
            $sharing = $commonService->getSharing();

            $this->sharings = collect([$sharing]);

        } else {

            $this->sharings = Sharing::all();

        }





        $row = Menu::getRow();

        if ($row) {
            $this->value = $row->getValue($this->selectedNode);
        }


        // Authorization Check
        if ($row && Auth::user()->isInvitedUser()) {

            $commonService = app()->make(CommonService::class);
            $filteringValue =  $commonService->getFilteringValue($this->selectedNode);
            if ($this->value !== $filteringValue) {
                abort(403);
            }

        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.render.sharing-select');
    }
}
