<b>{{ $node->name }}</b>

@php

$sharedNode = $selectedRole->sharedNode($node);

@endphp

@if(!$sharedNode)
<form action="/roles/{{ $selectedRole->id }}/nodes/{{ $node->id }}/shared-nodes" method="post">
	@csrf
	<button type="submit" class="btn btn-success btn-sm">
        <i class="bi bi-plus-circle"></i> Create Permissions
    </button>
</form>

@else
<form action="/shared-nodes/{{ $sharedNode->id }}" method="post">
	@csrf
	@method('put')

    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="can_create" name="can_create" @if($sharedNode->can_create) checked @endif>
        <label class="form-check-label" for="can_create">
        	Can Create
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="can_read" name="can_read" @if($sharedNode->can_read) checked @endif>
        <label class="form-check-label" for="can_read">
        	Can Read
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="can_update" name="can_update" @if($sharedNode->can_update) checked @endif>
        <label class="form-check-label" for="can_update">
        	Can Update
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="can_delete" name="can_delete" @if($sharedNode->can_delete) checked @endif>
        <label class="form-check-label" for="can_delete">
        	Can Delete
        </label>
    </div>

    <button type="submit" class="btn btn-primary btn-sm">
        <i class="bi bi-save"></i> Save
    </button>
    <a class="btn btn-danger btn-sm" href="/shared-nodes/{{ $sharedNode->id }}/delete">
        <i class="bi bi-trash"></i> Delete
    </a>
</form>
@endif

<ul>

	@foreach($node->children as $child)

	<x-roles.role-node :selectedRole="$selectedRole" :node="$child"/>

	@endforeach



</ul>
