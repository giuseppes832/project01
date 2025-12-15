
@foreach($rows as $row)
    @if(Auth::user()->canRead($row->form->node))
    <div class="border-bottom mb-2">
        <div class="d-flex align-items-center">
            <div class="w-75">
                @if($selectedNode->html->node1 && Auth::user()->canRead($selectedNode->html->node1))
                    <div class="fw-normal">{{ $row->getValue($selectedNode->html->node1)}}</div>
                @endif
                @if($selectedNode->html->node2 && Auth::user()->canRead($selectedNode->html->node2))
                    <div class="fw-light">{{ $row->getValue($selectedNode->html->node2)}}</div>
                @endif


            </div>
            <div class="w-25 d-flex justify-content-end">
                <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#globalModal" data-method="put" data-row-id="{{ $row->id }}">
                    <i class="bi bi-pencil-square"></i>
                </button>

            </div>



        </div>
        @foreach($selectedNode->children as $sublist)
            <a class="me-1" href="javascript:void(0)" onclick="createRefresh('{{ $sublist->id }}', '{{ $row->id }}', 'targetMenuContainer')">{{ $sublist->name }} <i class="bi bi-chevron-right"></i></a>
        @endforeach
    </div>
    @endif
@endforeach

