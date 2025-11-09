

<div class="mb-2 form-floating">
	<input type="text" name="nodes[{{ $selectedNode->id }}]" value="{{ old("nodes.$selectedNode->id", $value) }}" class="form-control form-control-sm"/>
	<label>{{ $selectedNode->label }}</label>
    @error("nodes.$selectedNode->id")
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>


