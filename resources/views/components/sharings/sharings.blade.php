<x-layout>

	<div class="d-flex flex-row h-100">

		<div class="border-end w-25 h-100 p-4">

			@isset($selectedSharing)
			<x-sharings.sharing :selectedSharing="$selectedSharing" />
			@endisset

			<x-sharings.sharings-list :sharings="$sharings"/>

            <form action="/sharings" method="post">
            	@csrf
            	<div class="row g-1">
            		<div class="col-10">
            			<div class="form-floating">
            				<input type="text" class="form-control form-control-sm" name="name"/>
            				<label>Nome nuova condivisione</label>
            			</div>

            		</div>
            		<div class="col-2">
            			<button type="submit" class="btn btn-primary btn-sm">Salva</button>
            		</div>
            	</div>


            </form>

            @isset($selectedSharing)
            <a class="btn btn-primary btn-danger btn-sm mt-3" href="/sharings/{{ $selectedSharing->id }}/delete" role="button">Elimina condivisione</a>
			@endisset

		</div>

		<div class="flex-grow-1">

		</div>

	</div>

</x-layout>
