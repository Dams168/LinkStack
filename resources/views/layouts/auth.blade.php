<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-p79.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/override.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/external-dependencies/bootstrap-icons.css') }}">

    <!-- Alpine.js v3 terbaru -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/external-dependencies/bootstrap-icons.css') }}">

    <title>LinkStack - {{Request::segment(1)}}</title>

</head>

<body>
    <nav class="auth-nav">
        <div class="nav-logo">
            <div class="logo">
                <img class="logo-image" src="{{ asset('assets/img/logo-p79.png') }}" alt="Logo">
                <p class="logo-text">LinkStack</p>
            </div>
        </div>

        <div class="nav-action">
            <select name="lang-opt" id="lang-opt" class="form-control transparent">
                <option value="English">English</option>
            </select>
            <a href="{{ route('register') }}" class="btn btn-primary btn-soft">Signup</a>
            <a href="{{ route('login') }}" class="btn btn-primary">Login<i class="bi bi-arrow-left-circle-fill"></i></a>
        </div>
    </nav>
    <main class="auth-page">
        @yield('content')
    </main>

    <footer class="auth-footer">
        <div class="footer-copyright">
            <div class="logo logo-sm">
                <img class="logo-image" src="{{ asset('assets/img/logo-p79.png') }}" alt="Logo">
                <p class="logo-text">LinkStack</p>
            </div>
            &#169;2026 All rights reserved.
        </div>

        <div class="footer-cto">
            @if(env('DISPLAY_FOOTER') === true)
            @if(env('DISPLAY_FOOTER_HOME') === true)<li class="list-inline-item"><a class="list-inline-item"
                    href="@if(str_replace('"', "", EnvEditor::getKey(' HOME_FOOTER_LINK'))==="" ){{ url('') }}@else{{
                    str_replace('"', "" , EnvEditor::getKey('HOME_FOOTER_LINK')) }}@endif">{{footer('Home')}}</a></li>
            @endif
            @if(env('DISPLAY_FOOTER_TERMS') === true)<li class="list-inline-item"><a class="list-inline-item"
                    href="{{ url('') }}/pages/{{ strtolower(footer('Terms')) }}">{{footer('Terms')}}</a></li>@endif
            @if(env('DISPLAY_FOOTER_PRIVACY') === true)<li class="list-inline-item"><a class="list-inline-item"
                    href="{{ url('') }}/pages/{{ strtolower(footer('Privacy')) }}">{{footer('Privacy')}}</a></li>@endif
            @if(env('DISPLAY_FOOTER_CONTACT') === true)<li class="list-inline-item"><a class="list-inline-item"
                    href="{{ url('') }}/pages/{{ strtolower(footer('Contact')) }}">{{footer('Contact')}}</a></li>@endif
            @endif
        </div>

    </footer>
</body>

</html>