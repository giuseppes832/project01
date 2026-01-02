<tr>

    @foreach($selectedNode->children as $tdNode)

        @php
            $tdNode->html->setOptionalParameters($selectedNode->html->optionalParameters);
            $component = $tdNode->getSelectedNodeRenderComponent();
        @endphp

        @if($component && $tdNode && Auth::user()->canRead($tdNode))
            <x-dynamic-component :component="$component" :selectedNode="$tdNode"/>
        @endif

    @endforeach
    <td>
        <button
            type="button"
            class="btn btn-primary me-1"
            data-bs-toggle="modal"
            data-bs-target="#globalModal"
            data-method="put"
            data-node-id="{{ $selectedNode->html->optionalParameters["form_id"] }}"
            data-row-id="{{ $selectedNode->html->optionalParameters["row_id"] }}"
            @if(Request::filled($selectedNode->html->optionalParameters["parent_row_id"]))
                data-parent-row-id="{{ $selectedNode->html->optionalParameters["parent_row_id"] }}"
            @endif>
            <i class="bi bi-pencil-square"></i>
        </button>
    </td>

</tr>
