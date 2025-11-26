<ul>

    <li><a class="btn btn-sm btn"href="/apps/app">App</a></li>

	<li><a class="btn btn-sm btn" href="/roles">Ruoli</a></li>

	<ul>
		@foreach($roles as $role)
		<li><a class="btn btn-sm btn" href="/roles/{{ $role->id }}">{{ $role->name }}</a></li>
		@endforeach

    </ul>

</ul>
