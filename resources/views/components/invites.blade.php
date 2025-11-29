<x-layout>

    @isset($selected)
    Selected: {{ $selected->name }}
    @endisset

    @isset($sharings)
    <ul class="p-4">

        @foreach($sharings as $sharing)

        <li><a href="/select-sharing/{{ $sharing->id }}">Select sharing: {{ $sharing->name }}</a></li>

        @endforeach

    </ul>
    @endisset

</x-layout>
