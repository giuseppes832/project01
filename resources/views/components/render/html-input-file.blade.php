<div class="mb-2">
    <label>{{ $selectedNode->label }}</label>
    @isset($value)
    @foreach($value as $file => $filePath)
    <a href="/rows/{{ $row->id }}/nodes/{{ $selectedNode->id }}/file/{{ $file }}">{{ $filePath }}</a>
    @endforeach
    @endisset
    <input type="file" name="nodes[{{ $selectedNode->id }}]" class="form-control form-control-lg"/>
    @error("nodes.$selectedNode->id")
    <div class="text-danger">
        {{ $message }}
    </div>
    @enderror
</div>
