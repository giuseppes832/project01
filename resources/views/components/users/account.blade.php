<x-layout>

    <div class="container mt-4">

        <h5>Password change</h5>

        <form action="/{{ $action }}" method="post">
            @csrf
            @method("put")

            <div class="mb-3 form-floating">
                <input type="password" class="form-control form-control-sm" name="current_password" value="{{ old("current_password") }}"/>
                <label>Current password</label>
                @error("current_password")
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3 form-floating">
                <input type="password" class="form-control form-control-sm" name="password" value="{{ old("password") }}"/>
                <label>New password</label>
                @error("password")
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3 form-floating">
                <input type="password" class="form-control form-control-sm" name="password2" value="{{ old("password2") }}"/>
                <label>Confirm password</label>
                @error("password2")
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-sm mb-3">
                <i class="bi bi-save"></i> Save
            </button>

        </form>

    </div>

</x-layout>
