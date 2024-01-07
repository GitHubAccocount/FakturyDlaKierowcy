<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <div style="text-align: center;">
    <h2>Poniżej znajduje się link do resetu hasła:</h2>
    <a href="{{route('password.reset', $token)}}" style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: #2D3748; border: none; border-radius: 0.375rem; font-weight: 600; font-size: 0.75rem; color: #FFFFFF; text-transform: uppercase; letter-spacing: 0.05em; text-decoration: none; transition: background-color 0.15s ease-in-out;">Zresetuj hasło</a>
  </div>
  <div style="text-align: center; margin-top: 15px;">
    <p>Jeżeli przycisk nie działa, skpoiuj poniższy link do swojej przeglądarki:</p>
    <p>{{ config('app.url') }}/reset-password/{{$token}}</p>
  </div>
</body>
</html>