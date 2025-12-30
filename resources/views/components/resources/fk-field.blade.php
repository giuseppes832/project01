<form action="/fields3/{{ $selectedField->id }}" method="post">
    @csrf
    @method('put')

    <div class="mb-3 form-floating">
        <select class="form-select" name="fk_resource_id" aria-label="Risorsa della foreign key">
            <option value ="" selected>{{ __("main.resources.Select") }} ...</option>
            @foreach($resources as $resource)
                <option value="{{ $resource->id }}" @if ($resource->id == old('fk_resource_id', $selectedField->withType->fk_resource_id)) selected @endif>{{ $resource->name }}</option>
            @endforeach
        </select>
        <label>{{ __("main.resources.Foreign key resource") }}</label>
    </div>

    <div class="mb-3 form-floating">
        <select class="form-select" name="fk_field_id" aria-label="Campo della foreign key">
            <option value ="" selected>{{ __("main.resources.Select") }} ...</option>
            @foreach($fields as $field)
                <option value="{{ $field->id }}" @if ($field->id == old('fk_field_id', $selectedField->withType->fk_field_id)) selected @endif>{{ $field->name }}</option>
            @endforeach
        </select>
        <label>{{ __("main.resources.Foreign key field") }}</label>
    </div>

    <button type="submit" class="btn btn-primary btn-sm mb-3">
        <i class="bi bi-save"></i> {{ __("main.resources.Save") }}
    </button>

</form>
