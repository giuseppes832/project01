<form action="/nodes15/{{ $selectedNode->id }}" method="post">
    @csrf
    @method('put')

    <div class="mb-3 form-floating">
        <select class="form-select" name="node_rendering_id" aria-label="Rendering node">
            <option value="" selected>{{ __("main.nodes.Select") }} ...</option>
            @foreach($nodes as $node)
                <option value="{{ $node->id }}" @if ($node->id == old('node_rendering_id', $selectedNode->html->node_rendering_id)) selected @endif>{{ $node->name }}</option>
            @endforeach
        </select>
        <label>{{ __("main.nodes.Rendering node") }}</label>
    </div>

    <button type="submit" class="btn btn-primary btn-sm mb-3">
        <i class="bi bi-save"></i> {{ __("main.nodes.Save") }}
    </button>

</form>
