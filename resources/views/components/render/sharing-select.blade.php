
<div class="mb-3 form-floating">
    <select class="form-select" name="nodes[{{ $selectedNode->id }}]" aria-label="{{ $selectedNode->name }}">
        <option value="" selected>Seleziona uno ...</option>
        @foreach($sharings as $sharing)
        <option value="{{ $sharing->id }}" @if ($sharing->id == old('ddd', $value)) selected @endif>{{ $sharing->name }}</option>
        @endforeach
        </select>
	<label>{{ $selectedNode->label }}</label>
</div>
