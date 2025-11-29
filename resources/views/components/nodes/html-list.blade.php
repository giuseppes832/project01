<form action="/nodes4/{{ $selectedNode->id }}" method="post">
	@csrf
	@method('put')

	<div class="mb-3 form-floating">
        <select class="form-select" name="binding" aria-label="Campo">
            <option value="" selected>Select ...</option>
            @foreach($formNodes as $node)
            <option value="{{ $node->html->id }}" @if ($node->html->id == old('binding', $selectedNode->html->binding_id)) selected @endif>{{ $node->name }}</option>
            @endforeach
            </select>
		<label>Binding Form</label>
    </div>

    @if($selectedNode->html->binding_id)
	<div class="mb-3 form-floating">
        <select class="form-select" name="default_filter_binding" aria-label="Tipo di nodo">
            <option value="" selected>Select ...</option>
            @foreach($filters as $node)
            <option value="{{ $node->id }}" @if ($node->id == old('default_filter_binding', $selectedNode->html->default_filter_binding_id)) selected @endif>{{ $node->name }}</option>
            @endforeach
            </select>
		<label>Filter / Join</label>
    </div>


	<div class="mb-3 form-floating">

        <select class="form-select" name="node1" aria-label="Tipo di nodo">
            <option value="" selected>Select ...</option>
            @foreach($nodes as $node)
            <option value="{{ $node->id }}" @if ($node->id == old('node1', $selectedNode->html->node_id1)) selected @endif>{{ $node->name }}</option>
            @endforeach
            </select>
		<label>Row Title Node</label>
    </div>


	<div class="mb-3 form-floating">
        <select class="form-select" name="node2" aria-label="Tipo di nodo">
            <option value="" selected>Select ...</option>
            @foreach($nodes as $node)
            <option value="{{ $node->id }}" @if ($node->id == old('node2', $selectedNode->html->node_id2)) selected @endif>{{ $node->name }}</option>
            @endforeach
            </select>
		<label>Row Description Node</label>
    </div>
    @endif

    <button type="submit" class="btn btn-primary btn-sm mb-3">
        <i class="bi bi-save"></i> Save
    </button>

</form>
