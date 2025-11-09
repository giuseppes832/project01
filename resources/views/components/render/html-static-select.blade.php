<div class="mb-3 form-floating">
    <select class="form-select" @if($selectedNode->html->multiple) style="height: 100px" @endif name="nodes[{{ $selectedNode->id }}]@if($selectedNode->html->multiple)[]@endif" aria-label="{{ $selectedNode->name }}" @if($selectedNode->html->multiple) multiple @endif>
        <option value="">Seleziona uno ...</option>
        @foreach($options as $optiom)
            @if(!$selectedNode->html->multiple)
                <option value="{{ $optiom->key }}" @if($optiom->key === old('', $value)) selected @endif>{{ $optiom->label }}</option>
            @else
                <option value="{{ $optiom->key }}" @if($value && in_array($optiom->key, $value)) selected @endif>{{ $optiom->label }}</option>
            @endif
        @endforeach
    </select>
    <label>{{ $selectedNode->label }}</label>
</div>
