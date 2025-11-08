<form action="/resources/{{ $selectedResource->id }}/fields" method="post">
	@csrf
	<div class="row g-1">

        <div class="col-10">
            <div class="form-floating">
                <input type="text" class="form-control form-control-sm" name="name"/>
                <label>Nome nuovo campo</label>
                @error("name")
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="col-2">
		    <button type="submit" class="btn btn-primary btn-sm">Salva</button>
        </div>

	</div>


</form>
