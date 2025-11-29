
@php

$row = Request::route('row');

if($row ) {
	$action = "/rows/" . $row->id;
	$method = "put";
} else {
	$action = "/nodes/$selectedNode->id/rows";
	$method = "post";
}

$qs = "";
if (Request::filled("parent_row_id")) {
    $qs = "parent_row_id=" . Request::query("parent_row_id");
}
$action .= "?$qs";
@endphp


<h5>{{ $selectedNode->label }}</h5>
<form action="{{ $action }}" method="post" onsubmit="submitRow(this, 'globalModalBody')">
	@csrf
	@method($method)

	@foreach($selectedNode->children as $child)

	@php
	$component = $child->getSelectedNodeRenderComponent();
	@endphp

	@if($component && $child && Auth::user()->canRead($child))
	<x-dynamic-component :component="$component" :selectedNode="$child"/>
	@endif

	@endforeach

    <div class="text-end">

        <script>

        </script>

        <button type="button" class="btn btn-primary" onclick="window.loadNode({{ $selectedNode->id }}, '{{ $qs }}', 'globalModalBody')">
            <i class="bi bi-plus-square"></i> New
        </button>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Save
        </button>

        @if($row)
        <a href="javascript:void(0)" class="btn btn-danger" data-bs-dismiss="modal" onclick="window.deleteRow({{ $row->id }})">
            <i class="bi bi-trash"></i> Delete
        </a>
        @endif
    </div>
</form>
