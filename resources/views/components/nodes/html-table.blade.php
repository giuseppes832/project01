<form action="/nodes16/{{ $selectedNode->id }}" method="post">
    @csrf
    @method('put')

    <div class="mb-3 form-floating">
        <select class="form-select" name="html_form_id" aria-label="Html form">
            <option value="" selected>{{ __("main.nodes.Select") }} ...</option>
            @foreach($formNodes as $node)
                <option value="{{ $node->html->id }}" @if ($node->html->id == old('html_form_id', $selectedNode->html->html_form_id)) selected @endif>{{ $node->name }}</option>
            @endforeach
        </select>
        <label>{{ __("main.nodes.Html form") }}</label>
    </div>

    <div class="mb-3 form-floating">
        <select class="form-select" name="html_tr_id" aria-label="Html row">
            <option value="" selected>{{ __("main.nodes.Select") }} ...</option>
            @foreach($rowNodes as $node)
                <option value="{{ $node->html->id }}" @if ($node->html->id == old('html_tr_id', $selectedNode->html->html_tr_id)) selected @endif>{{ $node->name }}</option>
            @endforeach
        </select>
        <label>{{ __("main.nodes.Html row") }}</label>
    </div>

    <button type="submit" class="btn btn-primary btn-sm mb-3">
        <i class="bi bi-save"></i> {{ __("main.nodes.Save") }}
    </button>

</form>
