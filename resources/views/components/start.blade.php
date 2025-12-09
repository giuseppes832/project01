<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/custom.css', 'resources/js/custom.js', 'resources/js/list.js'])

        <title>{{ env("APP_NAME") }}</title>
	</head>
  <body>



		@if($component && $selectedNode && Auth::user()->canRead($selectedNode))
		<x-dynamic-component :component="$component" :selectedNode="$selectedNode" />
		@endif

        <div class="modal fade" id="globalModal" tabindex="-1" aria-labelledby="globalModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="globalModalBody" class="modal-body">
                        <div class="w-100 text-center">
                            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">{{ __("main.start.Loading") }} ...</span>
                            </div>
                        </div>


                    </div>
                    <!--
                    <div class="modal-footer">
                    	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    	<button type="button" class="btn btn-primary">Save changes</button>
        			</div>
        			-->
                </div>
            </div>
        </div>

        <script>
        var globalModal = document.getElementById('globalModal')

        globalModal.addEventListener('shown.bs.modal', function (event) {

        	if (event.relatedTarget.dataset.method === 'post') {

                let nodeId = event.relatedTarget.dataset.nodeId;
                let parentRowId = event.relatedTarget.dataset.parentRowId;
                ajaxGET('/render/' + nodeId + '?parent_row_id=' + parentRowId, 'globalModalBody');

        	} else if (event.relatedTarget.dataset.method === 'put') {

                let rowId = event.relatedTarget.dataset.rowId;
                ajaxGET('/rows/' + rowId, 'globalModalBody');

        	}


        })

        globalModal.addEventListener('hidden.bs.modal', function (event) {
       		document.getElementById('globalModalBody').innerHTML = '<div class="w-100 text-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">{{ __("main.start.Loading") }} ...</span></div></div>';
        	//window.refresh();
        })



        window.submitRow = function(form) {
            event.preventDefault();
            document.getElementById('globalModalBody').innerHTML = '<div class="w-100 text-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">{{ __("main.start.Loading") }} ...</span></div></div>';

            let formData = new FormData(form);

            ajaxPOST(form.action, formData, 'globalModalBody', window.refresh);
        }


        window.deleteRow = function (rowId) {
            if(confirm('{{ __("main.start.Do you want to delete the selected record ?") }}')) {
                ajaxGET('/rows/' + rowId + "/delete", null, window.refresh);
            }
        }

        window.yes = function(selectedNodeId) {
            event.preventDefault();
            document.getElementById('globalModalBody').innerHTML = '<div class="w-100 text-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">{{ __("main.start.Loading") }} ...</span></div></div>';

            let form = event.target.form;
            let formData = new FormData(form);
            formData.set('new_node_id', selectedNodeId);

            ajaxPOST(form.action, formData, 'globalModalBody', window.refresh);
        }

        window.back = function () {
            event.preventDefault();
            document.getElementById('globalModalBody').innerHTML = '<div class="w-100 text-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">{{ __("main.start.Loading") }} ...</span></div></div>';

            let form = event.target.form;
            let formData = new FormData(form);
            formData.set('back', true);

            ajaxPOST(form.action, formData, 'globalModalBody', window.refresh);
        }


        </script>

  </body>
</html>
