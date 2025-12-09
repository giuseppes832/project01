@php

    $fkValue = null;
    if ($selectedNode->parent && $selectedNode->parent->html_type) {
        $parent = null;
        if (\App\Models\Nodes\HtmlList::class === $selectedNode->parent->html_type) {
            $parent = $selectedNode->parent;
        } elseif (\App\Models\Nodes\SublistButton::class === $selectedNode->parent->html_type) {
            if ($selectedNode->parent && $selectedNode->parent->html) {
                $parent = $selectedNode->parent->html->listBinding->node;
            }
        }

        if ($parent) {
            $filteringNode = $parent->html->defaultFilterBinding;

            if ($filteringNode && $filteringNode->html && $filteringNode->html->binding) {
                // Parent row foreign key
                $fkValue = $filteringNode->html->binding->values0(Request::query("parent_row_id"))->first();
            }
        }

    }





@endphp

@isset($fkValue)
<div class="container mb-2">
    <a class="btn btn-primary" href="javascript:void(0)"
       onclick="createRefresh({{ $selectedNode->parent->id  }}, '{{ $fkValue->withValue->value }}', 'targetMenuContainer')"><i
                class="bi bi-chevron-left"></i> {{ $selectedNode->parent->name }}</a>
</div>
@endisset

@php
    $old = $selectedNode;
    if ($selectedNode->html->listBinding) {
        $selectedNode = $selectedNode->html->listBinding->node;
    }

@endphp


@if($selectedNode && Auth::user()->canRead($selectedNode))

<div class="container">

    <h5>{{  $selectedNode->label }}</h5>
    @if($selectedNode->html->binding)
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#globalModal"
            data-method="post" data-node-id="{{ $selectedNode->html->binding->node->id }}"
            @if(Request::filled("parent_row_id")) data-parent-row-id="{{ Request::query('parent_row_id') }}" @endif>
        <i class="bi bi-plus-square"></i>
    </button>
    @endif

    @php
        $qs = "";
        if (Request::filled("parent_row_id")) {
            $qs .= "parent_row_id=" . Request::query("parent_row_id") . "&";
        }

    @endphp

    <form action="/render/{{  $selectedNode->id }}/ajax" method="get">
        <div class="mb-2">
            <input type="text" name="filter-field" class="form-control form-control"
                   onkeyup="createRefreshHtmlListBody({{ $selectedNode->id }}, '{{ $qs }}filter=' + this.value, 'ajaxBody')"
                   placeholder="Cerca"/>
        </div>
    </form>


    <div id="ajaxBody" class="d-flex flex-column">
        @foreach($rows as $row)
            @if(Auth::user()->canRead($row->form->node))
            <div class="border-bottom mb-2">
                <div class="d-flex align-items-center">
                    <div class="w-75">
                        @if($selectedNode->html->node1 && Auth::user()->canRead($selectedNode->html->node1))
                            <div class="fw-normal">{{ $row->getValue($selectedNode->html->node1)}}</div>
                        @endif
                        @if($selectedNode->html->node2 && Auth::user()->canRead($selectedNode->html->node2, $row))
                            <div class="fw-light">{{ $row->getValue($selectedNode->html->node2)}}</div>
                        @endif


                    </div>
                    <div class="w-25 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal"
                                data-bs-target="#globalModal" data-method="put" data-row-id="{{ $row->id }}?{{ $qs }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>

                    </div>


                </div>
                @foreach($old->children as $sublist)
                    <a class="me-1" href="javascript:void(0)"
                       onclick="createRefresh({{ $sublist->id }}, '{{ $row->id }}', 'targetMenuContainer')">
                        {{ $sublist->name }} <i class="bi bi-chevron-right"></i></a>
                @endforeach
            </div>
            @endif
        @endforeach
    </div>

</div>

@endif
