<form action="/fields3/{{ $selectedField->id }}" method="post">
    @csrf
    @method('put')

    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" name="for_sharing"  @if (true == old('for_sharing', $selectedField->withType->for_sharing)) checked @endif>
        <label class="form-check-label">
            Used for Sharing Select
        </label>
    </div>

    <button type="submit" class="btn btn-primary btn-sm mb-3">
        <i class="bi bi-save"></i> Save
    </button>

</form>
