<ul>

    <li><a class="btn btn-sm btn" href="/apps/app">App</a></li>

	<li><a class="btn btn-sm btn" href="/resources">Risorse</a></li>

	<ul>

    	@foreach($resources as $resource)

    	<li><a class="btn btn-sm btn" href="/resources/{{ $resource->id }}">{{ $resource->name }}</a></li>

		<ul>

        	@foreach($resource->fields as $field)

        	<li class="btn btn-sm btn"><a href="/fields/{{ $field->id }}">{{ $field->name }}</a></li>

        	@endforeach



        </ul>

    	@endforeach



    </ul>

</ul>


