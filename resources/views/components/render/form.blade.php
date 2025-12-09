
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
$parentRowId = "";
if ("undefined" !== Request::query("parent_row_id")) {
    $parentRowId = Request::query("parent_row_id");
    $qs = "parent_row_id=" . Request::query("parent_row_id");
    $action .= "?$qs";
}

@endphp


<h5>{{ $selectedNode->label }}</h5>
<form id="{{ $selectedNode->id }}" action="{{ $action }}" method="post" onsubmit="submitRow(this)">
	@csrf
	@method($method)





    @php
        $redirect_row_id = \Illuminate\Support\Facades\Session::getOldInput("redirect_row_id");
        $redirect_node_id = \Illuminate\Support\Facades\Session::getOldInput("redirect_node_id");
        $redirect_inputs = \Illuminate\Support\Facades\Session::getOldInput("redirect_inputs");
    @endphp

    @isset($redirect_row_id)
        <input type="hidden" name="redirect_row_id" value="{{ $redirect_row_id }}">
    @endisset

    @isset($redirect_node_id)
        <input type="hidden" name="redirect_node_id" value="{{ $redirect_node_id }}">
    @endisset

    @isset($redirect_inputs)

        @foreach($redirect_inputs as $inputName => $inputValue)
            @if(!is_array($inputValue))
                <input type="hidden" name="old_{{ $inputName }}" value="{{ $inputValue }}">
            @else
                @foreach($inputValue as $index => $singleInputValue)
                    <input type="hidden" name="old_{{ $inputName }}[{{ $index }}]" value="{{ $singleInputValue }}">
                @endforeach

            @endif
        @endforeach
    @endisset








	@foreach($selectedNode->children as $child)

	@php
	$component = $child->getSelectedNodeRenderComponent();
	@endphp

	@if($component && $child && Auth::user()->canRead($child))
	<x-dynamic-component :component="$component" :selectedNode="$child"/>
	@endif

	@endforeach

    @empty($redirect_node_id)
    <div class="text-end">

        <button type="button" class="btn btn-primary" onclick="ajaxGET('/render/{{ $selectedNode->id }}?parent_row_id={{ $parentRowId }}', 'globalModalBody')">
            <i class="bi bi-plus-square"></i> {{ __("main.render.New") }}
        </button>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> {{ __("main.render.Save") }}
        </button>

        @if($row)
        <a href="javascript:void(0)" class="btn btn-danger" data-bs-dismiss="modal" onclick="window.deleteRow({{ $row->id }})">
            <i class="bi bi-trash"></i> {{ __("main.render.Delete") }}
        </a>
        @endif
    </div>
    @endempty


    @isset($redirect_node_id)
    <div class="text-end">

        <button type="submit" class="btn btn-warning" onclick="back()">
            <i class="bi bi-chevron-left"></i> {{ __("main.render.Back") }}
        </button>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> {{ __("main.render.Save") }}
        </button>

    </div>
    @endisset

</form>
