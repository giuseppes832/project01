@php
    $parentRowId = "";
    if (Request::filled("parent_row_id")) {
        $parentRowId = Request::query("parent_row_id");

        $fkValue = null;
        if ($selectedNode->html->parentTableSelect) {
            $filteringNode = $selectedNode->html->parentTableSelect;

            if ($filteringNode && $filteringNode->html && $filteringNode->html->binding) {
                // Parent row foreign key
                $fkValue = $filteringNode->html->binding->values0($parentRowId)->first();
            }
        }

        $parentParenRowId = "";
        if ($fkValue) {
            $parentParenRowId = $fkValue->withValue->value;
        }

    }

@endphp

@if("" !== $parentRowId)
<div class="container mb-2">
    <a class="btn btn-primary" href="javascript:void(0)"
       onclick="createRefresh({{ $selectedNode->html->parentTable->node->id  }}, '{{ $parentParenRowId }}', 'targetMenuContainer')"><i
            class="bi bi-chevron-left"></i> {{ $selectedNode->html->parentTable->node->label }}</a>
</div>
@endif

<div class="container">

    <h5>{{  $selectedNode->label }}</h5>
    @if($selectedNode->html->form)
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#globalModal" data-method="post" data-node-id="{{ $selectedNode->html->form->node->id }}" @if(Request::filled("parent_row_id")) data-parent-row-id="{{ Request::query('parent_row_id') }}" @endif>
            <i class="bi bi-plus-square"></i>
        </button>
    @endif


    <form action="/render/{{  $selectedNode->id }}/ajax" method="get" >
        <div class="mb-2">
            <input type="text" name="filter-field" class="form-control form-control" onkeyup="createRefreshHtmlListBody('{{ $selectedNode->id }}', '{{ $parentRowId }}', this.value, 'ajaxBody')" placeholder="{{ __("main.render.Find") }}"/>
        </div>
    </form>

    <div id="ajaxBody" class="d-flex flex-column">
        <div class="p-4 border rounded">
            <table class="table">

                <tr>
                    @foreach($selectedNode->html->tr->node->children as $td)
                    <th>{{ $td->name }}</th>
                    @endforeach
                    <th></th>
                </tr>

                @foreach($rows as $row)

                    @php
                        $trNode = $selectedNode->html->tr->node;
                        $trNode->html->addOptionalParameter("table_node", $selectedNode);
                        $trNode->html->addOptionalParameter("row_id", $row->id);
                        $trNode->html->addOptionalParameter("form_id", $selectedNode->html->form->node->id);
                        $trNode->html->addOptionalParameter("parent_row_id", $parentRowId);
                        $component = $trNode->getSelectedNodeRenderComponent();
                    @endphp

                    @if($component && $trNode && Auth::user()->canRead($trNode))
                        <x-dynamic-component :component="$component" :selectedNode="$trNode"/>
                    @endif

                @endforeach
            </table>
        </div>
    </div>

</div>
