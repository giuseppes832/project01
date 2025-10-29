
<x-layout>

	<div class="d-flex flex-row h-100">

		<div class="border-end w-25 h-100 p-4">

			@isset($selectedResource)
			<x-resources.resource :selectedResource="$selectedResource" />
			@endisset

			@isset($selectedField)
			<x-resources.field :selectedField="$selectedField" />
			@endisset

			<x-resources.resources-list :resources="$resources"/>

        	@empty($selectedResource)
            <x-resources.resources-list-action-create-resource/>
            @endempty

        	@isset($selectedResource)
            <x-resources.resources-list-action-create-field :selectedResource="$selectedResource" />
            <a class="btn btn-primary btn-danger btn-sm mt-3" href="/resources/{{ $selectedResource->id }}/delete" role="button">Elimina risorsa</a>
            @endisset


            @isset($selectedField)
            <a class="btn btn-primary btn-danger btn-sm mt-3" href="/fields/{{ $selectedField->id }}/delete" role="button">Elimina campo</a>
			@endisset

		</div>

		<div class="flex-grow-1">

		</div>

	</div>

</x-layout>
