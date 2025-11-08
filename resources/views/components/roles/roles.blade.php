<x-layout>

	<div class="d-flex flex-row h-100">

		<div class="border-end w-25 h-100 p-4">


			@isset($selectedRole)
			<x-roles.role :selectedRole="$selectedRole" />
			@endisset

			<x-roles.roles-list :roles="$roles"/>

			@empty($selectedRole)
      		<form action="/roles" method="post">
           		@csrf
           		<div class="row g-1">
           			<div class="col-10">
           				<div class="form-floating">
           					<input type="text" class="form-control form-control-sm" name="name"/>
           					<label>Nome nuovo ruolo</label>
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
        	@endempty


            @isset($selectedRole)
            <a class="btn btn-primary btn-danger btn-sm mt-3" href="/roles/{{ $selectedRole->id }}/delete" role="button">Elimina ruolo</a>
			@endisset

		</div>

		<div class="flex-grow-1">

			@isset($selectedRole)
			<div class="p-4">


            	<b>{{ $selectedRole->name }}</b>

            	<ul>

                	@foreach($rootNodes as $rootNode)

                	<x-roles.role-node :selectedRole="$selectedRole" :node="$rootNode"/>

                	@endforeach



                </ul>


			</div>
			@endisset

		</div>

	</div>

</x-layout>
