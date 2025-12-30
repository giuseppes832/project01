<?php

namespace App\View\Components\Resources;

use App\Models\Field as FieldModel;
use App\Models\Node as NodeModel;
use App\Models\Nodes\HtmlForm;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FkField extends Component
{

    public $resources;

    public $fields;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public \App\Models\Field $selectedField
    )
    {
        $this->resources = \App\Models\Resource::all();

        if ($this->selectedField->withType->fk_resource_id) {

            $this->fields = \App\Models\Field::where("resource_id", $this->selectedField->withType->fk_resource_id)->get();

        } else {

            $this->fields = \App\Models\Field::all();

        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.resources.fk-field');
    }
}
