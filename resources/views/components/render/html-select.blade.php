
<div class="mb-3 form-floating">
    <select class="form-select" @if($selectedNode->html->multiple) style="height: 100px" @endif name="nodes[{{ $selectedNode->id }}]@if($selectedNode->html->multiple)[]@endif" aria-label="{{ $selectedNode->name }}" @if($selectedNode->html->multiple) multiple @endif>
        <option value="">Seleziona uno ...</option>
        @foreach($options as $optiom)
            @if(!$selectedNode->html->multiple)
            <option value="{{ $optiom->row_id }}" @if($optiom->row_id === old("nodes.$selectedNode->id", $value)) selected @endif>{{ $optiom->withValue->value }}</option>
            @else
            <option value="{{ $optiom->row_id }}" @if($value && in_array($optiom->row_id, $value)) selected @endif>{{ $optiom->withValue->value }}</option>
            @endif
        @endforeach
    </select>
    <label>{{ $selectedNode->label }}</label>
    @error("nodes.$selectedNode->id")
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>
