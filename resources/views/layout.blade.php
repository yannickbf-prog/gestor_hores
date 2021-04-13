<html>
    <head>
        <title>@yield('title', 'Control panel')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--JQuery data piker theme-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Datapiker ui -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <script>
        $(function () {
            $('.example-popover').popover({
                container: '#inputDates',
                content: '<div class="row"><div class="col-xs-12 col-sm-12 col-md-12"><div class="form-group"><strong>Date piker:</strong><input type="text" id="datepicker2"></div></div></div>',
                html: true
            }).on('shown.bs.popover', function () {
                $("#datepicker2").datepicker();
            });
        });
    </script>

    <!-- Datapiker ui -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    


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
    
</script>
    -->
</html>

