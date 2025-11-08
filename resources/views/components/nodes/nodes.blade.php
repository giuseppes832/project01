<x-layout>


	<div class="d-flex flex-row h-100">

		<div class="border-end w-25 h-100 p-4">

			@isset($selectedNode)
			<x-nodes.node :selectedNode="$selectedNode" />
			@endisset


			<ul>

                <li><a href="/apps/app">App</a></li>

            	<li><a href="/nodes">Nodi</a></li>

            	<ul>

                	@foreach($nodes as $node)

                	<li><a href="/nodes/{{ $node->id }}">{{ $node->name }}</a></li>

                	@isset($node->children)
            		<x-nodes.nodes-list :nodes="$node->children"/>
                	@endisset

                	@endforeach



            	</ul>

            </ul>

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
            <a class="btn btn-primary btn-danger btn-sm mt-3" href="/nodes/{{ $selectedNode->id }}/delete" role="button">Elimina nodo</a>
			@endisset

		</div>

		<div class="flex-grow-1">





		</div>

	</div>

</x-layout>
