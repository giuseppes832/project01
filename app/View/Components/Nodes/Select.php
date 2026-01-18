<?php

namespace App\View\Components\Nodes;

use App\Models\Field as FieldModel;
use App\Models\FieldTypes\FKField;
use App\Models\FieldTypes\MvIntegerField;
use App\Models\Node as NodeModel;
use App\Models\Nodes\HtmlForm;
use App\Models\Nodes\HtmlSelect;
use App\Models\Nodes\HtmlSharingSelect;
use App\Models\SvIntegerField;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public $fields;

    public $forms;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public \App\Models\Node $selectedNode
    )
    {


        $this->fields = FieldModel::whereHasMorph(
            'withType',
            [FKField::class]
        )->get();

        $this->forms = HtmlForm::all();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nodes.select');
    }
}
