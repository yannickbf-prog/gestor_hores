@php
use Illuminate\Support\Facades\DB;
$header_h1 = "message.login";
$header_route = $lang."_login";
if (Auth::check()) {
    if(Auth::user()->isAdmin()){
        $header_h1 = "message.control_panel";
        $header_route = $lang."_home.index";
    }
    else if(Auth::user()->isUser()){
        $header_h1 = "message.entry_hours";
        $header_route = $lang."_entry_hours.index";
    }
}

@endphp
<html>
    <head>
        <title>@yield('title', 'Control panel')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--JQuery data piker theme-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        
         <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ URL::asset('css/styles.css') }}" />
        
        
<link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />
        
        @yield('js_head')
        
            
    </head>

    <body>

        <div id="app" class="d-flex flex-column h-screen pb-3">



            <div class="row">
                <header class="bg-primary bg-info border border-primary col-12 mb-2 py-2">
                    @if(DB::table('company')->first()->img_logo != null)
                  
                    <a href="{{ route($header_route) }}">
                        <img src="/storage/{{ DB::table('company')->first()->img_logo }}" class="logo" alt="Logo {{ DB::table('company')->first()->name }}">
                    </a>
                    
                    @endif
                    <a href="{{ route($header_route) }}">
                        <h1 class="companyname">{{DB::table('company')->first()->name}} | {{__($header_h1)}}</h1>
                    </a>
                    <div class="col-md-4 form-group">
                        <select class="form-control Langchange">
                            <option value="en" {{ setActiveLang('en') }}>{{ __('message.english') }}</option>
                            <option value="es" {{ setActiveLang('es') }}>{{ __('message.spanish') }}</option>
                            <option value="ca" {{ setActiveLang('ca') }}>{{ __('message.catalan') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        @auth
                        <ul>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{__("Logout")}}</a>
                            </li>
                        </ul>
                        
                        @endauth
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </header>
                <div class="col-12" id="showMenuBtnContainer" style="display: none;">
                    <div class="col-2 p-2">
                        <i class="bi bi-arrow-bar-right" onclick="showMenu()"></i>
                    </div>
                    <div class="col-10"></div>
                </div>
            </div>

            @section('nav_and_content')
            <div class="row" id="navAndContent">
                @include('partials.nav')
                <main class="col-12 col-md-10">
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
    
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

    <!--Here we add js code of the page if any -->
    @yield('js')
    
    <!-- We put here the code was need php variables -->
    <script type="text/javascript">
        <!-- We pass the lang value into datepiker -->
        $.datepicker.setDefaults($.datepicker.regional["{{ $lang }}"]);
        
        <!-- This code is used to change lang and go to the same page we are but now in other lang-->
        var url = "{{ route('LangChange') }}";
        $(".Langchange").change(function () {
            let currentRoute = "{{ Route::currentRouteName() }}";
            <!-- We need the id if we are editing an item or viewing an item to go to the same page -->
            let id = "@if(isset($user)){{$user->id}} @elseif(isset($customer)){{ $customer->id }} @elseif(isset($project)){{ $project->id }} @elseif(isset($typeBagHour)){{ $typeBagHour->id }} @else{{'noid'}} @endif";
            window.location.href = url + "?langToDisplay=" + $(this).val() + "&currentRoute=" + currentRoute + "&id=" + id;
        });
    </script>

    <script>

        if(document.getElementsByTagName('table')[0].getElementsByTagName('thead')[0]!=null){
            let camps=document.getElementsByTagName('table')[0].getElementsByTagName('thead')[0].getElementsByTagName('a');
            for(let i=0;i<camps.length;i++){
                camps[i].style.color = "#495057";
            }
        }
        
        function hideMenu() {

            let dimensionDiv = document.getElementsByTagName('nav')[0].getBoundingClientRect();

            let width = dimensionDiv.width;

            let height = dimensionDiv.height;

            document.getElementsByTagName('nav')[0].style.width = width;
            document.getElementsByTagName('nav')[0].style.height = height;
            document.getElementsByTagName('nav')[0].style.paddingTop = "15px";

            document.getElementsByTagName('nav')[0].setAttribute('class', 'nav flex-column');

            $('nav').animate({width: 'hide'}, function() {
                document.getElementsByTagName('main')[0].setAttribute('class', 'col-12');
                $('#showMenuBtnContainer').slideDown("slow");
            });

        }
        
        function showMenu() {
        
            let dimensionDiv = document.getElementById('navAndContent').getBoundingClientRect();

            let width = dimensionDiv.width;
            //let height = dimensionDiv.height;
            
            let calculatedWidth = (width/100)*16.666666666666;
            
            
            
            
            setTimeout(function () {
				document.getElementsByTagName('main')[0].setAttribute('class', 'col-12 col-md-10');
                document.getElementsByTagName('nav')[0].style.width = calculatedWidth;
                //document.getElementsByTagName('nav')[0].style.height = height;
                document.getElementsByTagName('nav')[0].style.paddingRight = "15px";
                document.getElementsByTagName('nav')[0].style.paddingTop = "15px";
                $('#showMenuBtnContainer').slideUp("slow", function(){
                       
                       $('nav').animate({width: 'show'}, function() {
                       
                            document.getElementsByTagName('nav')[0].removeAttribute("style")
                            document.getElementsByTagName('nav')[0].setAttribute('class', 'nav flex-column col-2 pl-0 pr-3 d-none d-md-block');
                       
                        });
                       
                });
                
                
            }, 100);
                
        }
    </script>
     


</html>

