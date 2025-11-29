<form action="/resources/{{ $selectedResource->id }}/fields" method="post">
	@csrf
	<div class="row g-1">

        <div class="col-8">
            <div class="form-floating">
                <input type="text" class="form-control form-control-sm" name="name"/>
                <label>Field name</label>
                @error("name")
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="col-4">
		    <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Create
            </button>
        </div>

	</div>


</form>
