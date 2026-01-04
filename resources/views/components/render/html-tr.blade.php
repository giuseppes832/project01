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

        <div class="btn-group">
            <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item"
                       href="javascript:void(0)"
                       role="button"
                       data-bs-toggle="modal"
                       data-bs-target="#globalModal"
                       data-method="put"
                       data-node-id="{{ $selectedNode->html->optionalParameters["form_id"] }}"
                       data-row-id="{{ $selectedNode->html->optionalParameters["row_id"] }}"
                       @if(Request::filled($selectedNode->html->optionalParameters["parent_row_id"]))
                           data-parent-row-id="{{ $selectedNode->html->optionalParameters["parent_row_id"] }}"
                        @endif
                    >

                        <i class="bi bi-pencil-square"></i> {{ __("main.render.Edit") }}
                    </a>
                </li>

                @if($selectedNode->html->optionalParameters["table_node"]->html->childrenTables->count() > 0)
                <li><hr class="dropdown-divider"></li>
                @endif

                @foreach($selectedNode->html->optionalParameters["table_node"]->html->childrenTables as $childTable)
                    <li>
                        <a class="dropdown-item"
                           href="javascript:void(0)"
                           onclick="createRefresh('{{ $childTable->node->id }}', '{{ $selectedNode->html->optionalParameters["row_id"] }}', 'targetMenuContainer')">
                            <i class="bi bi-chevron-right"></i> {{ $childTable->node->label }}
                        </a>
                    </li>

                @endforeach

            </ul>
        </div>



    </td>

</tr>
