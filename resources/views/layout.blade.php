@php
use Illuminate\Support\Facades\DB;
@endphp
<html>
    <head>
        <title>@yield('title', 'Control panel')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--JQuery data piker theme-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
        <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}" />

        
    </head>

    <body>

        <div id="app" class="d-flex flex-column h-screen py-3">



            <div class="row">
                <header class="bg-primary bg-info border border-primary col-12 mb-2 py-2">
                    @if(DB::table('company')->first()->img_logo != null)
                    <img src="/storage/{{ DB::table('company')->first()->img_logo }}" class="logo" alt="Logo {{ DB::table('company')->first()->name }}">
                    @endif
                    <h1>{{DB::table('company')->first()->name}} | {{__('message.control_panel')}}</h1>
                    <div class="col-md-4 form-group">
                        <select class="form-control Langchange">
                            <option value="en" {{ setActiveLang('en') }}>{{ __('message.english') }}</option>
                            <option value="es" {{ setActiveLang('es') }}>{{ __('message.spanish') }}</option>
                            <option value="ca" {{ setActiveLang('ca') }}>{{ __('message.catalan') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        @auth
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__("Logout")}}</a>
                        </li>
                        @endauth
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </header>

            </div>

            @section('nav_and_content')
            <div class="row">
                @include('partials.nav')
                <main class="col-10">
                    @yield('content')
                </main>
            </div>
            @show

            <div class="row">
                <footer class="col-12 text-center">
                    {{ DB::table('company')->first()->name }} | Copyright @ {{ date("Y") }}
                </footer>
            </div>

    </body>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Datapiker ui -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    
    <script type="text/javascript">
        $(function () {
            $(".datepicker").datepicker({dateFormat: "dd/mm/yy"}).val();
        });
        
        
         $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };


        $.datepicker.regional["ca"] = {
            closeText: "Tancar",
            prevText: "< Ant",
            nextText: "Seg >",
            currentText: "Hoy",
            monthNames: [
                "Gener",
                "Febrer",
                "Març",
                "Abril",
                "Maig",
                "Juny",
                "Juliol",
                "Agost",
                "Septembre",
                "Octubre",
                "Novembre",
                "Desembre",
            ],
            monthNamesShort: [
                "Gen",
                "Feb",
                "Mar",
                "Abr",
                "Mai",
                "Jun",
                "Jul",
                "Ago",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
            dayNames: [
                "Diumenje",
                "Dilluns",
                "Dimarts",
                "Dimecres",
                "Dijous",
                "Divendres",
                "Dissabte",
            ],
            dayNamesShort: ["Diu", "Dil", "Dim", "Dme", "Dij", "Div", "Dis"],
            dayNamesMin: ["Di", "Dl", "Dm", "Dc", "Dj", "Dv", "Ds"],
            weekHeader: "Sm",
            dateFormat: "dd/mm/yy",
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: "",
        };
        
        $.datepicker.setDefaults($.datepicker.regional["{{ $lang }}"]);
        
        var url = "{{ route('LangChange') }}";
        $(".Langchange").change(function () {
            let currentRoute = "{{ Route::currentRouteName() }}";
            let id = "@if(isset($customer)){{ $customer->id }} @else{{'noid'}} @endif";
            window.location.href = url + "?langToDisplay=" + $(this).val() + "&currentRoute=" + currentRoute + "&id=" + id;
        });
    </script>

     @yield('js')


</html>

