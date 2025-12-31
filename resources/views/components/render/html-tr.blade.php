<tr>

    @foreach($selectedNode->children as $tdNode)

        @php
            $tdNode->html->setParameters($selectedNode->html->parameters);
            $component = $tdNode->getSelectedNodeRenderComponent();
        @endphp

        @if($component && $tdNode && Auth::user()->canRead($tdNode))
            <x-dynamic-component :component="$component" :selectedNode="$tdNode"/>
        @endif

    @endforeach
    <td>
        <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#globalModal" data-method="put" data-node-id="{{ $selectedNode->html->parameters["form_id"] }}" data-row-id="{{ $selectedNode->html->parameters["row_id"] }}" @if(Request::filled($selectedNode->html->parameters["parent_row_id"])) data-parent-row-id="{{ $selectedNode->html->parameters["parent_row_id"] }}" @endif>
            <i class="bi bi-pencil-square"></i>
        </button>
    </td>

</tr>
