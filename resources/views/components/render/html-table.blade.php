<div class="container">

    <h5>{{  $selectedNode->label }}</h5>
    @if($selectedNode->html->form)
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#globalModal" data-method="post" data-node-id="{{ $selectedNode->html->form->node->id }}" @if(Request::filled("parent_row_id")) data-parent-row-id="{{ Request::query('parent_row_id') }}" @endif>
            <i class="bi bi-plus-square"></i>
        </button>
    @endif

    @php
        $parentRowId = "";
        if (Request::filled("parent_row_id")) {
            $parentRowId = Request::query("parent_row_id");
        }
    @endphp

    <form action="/render/{{  $selectedNode->id }}/ajax" method="get" >
        <div class="mb-2">
            <input type="text" name="filter-field" class="form-control form-control" onkeyup="createRefreshHtmlListBody('{{ $selectedNode->id }}', '{{ $parentRowId }}', this.value, 'ajaxBody')" placeholder="{{ __("main.render.Find") }}"/>
        </div>
    </form>



    <div id="ajaxBody" class="d-flex flex-column">
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
                    $trNode->html->setParameters([
                        "row_id" => $row->id,
                        "form_id" => $selectedNode->html->form->node->id,
                        "parent_row_id" => $parentRowId
                    ]);
                    $component = $trNode->getSelectedNodeRenderComponent();
                @endphp

                @if($component && $trNode && Auth::user()->canRead($trNode))
                    <x-dynamic-component :component="$component" :selectedNode="$trNode"/>
                @endif

            @endforeach
        </table>
    </div>

</div>
