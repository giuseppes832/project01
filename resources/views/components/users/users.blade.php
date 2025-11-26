<x-layout>


    <div class="d-flex flex-row h-100">

        <div class="border-end w-25 h-100 p-4">

            @isset($selectedUser)
            <div class="mb-3 pb-3 border-bottom">

                <h5>{{ $selectedUser->name }}</h5>

                <form action="/users/{{ $selectedUser->id }}" method="post">
                    @csrf
                    @method('put')

                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control form-control-sm" name="name" value="{{ old('name', $selectedUser->name) }}"/>
                        <label>Nome</label>
                        @error("name")
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control form-control-sm" name="email" value="{{ old('email', $selectedUser->email) }}"/>
                        <label>Email</label>
                        @error("email")
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-outline-danger btn-sm mb-3">Send User Invite</button>

                </form>

            </div>
            @endisset


            <ul>

                <li><a class="btn btn-sm btn" href="/apps/owner-app">App</a></li>

                <li><a class="btn btn-sm btn" href="/users">Utenti Invitati</a></li>

                <ul>

                    @foreach($users as $user)

                        <li><a class="btn btn-sm btn" href="/users/{{ $user->id }}">{{ $user->name }}</a></li>

                    @endforeach



                </ul>

            </ul>

            @empty($selectedUser)
            <form action="/users" method="post">
                @csrf

                <div class="mb-3 form-floating">
                    <input type="text" class="form-control form-control-sm" name="name"/>
                    <label>Nome</label>
                    @error("name")
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3 form-floating">
                    <input type="text" class="form-control form-control-sm" name="email"/>
                    <label>Email</label>
                    @error("email")
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <button type="submit" class="btn btn-outline-danger btn-sm mb-3">Send User Invite</button>

            </form>
            @endif

            @isset($selectedUser)
            <script>
                function confirmDelete() {
                    if(confirm("Confermi di voler cancellare l'utente selezionato ?")) {
                        window.location.href = "/users/{{ $selectedUser->id }}/delete";
                    }
                }
            </script>
            <a class="btn btn-primary btn-danger btn-sm mt-3" href="javascript:void(0)" onclick="confirmDelete()" role="button">Elimina utente</a>
            @endisset

        </div>

        <div class="flex-grow-1">





        </div>

    </div>

</x-layout>
