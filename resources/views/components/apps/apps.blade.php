<x-layout>


	<div class="d-flex flex-row h-100">

		<div class="border-end w-25 h-100 p-4">

			<x-apps.app/>

		</div>

		<div class="flex-grow-1">

            <div class="p-4">

                <form action="/apps/owner-invite" method="post">
                    @csrf

                    @php

                    $email = null;
                    if (isset($owner)) {
                        $email = $owner->email;
                    }

                    @endphp

                    <div class="mb-2 form-floating">
                        <input type="text" name="email" value="{{ old("email", $email) }}" class="form-control"/>
                        <label>{{ __("main.apps.Email") }}</label>
                        @error("email")
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-send"></i> {{ __("Send Owner Invite") }}
                    </button>
                </form>

            </div>


            <div class="p-4">


                <h5>{{ __("main.apps.Smart creation tool") }}</h5>
                <form id="menu-items-container" action="/apps/app" method="post">
                    @csrf

                    <input type="text" class="form-control form-control-sm me-2 mb-2" style="width: 600px" name="menu_name" placeholder="{{ __("main.apps.Menu name") }}"/>
                    @error("menu_name")
                    {{ $message }}
                    @enderror

                </form>

                <button type="button" class="btn btn-primary btn-sm mb-2" onclick="newMenuItem()">{{ __("main.apps.New menu item") }}</button>

                <br>

                <button type="submit" class="btn btn-primary btn-sm" onclick="document.getElementById('menu-items-container').submit()">{{ __("main.apps.Save") }}</button>

                <script>

                    window.menuItemsCounter = 1;
                    window.menuItemsChildrenCounter = [];
                    window.menuItemsContainer = document.getElementById("menu-items-container");

                    window.deleteMenuItem = function(menuItemId) {

                        document.getElementById("menu-item-" + menuItemId).remove();

                        const elements = document.querySelectorAll(".ref-select");
                        for (const element of elements) {
                            loadMenuItems(element, menuItemId, 'HTML_SELECT');
                        }
                    }

                    window.loadMenuItems = function (select, currentMenuItemId, inputType) {

                        if ('FK' === inputType) {

                            let html = '';

                            html += '<option value="">{{ __("main.apps.Select") }} ...</option>';

                            for (const menuItem of window.menuItemsContainer.children) {

                                html += '<option value="' + menuItem.id +'">' + menuItem.id + '</option>'
                                if (menuItem.id === 'menu-item-' + currentMenuItemId) {
                                    break;
                                }
                            }

                            select.innerHTML = html;

                        }

                    }

                    window.deleteField = function (e) {
                        e.remove();
                    }

                    window.newMenuItem = function () {

                        let newNode = document.createElement('div');
                        newNode.id = 'menu-item-' + window.menuItemsCounter;

                        let html = '';

                        html += '<div class="d-flex mb-2 align-items-center">';
                        html += '<span class="me-2" style="width: 20px">' + window.menuItemsCounter + '</span>';
                        html += '<input type="text" class="form-control form-control-sm me-2" name="menu-item-' + window.menuItemsCounter + '" placeholder="{{ __("main.apps.Menu item name") }}"/>';
                        html += '<button type="button" class="btn btn-danger btn-sm me-2" onclick="deleteMenuItem(' + window.menuItemsCounter + ')">{{ __("main.apps.Delete") }}</button>';
                        html += '</div>';
                        html += '<h6 class="ms-4">{{ __("main.apps.Form fields") }}</h6>'
                        html += '<div id="container-menu-item-' + window.menuItemsCounter + '">';
                        html += '</div>'
                        html += '<button type="button" class="btn btn-primary btn-sm ms-4 mb-2" onclick="newField(this.previousElementSibling, ' + window.menuItemsCounter + ')">{{ __("main.apps.New field") }}</button>';

                        newNode.innerHTML = html;


                        window.menuItemsContainer.appendChild(newNode);

                        window.menuItemsCounter++;

                    }

                    window.newField = function (parent, menuItemCounter) {

                        if (!window.menuItemsChildrenCounter[menuItemCounter]) {
                            window.menuItemsChildrenCounter[menuItemCounter] = 1;
                        }

                        let menuItemChildCounter = window.menuItemsChildrenCounter[menuItemCounter];
                        let nodeName = 'menu-item-' + menuItemCounter + '-' + menuItemChildCounter;
                        let nodeRequired = nodeName + '-required';
                        let nodeUnique = nodeName + '-unique';
                        let nodeType = nodeName + '-type';
                        let nodeRef = nodeName + '-ref';

                        let newNode = document.createElement('div');
                        newNode.classList.add('d-flex', 'mb-2', 'align-items-center', 'ms-4');

                        let html = '';

                        html += '<input type="text" class="form-control form-control-sm me-2" style="width: 200px" name="' + nodeName + '" placeholder="{{ __("main.apps.Field name") }}"/>';
                        html += '<input class="form-check-input me-1" type="checkbox" name="' + nodeRequired + '"/><label class="form-check-label me-2">{{ __("main.apps.Required") }}</label>';
                        html += '<input class="form-check-input me-1" type="checkbox" name="' + nodeUnique + '"/><label class="form-check-label me-2">{{ __("main.apps.Unique") }}</label>';
                        html += '<select class="form-select form-select-sm me-2" style="width: 200px" name="' + nodeType + '" onchange="loadMenuItems(this.nextElementSibling, ' + menuItemCounter + ', this.value)">';
                        html += '<option value="">{{ __("main.apps.Input type") }} ...</option>';
                        html += '<option value="STRING">String</option>';
                        html += '<option value="INTEGER">Integer</option>';
                        html += '<option value="FLOAT">Float</option>';
                        html += '<option value="BOOLEAN">Boolean</option>';
                        html += '<option value="FK">Foreign key</option>';
                        html += '<option value="DATE">Date</option>';
                        html += '<option value="TIME">Time</option>';
                        html += '<option value="DATE_TIME">Date time</option>';
                        html += '<option value="TEXT">Text</option>';
                        html += '<option value="TIMESTAMP">Timestamp</option>';
                        html += '</select>';
                        html += '<select class="ref-select form-select form-select-sm me-2" style="width: 200px" name="' + nodeRef + '"></select>'
                        html += '<button type="button" class="btn btn-danger btn-sm me-2" onclick="deleteField(this.parentNode)">{{ __("main.apps.Delete") }}</button>';

                        newNode.innerHTML = html;

                        parent.appendChild(newNode);

                        window.menuItemsChildrenCounter[menuItemCounter]++;

                    }

                </script>

            </div>

		</div>

	</div>

</x-layout>
