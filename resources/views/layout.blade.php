<html>
    <head>
        <title>@yield('title', 'Control panel')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
     
            #app{
                width: 95%;
                margin: auto;
            }
           
        </style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </head>
    
    <body>
        <div id="app" class="d-flex flex-column h-screen py-3">
            
            <div class="row">
                <header class="bg-primary bg-info border border-primary col-12 mb-2 py-2">
                    <h1>aTotArreu Control panel</h1>
                </header>

            </div>
            
            <div class="row">
                @include('partials.nav')
                <main class="col-10">
                    @yield('content')
                </main>
            </div>
            
            <div class="row">
                <footer class="col-12 text-center">
                    aTotArreu | Copyright @ {{ date("Y") }}
                </footer>
            </div>
                
    </body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
</html>

