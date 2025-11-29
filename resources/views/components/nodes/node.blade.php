<div class="mb-3 pb-3 border-bottom">

	<h5>{{ $selectedNode->name }}</h5>

   	<form action="/nodes/{{ $selectedNode->id }}" method="post">
   		@csrf
   		@method('put')

		<div class="mb-3 form-floating">
			<input type="text" class="form-control form-control-sm" name="name" value="{{ old('name', $selectedNode->name) }}"/>
			<label>Resource name</label>
            @error("name")
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
		</div>

        <div class="mb-3 form-floating">
            <input type="text" class="form-control form-control-sm" name="label" value="{{ old('label', $selectedNode->label) }}"/>
            <label>Label</label>
            @error("label")
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>

		<div class="mb-3 form-floating">
            <select class="form-select" name="html_type" aria-label="Tipo di nodo">
                <option value="" selected>Select ...</option>
                @foreach($Utility::getValues() as $value => $field)
                <option value="{{ $value }}" @if ($value == old('html_type', $Utility::getSectedNodeType($selectedNode))) selected @endif>{{ $field["label"] }}</option>
                @endforeach
                </select>
			<label>Type</label>
        </div>

        <button type="submit" class="btn btn-primary btn-sm mb-3">
            <i class="bi bi-save"></i> Save
        </button>

	</form>

	@isset($nodeFormComponent)
	<x-dynamic-component :component="$nodeFormComponent" :selectedNode="$selectedNode" />
	@endisset

</div>
