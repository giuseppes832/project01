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
                        <label>Email</label>
                        @error("email")
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-send"></i> Send Owner Invite
                    </button>
                </form>

            </div>



		</div>

	</div>

</x-layout>
