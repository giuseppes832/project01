<div class="mb-3 pb-3 border-bottom">

	<h5>{{ $selectedResource->name }}</h5>

   	<form action="/resources/{{ $selectedResource->id }}" method="post">
   		@csrf
   		@method('put')

		<div class="mb-3 form-floating">
			<input type="text" class="form-control form-control-sm" name="name" value="{{ old('name', $selectedResource->name) }}"/>
			<label>Nome risorsa</label>
            @error("name")
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
		</div>

        <button type="submit" class="btn btn-primary btn-sm mb-3">Salva</button>

	</form>

</div>
