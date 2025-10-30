<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   	@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/custom.css', 'resources/js/custom.js'])

    <title>Applicazione di Test</title>
  </head>
  <body>
  	<div class="d-flex flex-column h-100">
  	  <div>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">{{ env("APP_NAME") }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                @if(Auth::user()->isInvitedUser())
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="/my-invites">Inviti</a>
                </li>
                @endif
                @if(Auth::user()->isAdmin())
                <li class="nav-item">
                  <a class="nav-link" href="/apps/app">App</a>
                </li>

                @endif
				@if(Auth::user()->isOwner())
                <li class="nav-item">
                  <a class="nav-link" href="/apps/owner-app">App</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                  </a>
                  <ul class="dropdown-menu">
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
                </li>
                @endif
                @endauth
                <li class="nav-item">
                  <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                </li>
              </ul>
              <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
                <button class="btn btn-outline-success" type="submit">Search</button>
              </form>
            </div>
          </div>
        </nav>
    </div>

    <div class="flex-grow-1">
		{{ $slot }}
    </div>

    </div>

  </body>
</html>
