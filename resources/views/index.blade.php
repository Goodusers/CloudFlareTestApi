 {{-- Форма авторизации --}}
 {{-- пароль 123456 --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>cloudflare</title>
</head>
<body>
 
    <div class="content">
        <form class="signin" action="{{route('signin_form')}}" method="POST">
            @csrf
            <h3>АВТОРИЗАЦИЯ</h3>
            <input type="email" name="email" id="email" placeholder="email">
            @error('email')
                <div class="error">{{$message}}</div>
            @enderror
            <input type="password" name="password" id="password" placeholder="password">

            @error('password')
                <div class="error">{{$message}}</div>
            @enderror
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>