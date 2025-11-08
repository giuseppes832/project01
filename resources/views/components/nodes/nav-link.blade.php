<form action="/nodes3/{{ $selectedNode->id }}" method="post">
	@csrf
	@method('put')

	<div class="mb-3 form-floating">
		<input type="text" class="form-control form-control-sm" name="label" value="{{ old('label', $selectedNode->html->label) }}"/>
		<label>Etichetta</label>
	</div>

	<div class="mb-3 form-floating">
        <select class="form-select" name="ref" aria-label="Riferimento">
            <option value="" selected>Seleziona uno ...</option>
            @foreach($nodes as $node)
            <option value="{{ $node->id }}" @if ($node->id == old('ref', $selectedNode->html->ref_id)) selected @endif>{{ $node->name }}</option>
            @endforeach
            </select>
		<label>Riferimento</label>
    </div>

    <button type="submit" class="btn btn-primary btn-sm mb-3">Salva</button>

</form>
