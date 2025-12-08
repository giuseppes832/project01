<h5>{{ __("main.new-sharing.New sharing") }}</h5>
<form action="/sharings2" method="post" onsubmit="submitRow(this, 'globalModalBody')">
    @csrf





    @isset($redirect_row_id)
        <input type="hidden" name="redirect_row_id" value="{{ $redirect_row_id }}">
    @endisset

    @isset($redirect_node_id)
        <input type="hidden" name="redirect_node_id" value="{{ $redirect_node_id }}">
    @endisset

    @isset($redirect_inputs)

        @foreach($redirect_inputs as $inputName => $inputValue)
            @if(!is_array($inputValue))
                <input type="hidden" name="old_{{ $inputName }}" value="{{ $inputValue }}">
            @else
                @foreach($inputValue as $index => $singleInputValue)
                    <input type="hidden" name="old_{{ $inputName }}[{{ $index }}]" value="{{ $singleInputValue }}">
                @endforeach

            @endif
        @endforeach
    @endisset






    <div class="mb-2 form-floating">
        <input type="text" name="name" value="{{ old("name") }}" class="form-control form-control-sm"/>
        <label>{{ __("main.new-sharing.Sharing name") }}</label>
        @error("name")
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3 form-floating">
        <select class="form-select" name="role_id" aria-label="Ruolo">
            <option value="" selected>{{ __("main.new-sharing.Select") }} ...</option>
            @foreach($roles as $value => $role)
                <option value="{{ $role->id }}" @if ($role->id == old('role_id')) selected @endif>{{ $role->name }}</option>
            @endforeach
        </select>
        <label>{{ __("main.new-sharing.Role") }}</label>
        @error("role_id")
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3 form-floating">
        <input type="text" name="email" value="{{ old("email") }}" class="form-control form-control-sm"/>
        <label>{{ __("main.new-sharing.Use email") }}</label>
        @error("email")
        <div class="text-danger">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" name="send_invite">
        <label class="form-check-label">
            {{ __("main.new-sharing.Send invite if not already done.") }}
        </label>
    </div>



    <div class="text-end">

        <button type="submit" class="btn btn-warning" onclick="back()">
            <i class="bi bi-chevron-left"></i> {{ __("main.new-sharing.Back") }}
        </button>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> {{ __("main.new-sharing.Save") }}
        </button>

    </div>

</form>
