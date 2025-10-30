<ul>

    <li><a href="/apps/app">App</a></li>

	<li><a href="/roles">Ruoli</a></li>

	<ul>
		@foreach($roles as $role)
		<li><a href="/roles/{{ $role->id }}">{{ $role->name }}</a></li>
		@endforeach

    </ul>

</ul>
