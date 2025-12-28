<form action="/nodes1/{{ $selectedNode->id }}" method="post">
    @csrf
    @method('put')

    <div class="mb-3 form-floating">
        <select class="form-select" name="resource_id" aria-label="Risorsa">
            <option value="" selected>{{ __("main.nodes.Select") }} ...</option>
            @foreach($resources as $resource)
                <option value="{{ $resource->id }}" @if ($resource->id == old('resource_id', $selectedNode->html->resource_id)) selected @endif>{{ $resource->name }}</option>
            @endforeach
        </select>
        <label>{{ __("main.nodes.Resource") }}</label>
    </div>

    <button type="submit" class="btn btn-primary btn-sm mb-3">
        <i class="bi bi-save"></i> {{ __("main.nodes.Save") }}
    </button>

</form>
