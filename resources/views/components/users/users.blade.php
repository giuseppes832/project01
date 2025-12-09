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
                        <label>{{ __("main.users.Name") }}</label>
                        @error("name")
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3 form-floating">
                        <input type="text" class="form-control form-control-sm" name="email" value="{{ old('email', $selectedUser->email) }}"/>
                        <label>{{ __("main.users.Email") }}</label>
                        @error("email")
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-outline-danger btn-sm mb-3">
                        <i class="bi bi-send"></i> {{ __("main.users.Send user invite") }}
                    </button>

                </form>

            </div>
            @endisset


            <ul>

                <li><a class="btn btn-sm btn" href="/apps/owner-app">App</a></li>

                <li><a class="btn btn-sm btn" href="/users">Invited Users</a></li>

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
                    <label>Name</label>
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


                <button type="submit" class="btn btn-outline-danger btn-sm mb-3">
                    <i class="bi bi-send"></i> Send User Invite
                </button>

            </form>
            @endif

            @isset($selectedUser)
            <script>
                function confirmDelete() {
                    if(confirm("Do you want to delete selected user ?")) {
                        window.location.href = "/users/{{ $selectedUser->id }}/delete";
                    }
                }
            </script>
            <a class="btn btn-primary btn-danger btn-sm mt-3" href="javascript:void(0)" onclick="confirmDelete()" role="button">
                <i class="bi bi-trash"></i> Delete User
            </a>
            @endisset

        </div>

        <div class="flex-grow-1">


            @isset($sharings)
            <div class="p-4">

                <h5>{{ __("main.nodes.Sharings") }}</h5>

                <ul>
                    @foreach($sharings as $sharing)
                    @if($sharing->sharingType && $sharing->sharingType->email)
                    <li class="d-flex align-items-center border-bottom mb-3">
                        <span style="width: 400px">
                        {{ $sharing->name }}<br>role: {{ $sharing->role->name }}<br>email: {{ $sharing->sharingType->email }}
                        </span>
                        @if("INVITED" === $sharing->getInvitationStatus())
                            <span class="text-success fw-bold">{{ __("main.nodes.Invited") }}</span>
                        @elseif("NOT_INVITED" === $sharing->getInvitationStatus())
                            <span class="flex-grow-1 text-warning fw-bold">{{ __("main.nodes.Not invited") }}</span>
                            <form class="m-3" action="/users" method="post">
                                @csrf
                                <input type="hidden" name="name" value="{{ $sharing->name }}">
                                <input type="hidden" name="email" value="{{ $sharing->sharingType->email }}">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-send"></i> Send User Invite
                                </button>
                            </form>
                        @endif

                    </li>
                    @endif
                    @endforeach
                </ul>

            </div>
            @endisset



        </div>

    </div>

</x-layout>
