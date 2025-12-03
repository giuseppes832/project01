

<div class="mb-3 form-floating">
    <select class="form-select" name="nodes[{{ $selectedNode->id }}]" aria-label="{{ $selectedNode->name }}">
        <option value="" selected>{{ __("main.render.Select") }} ...</option>
        @foreach($sharings as $sharing)
        <option value="{{ $sharing->id }}" @if ($sharing->id == old("nodes.$selectedNode->id", $value)) selected @endif>{{ $sharing->name }}</option>
        @endforeach
        </select>
	<label>{{ $selectedNode->label }}</label>
    @error("nodes.$selectedNode->id")
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="mb-2" style="padding-left: 12px; font-size: 14px; color: #212529a6">
    {{ __("main.render.Do you want to create a new sharing ?") }} <button type="submit" class="btn btn-primary btn-sm" onclick="yes({{ $selectedNode->id }})">{{ __("main.render.Yes") }}</button>
</div>

