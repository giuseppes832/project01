<ul>

	<li><a href="/resources">Radice</a></li>

	<ul>

    	@foreach($resources as $resource)

    	<li><a href="/resources/{{ $resource->id }}">{{ $resource->name }}</a></li>

		<ul>

        	@foreach($resource->fields as $field)

        	<li><a href="/fields/{{ $field->id }}">{{ $field->name }}</a></li>

        	@endforeach



        </ul>

    	@endforeach



    </ul>

</ul>


