<div class="mb-3 pb-3 border-bottom">

	<h5>{{ $selectedRole->name }}</h5>

   	<form action="/roles/{{ $selectedRole->id }}" method="post">
   		@csrf
   		@method('put')

		<div class="mb-3 form-floating">
			<input type="text" class="form-control form-control-sm" name="name" value="{{ old('name', $selectedRole->name) }}"/>
			<label>Role name</label>
            @error("name")
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
		</div>

        <button type="submit" class="btn btn-primary btn-sm mb-3">
            <i class="bi bi-save"></i> Save
        </button>

	</form>

</div>
