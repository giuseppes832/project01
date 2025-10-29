
@foreach($rows as $row)
    @if(Auth::user()->canRead($row->form->node))
        <div class="border-bottom d-flex align-items-center">
            <div class="w-50">
                @if(Auth::user()->canRead($selectedNode->html->node1))
                    <div class="fw-normal">{{ $row->getValue($selectedNode->html->node1, $row)}}</div>
                @endif
                @if(Auth::user()->canRead($selectedNode->html->node2, $row))
                    <div class="fw-light">{{ $row->getValue($selectedNode->html->node2, $row)}}</div>
                @endif


            </div>
            <div class="w-50 d-flex justify-content-end">
                <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#globalModal" data-method="put" data-row-id="{{ $row->id }}">
                    <i class="bi bi-pencil-square"></i>
                </button>
                @foreach($selectedNode->children as $sublist)
                    <a class="btn btn-primary me-1" href="javascript:void(0)" onclick="createRefresh({{ $sublist->id }}, 'parent_row_id={{ $row->id }}', 'targetMenuContainer')"><i class="bi bi-chevron-right"></i> {{ $sublist->name }}</a>
                @endforeach
            </div>



        </div>
    @endif
@endforeach

