<form action="/nodes7/{{ $selectedNode->id }}" method="post">
    @csrf
    @method('put')

    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" id="multiple" name="multiple" @if (true == old('multiple', $selectedNode->html->multiple)) checked @endif>
        <label class="form-check-label" for="multiple">
            Multiple
        </label>
    </div>

    <div class="mb-3 form-floating">
        <select class="form-select" name="binding" aria-label="Campo">
            <option value="" selected>Select ...</option>
            @foreach($fields as $field)
                <option value="{{ $field->id }}" @if ($field->id == old('binding', $selectedNode->html->binding_id)) selected @endif>{{ $field->resource->name }}\{{ $field->name }}</option>
            @endforeach
        </select>
        <label>Binding Field</label>
    </div>

    <button type="submit" class="btn btn-primary btn-sm mb-3">
        <i class="bi bi-save"></i> Save
    </button>

</form>
