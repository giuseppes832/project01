@php
    $parentRowId = "";
    if (Request::filled("parent_row_id")) {
        $parentRowId = Request::query("parent_row_id");
    }
@endphp

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
