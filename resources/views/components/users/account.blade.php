<x-layout>

    <div class="container mt-4">

        <form action="/{{ $action }}" method="post">
            @csrf
            @method("put")

            <div class="mb-3 form-floating">
                <input type="text" class="form-control form-control-sm" name="name" value="{{ old("name", $user->name) }}"/>
                <label>Nome</label>
                @error("name")
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3 form-floating">
                <input type="text" class="form-control form-control-sm" name="email" value="{{ old("email", $user->email) }}"/>
                <label>Email</label>
                @error("email")
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3 form-floating">
                <input type="password" class="form-control form-control-sm" name="current_password" value="{{ old("current_password") }}"/>
                <label>Password Corrente</label>
                @error("current_password")
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3 form-floating">
                <input type="password" class="form-control form-control-sm" name="password" value="{{ old("password") }}"/>
                <label>Nuova Password</label>
                @error("password")
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3 form-floating">
                <input type="password" class="form-control form-control-sm" name="password2" value="{{ old("password2") }}"/>
                <label>Conferma Password</label>
                @error("password2")
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-sm mb-3">Salva</button>

        </form>

    </div>

</x-layout>
