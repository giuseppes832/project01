<form action="/nodes6/{{ $selectedNode->id }}" method="post">
    @csrf
    @method('put')

    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" id="auth_filtered" name="auth_filtered" @if (true == old('auth_filtered', $selectedNode->html->auth_filtered)) checked @endif>
        <label class="form-check-label" for="auth_filtered">
            {{ __("main.nodes.Auth select") }} ({{ __("main.nodes.Authorization check") }})
        </label>
    </div>

    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" id="subselect" name="subselect" @if (true == old('subselect', $selectedNode->html->subselect)) checked @endif>
        <label class="form-check-label" for="subselect">
            {{ __("main.nodes.Subselect") }} ({{ __("main.nodes.Authorization check") }})
        </label>
    </div>

    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" id="multiple" name="multiple" @if (true == old('multiple', $selectedNode->html->multiple)) checked @endif>
        <label class="form-check-label" for="multiple">
            {{ __("main.nodes.Multiple") }}
        </label>
    </div>

    <div class="mb-3 form-floating">
        <select class="form-select" name="binding" aria-label="Campo">
            <option value="" selected>{{ __("main.nodes.Select") }} ...</option>
            @foreach($fields as $field)
                <option value="{{ $field->id }}" @if ($field->id == old('binding', $selectedNode->html->binding_id)) selected @endif>{{ $field->resource->name }}\{{ $field->name }}</option>
            @endforeach
        </select>
        <label>{{ __("main.nodes.Binding field") }}</label>
    </div>

    @if($selectedNode->html->binding_id)
    <div class="mb-3 form-floating">
        <select class="form-select" name="form_binding" aria-label="Risorsa collegata">
            <option value="" selected>{{ __("main.nodes.Select") }} ...</option>
            @foreach($forms as $form)
                <option value="{{ $form->id }}" @if ($form->id == old('form_binding', $selectedNode->html->form_binding_id)) selected @endif>{{ $form->node->name }}</option>
            @endforeach
        </select>
        <label>{{ __("main.nodes.Linked resource") }}</label>
    </div>

    @if($selectedNode->html->form_binding_id)
    <div class="mb-3 form-floating">
        <select class="form-select" name="form_field_binding" aria-label="Campo risorsa collegato">
            <option value="" selected>{{ __("main.nodes.Select") }} ...</option>
            @foreach($formFields as $formField)
                <option value="{{ $formField->id }}" @if ($formField->id == old('form_field_binding', $selectedNode->html->form_field_binding_id)) selected @endif>{{ $formField->name }}</option>
            @endforeach
        </select>
        <label>{{ __("main.nodes.Linked field") }}</label>
    </div>
    @endif
    @endif

    <button type="submit" class="btn btn-primary btn-sm mb-3">
        <i class="bi bi-save"></i> {{ __("main.nodes.Save") }}
    </button>

</form>
