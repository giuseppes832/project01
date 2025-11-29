<x-layout>


	<div class="d-flex flex-row h-100">

        @isset($node)
		<div class="border-end w-25 h-100 p-4">

            <ul>

                <li>App <a href="/render/{{ $node->id }}" target="_blank">START</a></li>
                <ul>
                    <li><a href="/sharings">Condivisioni</a></li>
                </ul>

            </ul>

		</div>
        @endisset

		<div class="flex-grow-1">

            <div class="p-4">

                <a class="btn btn-primary" href="/apps/owner-app/data">
                    <i class="bi bi-filetype-json"></i> Export all data
                </a>

            </div>

		</div>

	</div>

</x-layout>
