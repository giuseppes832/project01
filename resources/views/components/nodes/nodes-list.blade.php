


			<ul>

            	@foreach($nodes as $node)

            	<li>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <a href="/nodes/{{ $node->id }}">{{ $node->name }}</a>
                        <form class="d-flex" action="/nodes-order/{{ $node->id }}" method="post">
                            @csrf
                            @method("put")
                            <input type="text" class="form-control form-control-sm me-1" style="width: 40px;" name="order[{{ $node->id }}]" value="{{ old("order.$node->id", $node->order) }}"/>

                            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-circle"></i></button>
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
