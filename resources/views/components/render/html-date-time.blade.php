<div class="mb-3">
    <label class="form-label">{{ $selectedNode->name }}</label>
    <input type="datetime-local" class="form-control" name="nodes[{{ $selectedNode->id }}]" value="{{ $value }}">
</div>
