<form action="/nodes8/{{ $selectedNode->id }}" method="post">
    @csrf
    @method('put')

    <div class="mb-3 form-floating">
        <select class="form-select" name="list_binding" aria-label="Campo">
            <option value="" selected>Seleziona uno ...</option>
            @foreach($nodes as $node)
                <option value="{{ $node->html->id }}" @if ($node->html->id == old('list_binding', $selectedNode->html->list_binding_id)) selected @endif>{{ $node->name }}</option>
            @endforeach
        </select>
        <label>Campo</label>
    </div>

    <button type="submit" class="btn btn-primary btn-sm mb-3">Salva</button>

</form>
