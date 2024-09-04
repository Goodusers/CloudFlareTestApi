<?php
    $currentUrl = url()->current();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>cloudflare_test || @yield('title')</title>
</head>
<body>
    <header>
        <nav>
            @auth
                @switch( $currentUrl )
                    @case('http://cloud/domains')
                        <a href="{{route('accounts')}}">Параметры акканута</a>
                        
                        @break
                    @case('http://cloud/accounts')
                        <a href="{{route('page')}}">Общая ифнормация</a>
                        
                        @break
                    @default
                        
                @endswitch
                <a href="{{route('logout')}}">Выйти</a>
            @endauth
        </nav>
    </header>
    <div class="content">
        @yield('content')
    </div>

</body>
</html>