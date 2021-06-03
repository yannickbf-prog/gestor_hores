@extends('layout')

@section('title', 'Login - Home')

@section('nav_and_content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('message.add_new')." ".__('message.time_entry') }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route($lang.'_time_entries.index') }}"> {{__('message.back')}}</a>
        </div>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger mt-3">
    <strong>{{__('message.woops!')}}</strong> {{__('message.input_problems')}}<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="alert alert-info mt-2">
    <strong>{{__('message.fields_are_required')}}</strong>
</div>

<form action="{{ route('time_entries.store',$lang) }}" method="POST" id="timeEntriesForm">
    @csrf

</form>
@stop

@section('js')
<script>


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


    //Get the object from json
    var json_data = @json($json_data);
            console.log(json_data);

    function showHideImputedHours(containerId) {

        let projectId = document.getElementById("projects" + containerId).value;
        let customerId = document.getElementById('customers' + containerId).value;
        
        let res = json_data.filter((item) => {
            return item.customer_id == customerId;
        });
        let projectsCustomer = res[0]['customer_projects'];
        
        
        let res2 = projectsCustomer.filter((item) => {
            return item.project_id == projectId;
        });

        let projectBagHourAvailable = res2[0]['projects_active'];
        projectBagHourAvailable = projectBagHourAvailable === 0 ? false : true;

        console.log(projectBagHourAvailable);

        if (projectBagHourAvailable) {
            
           

//            let formGroup6 = document.createElement("div");
//            formGroup6.setAttribute('class', 'form-group');
//            formGroup6.setAttribute('id', 'inputedHoursContainer' + containerId);
//
//            let strongImputedHours = document.createElement("strong");
//            strongImputedHours.innerText = "*{{ __('message.inputed_hours') }}: ";
//            formGroup6.appendChild(strongImputedHours);
//
//            let imputedHoursHtml = document.createElement("input");
//            imputedHoursHtml.setAttribute('type', 'number');
//            imputedHoursHtml.setAttribute('name', 'inputed_hours[]');
//
//            if (document.getElementById('inputedHoursContainer' + containerId) != null) {
//                document.getElementById('inputedHoursContainer' + containerId).remove();
//            }
//
//            formGroup6.appendChild(imputedHoursHtml);
//            document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup6);

        } else {
//            if (document.getElementById('inputedHoursContainer' + containerId) != null) {
//                document.getElementById('inputedHoursContainer' + containerId).remove();
//            }
        }

//        showDescription(containerId);
    }

    function showProjectsOfUserAndCustomer(containerId) {
        let formGroup4 = document.createElement("div");
        formGroup4.setAttribute('class', 'form-group');
        formGroup4.setAttribute('id', 'projectContainer' + containerId);
        let strongProject = document.createElement("strong");
        strongProject.innerText = "*{{ __('message.project') }}: ";
        formGroup4.appendChild(strongProject);

        //Create the select of projects
        let projectSelectHtml = document.createElement("select");
        projectSelectHtml.name = "projects[]";
        projectSelectHtml.setAttribute('id', 'projects' + containerId);
        projectSelectHtml.setAttribute('onchange', 'showHideImputedHours(' + containerId + ')');

        let customerId = document.getElementById('customers' + containerId).value;
        let res = json_data.filter((item) => {
            return item.customer_id == customerId;
        });
        let projectsCustomer = res[0]['customer_projects'];

        for (project of projectsCustomer) {

            let option = document.createElement("option");
            option.value = project.project_id;
            option.innerText = project.project_name;
            projectSelectHtml.appendChild(option);

        }

        if (document.getElementById('projectContainer' + containerId) != null) {
            document.getElementById('projectContainer' + containerId).remove();
        }

        formGroup4.appendChild(projectSelectHtml);
        document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup4);

        showHideImputedHours(containerId);
    }

    function showCustomersOfUser(containerId) {
        let formGroup3 = document.createElement("div");
        formGroup3.setAttribute('class', 'form-group');
        formGroup3.setAttribute('id', 'customerContainer' + containerId);
        let strongCustomer = document.createElement("strong");
        strongCustomer.innerText = "*{{ __('message.customer') }}: ";
        formGroup3.appendChild(strongCustomer);

        //Create the select of customers
        let customerSelectHtml = document.createElement("select");
        customerSelectHtml.name = "customers[]";
        customerSelectHtml.setAttribute('id', 'customers' + containerId);
        customerSelectHtml.setAttribute('onchange', 'showProjectsOfUserAndCustomer(' + containerId + ')');

        for (customer of json_data) {
            let option = document.createElement("option");
            option.value = customer.customer_id;
            option.innerText = customer.customer_name;
            customerSelectHtml.appendChild(option);
        }

        if (document.getElementById('customerContainer' + containerId) != null) {
            document.getElementById('customerContainer' + containerId).remove();
        }

        formGroup3.appendChild(customerSelectHtml);
        document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup3);

        showProjectsOfUserAndCustomer(containerId)
    }

    function removeEntry(containerId) {
        document.getElementById("timeEntryContainer" + containerId).remove();
    }

    var countEntries = 0;
    function addEntry(containerId) {

        countEntries++;

        let entryContainerHtml = document.createElement("div");
        entryContainerHtml.setAttribute('id', 'timeEntryContainer' + countEntries);

        //Show add/remove buttons
        //Create buttons container
        let agregateButtonsContainer = document.createElement("div");

        //Plus button
        let plusButton = document.createElement("a");
        plusButton.innerText = '+';
        plusButton.setAttribute('class', "btn btn-outline-success btn-sm")
        plusButton.setAttribute('onclick', 'addEntry(' + countEntries + ')');
        agregateButtonsContainer.appendChild(plusButton);

        //Take off button
        let takeOffButton = document.createElement("a");
        takeOffButton.innerText = '-';
        takeOffButton.setAttribute('class', "btn btn-outline-danger btn-sm")
        takeOffButton.setAttribute('onclick', 'removeEntry(' + countEntries + ')');
        agregateButtonsContainer.appendChild(takeOffButton);

        entryContainerHtml.appendChild(agregateButtonsContainer);

        //Show day with datepiker
        let formGroup1 = document.createElement("div");
        formGroup1.setAttribute('class', 'form-group');
        let strongDay = document.createElement("strong");
        strongDay.innerText = "*{{ __('message.day') }}: ";
        formGroup1.appendChild(strongDay);
        let inputDay = document.createElement("input");
        inputDay.setAttribute('name', 'days[]');
        inputDay.setAttribute('id', 'dp' + countEntries);
        inputDay.setAttribute('onclick', "$('#dp" + countEntries + "').datepicker({dateFormat: 'dd/mm/yy'}).val();$('#dp" + countEntries + "').datepicker('show');");

        formGroup1.appendChild(inputDay);
        entryContainerHtml.appendChild(formGroup1);

        //Show hours
        let formGroup2 = document.createElement("div");
        formGroup2.setAttribute('class', 'form-group');
        let strongHours = document.createElement("strong");
        strongHours.innerText = "*{{ __('message.hours') }}: ";
        formGroup2.appendChild(strongHours);
        let inputHours = document.createElement("input");
        inputHours.setAttribute('name', 'hours[]');
        inputHours.setAttribute('type', 'number');

        formGroup2.appendChild(inputHours);
        entryContainerHtml.appendChild(formGroup2);

        if (containerId == 1) {
            document.getElementById('timeEntriesForm').appendChild(entryContainerHtml);
            document.getElementById('timeEntryContainer1').getElementsByTagName('div')[0].getElementsByTagName('a')[1].setAttribute('class', "btn btn-outline-danger btn-sm disabled");
        } else {
            document.getElementById('timeEntryContainer' + containerId).after(entryContainerHtml);
        }

        showCustomersOfUser(countEntries);
    }

    addEntry(1);


</script>

@endsection
