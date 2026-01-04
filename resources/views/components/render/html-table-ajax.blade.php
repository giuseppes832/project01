@php
    $parentRowId = "";
    if (Request::filled("parent_row_id")) {
        $parentRowId = Request::query("parent_row_id");
    }
@endphp

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
