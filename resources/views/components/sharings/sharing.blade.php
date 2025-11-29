<div class="mb-3 pb-3 border-bottom">

	<h5>{{ $selectedSharing->name }}</h5>

   	<form action="/sharings/{{ $selectedSharing->id }}" method="post">
   		@csrf
   		@method('put')

		<div class="mb-3 form-floating">
			<input type="text" class="form-control form-control-sm" name="name" value="{{ old('name', $selectedSharing->name) }}"/>
			<label>Sharing name</label>
            @error("name")
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
		</div>

		<div class="mb-3 form-floating">
            <select class="form-select" name="role_id" aria-label="Ruolo">
                <option value="" selected>Select ...</option>
                @foreach($roles as $value => $role)
                <option value="{{ $role->id }}" @if ($role->id == old('role_id', $selectedSharing->role_id)) selected @endif>{{ $role->name }}</option>
                @endforeach
            </select>
			<label>Role</label>
        </div>

		<div class="mb-3 form-floating">
            <select class="form-select" name="sharing_type" aria-label="Tipo di condivisione">
                <option value="" selected>Seleziona uno ...</option>
                @foreach($Utility::getValues() as $value => $sharing)
                <option value="{{ $value }}" @if ($value == old('n', $Utility::getSectedSharingType($selectedSharing))) selected @endif>{{ $sharing["label"] }}</option>
                @endforeach
            </select>
			<label>Sharing type</label>
        </div>



        <button type="submit" class="btn btn-primary btn-sm mb-3">
            <i class="bi bi-save"></i> Save
        </button>

	</form>

	@isset($sharingFormComponent)
	<x-dynamic-component :component="$sharingFormComponent" :selectedSharing="$selectedSharing" />
	@endisset

</div>
