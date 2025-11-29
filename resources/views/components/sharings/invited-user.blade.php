<form action="/sharings2/{{ $selectedSharing->id }}" method="post">
	@csrf
	@method('put')

		<div class="mb-3 form-floating">
			<input type="text" class="form-control form-control-sm" name="email" value="{{ old('email', $selectedSharing->sharingType->email) }}"/>
			<label>Email</label>
		</div>

    <button type="submit" class="btn btn-primary btn-sm mb-3">
        <i class="bi bi-save"></i> Save
    </button>

</form>
