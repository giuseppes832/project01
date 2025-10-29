<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/custom.css', 'resources/js/custom.js', 'resources/js/list.js'])

        <title>Mio Saas</title>
	</head>
  <body>



		@if(Auth::user()->canRead($selectedNode))
		<x-dynamic-component :component="$component" :selectedNode="$selectedNode" />
		@endif

        <div class="modal fade" id="globalModal" tabindex="-1" aria-labelledby="globalModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="globalModalLabel">Modifica</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="globalModalBody" class="modal-body">
                        <div class="w-100 text-center">
                            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
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
        		loadNode(event.relatedTarget.dataset.nodeId, "parent_row_id=" + event.relatedTarget.dataset.parentRowId, 'globalModalBody');
        	} else if (event.relatedTarget.dataset.method === 'put') {
        		loadRow(event.relatedTarget.dataset.rowId, 'globalModalBody');
        	}


        })

        globalModal.addEventListener('hidden.bs.modal', function (event) {
       		document.getElementById('globalModalBody').innerHTML = '<div class="w-100 text-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        	//window.refresh();
        })



        </script>

  </body>
</html>
