<div class="mb-3 form-check">
    <input type="hidden" name="nodes[{{ $selectedNode->id }}]" value="{{ $value }}">
    <input class="form-check-input" type="checkbox" name="nodes[{{ $selectedNode->id }}]"  @if (true == old('', $value)) checked @endif>
    <label class="form-check-label">
        {{ $selectedNode->label }}
    </label>
</div>
