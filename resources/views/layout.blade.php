<html>
    <head>
        <title>@yield('title', 'Control panel')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!--JQuery data piker theme-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!--<link rel="stylesheet" href="/resources/demos/style.css">-->

        <!-- css for bootrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <style>

            #app{
                width: 95%;
                margin: auto;
            }

            svg{
                width: 20px;
                height: 20px;
            }

            #paginationContainer > nav{
                display: flex;
                justify-content: space-between;
            }

            #paginationContainer > nav > div{
                width: 50%;
            }

            #paginationContainer > nav > div:nth-child(2){
                display: flex;
                flex-direction: column;
                align-items: flex-end;
            }

            #paginationContainer > nav > div:nth-child(2) > div:first-child{
                order: 2;
                margin-top: 10px;
            }
        </style>
        
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

    <!--Jquery inicial<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
    
    <!-- Script for bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- jQuery needed for datapiker and bootstrap -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    
    <!-- Datapiker ui -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <!-- Load datapiker -->
    <script>
        $(function () {
            $("#datepicker").datepicker();
        });
    </script>
    
    <!--Used for change languajes-->
    <!--
    <script>
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
      $.datepicker.setDefaults($.datepicker.regional["ca"]);
    -->
</script>
</html>

