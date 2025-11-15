<?php

namespace App\View\Components\Render;

use App\Utilities\CommonService;
use App\Utilities\Menu;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
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
            $genericValue = $this->selectedNode->html->binding->values($row)->first();
            if ($genericValue) {
                $value = $genericValue->withValue;

                if ($value) {
                    $this->value =  $value->value;
                }
            }
        }


        // Security Check
        $commonService = app()->make(CommonService::class);
        if (Auth::user()->isInvitedUser() && ($this->value && $this->value !== $commonService->getFilteringValue($this->selectedNode))) {
            // Unused
            abort(403);
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
