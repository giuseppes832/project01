
<x-layout>

	<div class="d-flex flex-row h-100">

		<div class="border-end w-25 h-100 p-4">

			@isset($selectedResource)
			<x-resources.resource :selectedResource="$selectedResource" />
			@endisset

			@isset($selectedField)
			<x-resources.field :selectedField="$selectedField" />
			@endisset

            @isset($resources)
			<x-resources.resources-list :resources="$resources"/>
            @endisset

        	@if(!isset($selectedResource) && !isset($selectedField))
            <x-resources.resources-list-action-create-resource/>
            @endif

        	@isset($selectedResource)
            <x-resources.resources-list-action-create-field :selectedResource="$selectedResource" />
            <script>
                function confirmDelete() {
                    if(confirm("Do you want to delete the selected resource ? (this operation will delete related fields and nodes)")) {
                        window.location.href = "/resources/{{ $selectedResource->id }}/delete";
                    }
                }
            </script>
            <a class="btn btn-primary btn-danger btn-sm mt-3" href="javascript:void(0)" onclick="confirmDelete()" role="button">
                <i class="bi bi-trash"></i> Delete Resource
            </a>
            @endisset


            @isset($selectedField)
            <script>
                function confirmDelete() {
                    if(confirm("Do you want to delete the selected field ? (this operation will delete related nodes)")) {
                        window.location.href = "/fields/{{ $selectedField->id }}/delete";
                    }
                }
            </script>
            <a class="btn btn-danger btn-sm mt-3" href="javascript:void(0)" onclick="confirmDelete()" role="button">
                <i class="bi bi-trash"></i> Delete Field
            </a>
			@endisset


            @if(!isset($selectedResource) && !isset($selectedField))
            <form action="/resources/template1" method="post">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm mt-3" href="">
                    <i class="bi bi-plus-circle"></i> Create template 1
                </button>
            </form>

            <form action="/resources/template2" method="post">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm mt-3" href="">
                    <i class="bi bi-plus-circle"></i> Create template 2
                </button>
            </form>

            <form action="/resources/template3" method="post">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm mt-3" href="">
                    <i class="bi bi-plus-circle"></i> Create template 3
                </button>
            </form>
            @endif

		</div>

		<div class="flex-grow-1">

		</div>

	</div>

</x-layout>
