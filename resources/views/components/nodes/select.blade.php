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


    <div class="mb-3 form-floating">
        <select class="form-select" name="form" aria-label="Form">
            <option value="" selected>{{ __("main.nodes.Select") }} ...</option>
            @foreach($forms as $form)
                <option value="{{ $form->id }}" @if ($form->id == old('form', $selectedNode->html->form_id)) selected @endif>{{ $form->node->name }}</option>
            @endforeach
        </select>
        <label>{{ __("main.nodes.Form") }}</label>
    </div>

    <button type="submit" class="btn btn-primary btn-sm mb-3">
        <i class="bi bi-save"></i> {{ __("main.nodes.Save") }}
    </button>

</form>
