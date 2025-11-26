<x-layout>


	<div class="d-flex flex-row h-100">

		<div class="border-end w-25 h-100 p-4">

			@isset($selectedNode)
			<x-nodes.node :selectedNode="$selectedNode" />
			@endisset


            @isset($nodes)
			<ul>

                <li><a class="btn btn-sm btn" href="/apps/app">App</a></li>

            	<li><a class="btn btn-sm btn" href="/nodes">Nodi</a></li>

            	<ul>

                	@foreach($nodes as $node)

                	<li>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <a class="btn btn-sm btn" href="/nodes/{{ $node->id }}">{{ $node->name }}</a>
                            <form class="d-flex" action="/nodes-order/{{ $node->id }}" method="post">
                                @csrf
                                @method("put")
                                <input type="text" class="form-control form-control-sm me-1" style="width: 40px;" name="order[{{ $node->id }}]" value="{{ old("order.$node->id", $node->order) }}"/>

                                <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-save"></i></button>
                            </form>
                        </div>
                        @error("order.$node->id")
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror

                    </li>

                	@isset($node->children)
            		<x-nodes.nodes-list :nodes="$node->children"/>
                	@endisset

                	@endforeach



            	</ul>

            </ul>
            @endisset

        	@if(!isset($selectedNode))
            <form action="/nodes" method="post">
            	@csrf
            	<div class="row g-1">
            		<div class="col-10">
            			<div class="form-floating">
            				<input type="text" class="form-control form-control-sm" name="name"/>
            				<label>Nome nuovo nodo</label>
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
            @else
      		<form action="/nodes/{{ $selectedNode->id }}" method="post">
           		@csrf
           		<div class="row g-1">
           			<div class="col-10">
           				<div class="form-floating">
           					<input type="text" class="form-control form-control-sm" name="name"/>
           					<label>Nome nuovo nodo figlio</label>
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
        	@endif

        	@isset($selectedNode)
            <script>
                function confirmDelete() {
                    if(confirm("Confermi di voler cancellare il nodo selezionato (l'operazione cancellerà i nodi figli) ?")) {
                        window.location.href = "/nodes/{{ $selectedNode->id }}/delete";
                    }
                }
            </script>
            <a class="btn btn-primary btn-danger btn-sm mt-3" href="javascript:void(0)" onclick="confirmDelete()" role="button">Elimina nodo</a>
			@endisset

		</div>

		<div class="flex-grow-1">

            @isset($resources)
            <div class="p-4">

                <h5>Risorse</h5>

                <ul>

                    @foreach($resources as $resource)

                        <li>{{ $resource->name }}</li>

                        <ul>

                            @foreach($resource->fields as $field)

                                <li>{{ $field->name }}</li>

                            @endforeach



                        </ul>

                    @endforeach



                </ul>

            </div>
            @endisset


		</div>

	</div>

</x-layout>
