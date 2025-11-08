<form action="/nodes12/{{ $selectedNode->id }}" method="post">
    @csrf
    @method('put')

    <div class="mb-3 form-floating">
        <select class="form-select" name="binding" aria-label="Campo">
            <option value="" selected>Seleziona uno ...</option>
            @foreach($fields as $field)
                <option value="{{ $field->id }}" @if ($field->id == old('binding', $selectedNode->html->binding_id)) selected @endif>{{ $field->resource->name }}\{{ $field->name }}</option>
            @endforeach
        </select>
        <label>Campo</label>
    </div>

    <button type="submit" class="btn btn-primary btn-sm mb-3">Salva</button>

</form>
