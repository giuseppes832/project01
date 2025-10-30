<x-layout>

@isset($selected)
Selected: {{ $selected->name }}
@endisset

<ul class="p-4">

	@foreach($sharings as $sharing)

	<li><a href="/select-sharing/{{ $sharing->id }}">Seleziona utente: {{ $sharing->name }}</a></li>

	@endforeach

</ul>

</x-layout>
