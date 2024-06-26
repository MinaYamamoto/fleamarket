<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @livewireStyles
    @yield('stylesheet')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                @can('admin-authority')
                <h1 class="header__logo-link">
                    @if(config('app.env')=== 'local')
                    <img class="header__logo-img" src="{{ Storage::url('logo.svg') }}" alt="logo">
                    @elseif(config('app.env')=== 'production')
                    <img class="header__logo-img" src="{{ Storage::disk('s3')->url('logo.svg') }}" alt="logo">
                    @endif
                </h1>
                @endcan
                @can('user-authority')
                <h1 class="header__logo-link">
                    @if(config('app.env')=== 'local')
                    <a href="/"><img class="header__logo-img" src="{{ Storage::url('logo.svg') }}" alt="logo"></a>
                    @elseif(config('app.env')=== 'production')
                    <a href="/"><img class="header__logo-img" src="{{ Storage::disk('s3')->url('logo.svg') }}" alt="logo"></a>
                    @endif
                </h1>
                @endcan
                @guest
                <h1 class="header__logo-link">
                    @if(config('app.env')=== 'local')
                    <a href="/"><img class="header__logo-img" src="{{ Storage::url('logo.svg') }}" alt="logo"></a>
                    @elseif(config('app.env')=== 'production')
                    <a href="/"><img class="header__logo-img" src="{{ Storage::disk('s3')->url('logo.svg') }}" alt="logo"></a>
                    @endif
                </h1>
                @endguest
            </div>
            @yield('header')
        </div>
    </header>

    <main>
        @yield('content')
        @livewireScripts
    </main>

</body>

</html>