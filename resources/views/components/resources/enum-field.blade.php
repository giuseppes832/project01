<form action="/fields2/{{ $selectedField->id }}" method="post">
    @csrf
    @method('put')

    <div class="mb-3 form-floating">
        <textarea style="height: 100px" name="options" class="form-control">{{ old('options', $selectedField->withType->options) }}</textarea>
        <label>Opzioni</label>
    </div>

    <button type="submit" class="btn btn-primary btn-sm mb-3">
        <i class="bi bi-save"></i> Save
    </button>

</form>
