

<div class="container">

    <h5>{{  $selectedNode->label }}</h5>
    @if($selectedNode->html->binding)
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#globalModal" data-method="post" data-node-id="{{ $selectedNode->html->binding->node->id }}" @if(Request::filled("parent_row_id")) data-parent-row-id="{{ Request::query('parent_row_id') }}" @endif>
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
        @foreach($rows as $row)
        <div class="border-bottom mb-2">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    @if($selectedNode->html->node1 && Auth::user()->canRead($selectedNode->html->node1))
                        <div class="fw-normal">{{ $row->getValue($selectedNode->html->node1)}}</div>
                    @endif
                    @if($selectedNode->html->node2 && Auth::user()->canRead($selectedNode->html->node2))
                        <div class="fw-light">{{ $row->getValue($selectedNode->html->node2)}}</div>
                    @endif


                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#globalModal" data-method="put" data-node-id="{{ $selectedNode->html->binding->node->id }}" data-row-id="{{ $row->id }}" @if(Request::filled("parent_row_id")) data-parent-row-id="{{ Request::query('parent_row_id') }}" @endif>
                        <i class="bi bi-pencil-square"></i>
                    </button>

                </div>
            </div>
            @foreach($selectedNode->children as $sublist)
                <a class="me-1" href="javascript:void(0)" onclick="createRefresh('{{ $sublist->id }}', '{{ $row->id }}', 'targetMenuContainer')">{{ $sublist->label }} <i class="bi bi-chevron-right"></i></a>
            @endforeach
        </div>
        @endforeach
    </div>

</div>


