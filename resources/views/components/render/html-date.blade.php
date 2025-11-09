<div class="mb-3">
    <label class="form-label">{{ $selectedNode->label }}</label>
    <input type="date" class="form-control" name="nodes[{{ $selectedNode->id }}]" value="{{ $value }}">
</div>
