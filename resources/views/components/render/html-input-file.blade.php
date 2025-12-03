<div class="mb-2">

    <div class="border rounded" style="padding: 12px">

        <label style="font-size: 14px; color: #212529a6">{{ $selectedNode->label }}</label>
        @isset($value)
            @foreach($value as $file => $filePath)
                <a href="/rows/{{ $row->id }}/nodes/{{ $selectedNode->id }}/file/{{ $file }}">{{ $filePath }}</a>
            @endforeach
        @endisset
        <input type="file" name="nodes[{{ $selectedNode->id }}]" class="form-control form-control-sm"/>
        @error("nodes.$selectedNode->id")
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror

    </div>

</div>
