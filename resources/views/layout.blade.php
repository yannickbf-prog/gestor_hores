<html>
    <head>
        <title>@yield('title', 'Control panel')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .active a{
                color: red;
                text-decoration: none;
            }
           
        </style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </head>
    
    <body>
        <div id="app" class="d-flex flex-column h-screen">
            <header class="p-3 bg-primary bg-info border border-primary mb-1">
                <h1>aTotArreu Control panel</h1>
            </header>
            <section class="row">
            <nav class="col-2 bg-primary bg-info border border-primary">
                <ul>
                    <li class=" {{ setActive('home') }}"><a class="nav-link" href="{{ route('home') }}">@lang('Home')</a></li>
                    <li><a class="nav-link {{ request()->routeIs('home') ? 'active' : ''}}" href="{{ route('home') }}">@lang('Company info')</a>
                    </li>
                    <li>Users</li>
                    <li>Customers</li>
                    <li>Projects</li>
                    <li>Hours bag</li>
                    <li>Hours bag types</li>
                    <li>Hours entry</li>
                </ul>
            </nav>
            <main class="col-10">
                @yield('content')
            </main>
            </section>
            
            <footer>
                aTotArreu | Copyright @ {{ date("Y") }}
            </footer>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
</html>

