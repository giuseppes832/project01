<ul>

    <li><a href="/apps/owner-app">App</a></li>

	<li><a href="/sharings">Condivisioni</a></li>

	<ul>

    	@foreach($sharings as $sharing)

    	<li><a href="/sharings/{{ $sharing->id }}">{{ $sharing->name }}</a></li>

    	@endforeach



    </ul>

</ul>
