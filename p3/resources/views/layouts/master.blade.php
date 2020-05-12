<!doctype html>
<html lang='en'>
<head>
    <title>@yield('title')</title>
    <meta charset='utf-8'>

        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href='/css/p3.css' rel='stylesheet'>
        {{-- font awesome icon fas fa-temperature-low  --}}
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>

    @yield('head')
</head>
<body>

    @if(session('flash-alert'))
    <div class='flash-alert'>
        {{ session('flash-alert') }}
    </div>
    @endif

<header>
     <a href='/'><img src='/images/p3-logo.png' id='logo' alt='p3 Logo'></a> 
        <nav>
            <ul>
                <li><a href='/'>Home</a></li>

                 @if(Auth::user())
                <li><a href='/devices'>All devices</a></li>
                <li><a dusk='add-device-link' href='/devices/create'>Add a Device</a></li>
                @endif

                <li>
                    @if(!Auth::user())
                        <a href='/login'>Login</a>
                    @else
                        <form method='POST' id='logout' action='/logout'>
                            {{ csrf_field() }}
                        <a href='#' onClick='document.getElementById("logout").submit();'>Logout</a>
                        </form>
                    @endif
                </li>
            </ul>
        </nav>
</header>

<section>
    @yield('content')
</section>

<footer>
    &copy; {{ date('Y') }}
    {{-- chart.js cdn--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" charset="utf-8"></script>

</footer>

</body>
</html>