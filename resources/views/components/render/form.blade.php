
@php

$row = Request::route('row');

if($row ) {
	$action = "/rows/" . $row->id;
	$method = "put";
} else {
	$action = "/nodes/$selectedNode->id/rows";
	$method = "post";
}

if (Request::filled("parent_row_id")) {
    $action .= "?parent_row_id=" . Request::query("parent_row_id");
}
@endphp


<h5>{{ $selectedNode->label }}</h5>
<form action="{{ $action }}" method="post" onsubmit="submitRow(this, 'globalModalBody')">
	@csrf
	@method($method)

	@foreach($selectedNode->children as $child)

	@php
	$component = $child->getSelectedNodeRenderComponent();
	@endphp

	@if(Auth::user()->canRead($child))
	<x-dynamic-component :component="$component" :selectedNode="$child"/>
	@endif

	@endforeach

    <div class="text-end">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Salva
        </button>

        @if($row)
        <a href="javascript:void(0)" class="btn btn-danger" data-bs-dismiss="modal" onclick="window.deleteRow({{ $row->id }})">
            <i class="bi bi-trash"></i> Elimina
        </a>
        @endif
    </div>
</form>
