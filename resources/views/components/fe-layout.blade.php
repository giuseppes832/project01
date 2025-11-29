<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   	@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/custom.css', 'resources/js/custom.js'])

    <title>{{ env("APP_NAME") }}</title>
  </head>
  <body>

	{{ $slot }}

  </body>
</html>
