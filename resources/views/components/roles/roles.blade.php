<x-layout>

	<div class="d-flex flex-row h-100">

		<div class="border-end w-25 h-100 p-4">


			@isset($selectedRole)
			<x-roles.role :selectedRole="$selectedRole" />
			@endisset

            @isset($roles)
			<x-roles.roles-list :roles="$roles"/>
            @endisset

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
            <script>
                function confirmDelete() {
                    if(confirm("Confermi di voler cancellare il ruolo selezionato (l'operazione cancellerà i relativi permessi) ?")) {
                        window.location.href = "/roles/{{ $selectedRole->id }}/delete";
                    }
                }
            </script>
            <a class="btn btn-primary btn-danger btn-sm mt-3" href="javascript:void(0)" onclick="confirmDelete()" role="button">Elimina ruolo</a>
			@endisset

		</div>

		<div class="flex-grow-1">

			@if(isset($selectedRole) && isset($rootNodes))
			<div class="p-4">


            	<b>{{ $selectedRole->name }}</b>

            	<ul>

                	@foreach($rootNodes as $rootNode)

                	<x-roles.role-node :selectedRole="$selectedRole" :node="$rootNode"/>

                	@endforeach



                </ul>


			</div>
            @endif

		</div>

	</div>

</x-layout>
