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
<div class="mt-2 pt-1" id="timeEntriesFormContainer">
    <strong class="ml-2">{{__('message.fields_are_required')}}</strong>
    <form action="{{ route($lang.'_entry_hours.store') }}" method="POST" id="timeEntriesForm">
        @csrf

    </form>
</div>
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
            
    function createCountOfHours() {
        
        if (document.getElementById('totalCount') != null) {
            document.getElementById('totalCount').remove();
        }
        
        let totalCountHtml = document.createElement("div");
        totalCountHtml.setAttribute('id', 'totalCount');
        totalCountHtml.setAttribute('onchange', 'createCountOfHours()');

        let strongTotalcount = document.createElement("strong");
        strongTotalcount.innerText = "*{{ __('message.hour_count') }}: ";

        let totalCount = 0;
        for (let i = 0; i < document.getElementsByName('hours[]').length; i++) {
            if (document.getElementsByName('inputed_hours[]')[i] == null) {                
                if(Number.isInteger(parseInt(document.getElementsByName('hours[]')[i].value))){
                    totalCount += parseInt(document.getElementsByName('hours[]')[i].value);
                }
            } else {
                if(Number.isInteger(parseInt(document.getElementsByName('inputed_hours[]')[i].value))){
                    totalCount += parseInt(document.getElementsByName('inputed_hours[]')[i].value);
                }
            }
        }

        strongTotalcount.innerText += totalCount+"h";
        
        totalCountHtml.appendChild(strongTotalcount);
        
        document.getElementById('submitContainer').before(totalCountHtml);
        
    }

    function showDescription(containerId) {
        //Create task description
        if (document.getElementById('descContainer' + containerId) != null) {
            document.getElementById('descContainer' + containerId).remove();
        }
        let formGroup6 = document.createElement("div");
        formGroup6.setAttribute('class', 'form-group form_group_7');
        formGroup6.setAttribute('id', 'descContainer' + containerId);
        let labelDesc = document.createElement("label");
        labelDesc.innerText = "*{{ __('message.task_description') }}: ";
        labelDesc.setAttribute('for', 'desc' + containerId);
        formGroup6.appendChild(labelDesc);
        let inputDesc = document.createElement("input");
        inputDesc.setAttribute('name', 'desc[]');
        inputDesc.setAttribute('id', 'desc' + containerId);
        inputDesc.setAttribute('placeholder', "{{ __('message.task_description') }}");
        inputDesc.setAttribute('class', "form-control");
        formGroup6.appendChild(inputDesc);
        document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup6);
    }

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

        if (projectBagHourAvailable) {

            let formGroup5 = document.createElement("div");
            formGroup5.setAttribute('class', 'form-group form_group_6');
            formGroup5.setAttribute('id', 'inputedHoursContainer' + containerId);

            let labelImputedHours = document.createElement("label");
            labelImputedHours.innerText = "*{{ __('message.inputed_hours') }}: ";
            labelImputedHours.setAttribute('for', 'inputedHours' + containerId);
            formGroup5.appendChild(labelImputedHours);

            let imputedHoursHtml = document.createElement("input");
            imputedHoursHtml.setAttribute('type', 'number');
            imputedHoursHtml.setAttribute('name', 'inputed_hours[]');
            imputedHoursHtml.setAttribute('class', 'inputed_hours form-control');

            imputedHoursHtml.setAttribute('placeholder', "{{ __('message.inputed_hours') }}");
            imputedHoursHtml.setAttribute('oninput', 'createCountOfHours()');
            imputedHoursHtml.setAttribute('id', 'inputedHours' + containerId);

            if (document.getElementById('inputedHoursContainer' + containerId) != null) {
                document.getElementById('inputedHoursContainer' + containerId).remove();
            }

            formGroup5.appendChild(imputedHoursHtml);
            document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup5);

        } else {
            if (document.getElementById('inputedHoursContainer' + containerId) != null) {
                document.getElementById('inputedHoursContainer' + containerId).remove();
            }
        }

        showDescription(containerId);
    }

    function showProjectsOfUserAndCustomer(containerId) {
        let formGroup4 = document.createElement("div");
        formGroup4.setAttribute('class', 'form-group form_group_5');
        formGroup4.setAttribute('id', 'projectContainer' + containerId);
        let labelProject = document.createElement("label");
        labelProject.setAttribute('for', 'projects' + containerId);
        labelProject.innerText = "*{{ __('message.project') }}: ";
        formGroup4.appendChild(labelProject);

        //Create the select of projects
        let projectSelectHtml = document.createElement("select");
        projectSelectHtml.name = "projects[]";
        projectSelectHtml.setAttribute('id', 'projects' + containerId);
        projectSelectHtml.setAttribute('onchange', 'showHideImputedHours(' + containerId + ')');
        projectSelectHtml.setAttribute('class', 'form-control');

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
        formGroup3.setAttribute('class', 'form-group form_group_4');
        formGroup3.setAttribute('id', 'customerContainer' + containerId);
        let labelCustomer = document.createElement("label");
        labelCustomer.innerText = "*{{ __('message.customer') }}: ";
        labelCustomer.setAttribute('for', 'customers' + containerId);
        formGroup3.appendChild(labelCustomer);

        //Create the select of customers
        let customerSelectHtml = document.createElement("select");
        customerSelectHtml.name = "customers[]";
        customerSelectHtml.setAttribute('id', 'customers' + containerId);
        customerSelectHtml.setAttribute('onchange', 'showProjectsOfUserAndCustomer(' + containerId + ')');
        customerSelectHtml.setAttribute('class', 'form-control');
        
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
        $('#timeEntryContainer'+containerId).on('hidden.bs.collapse', function () {
            document.getElementById("timeEntryContainer" + containerId).remove();
            createCountOfHours();
        })
        
        $('#timeEntryContainer'+containerId).collapse('hide');
    }

    var countEntries = 0;
    function addEntry(containerId) {

        countEntries++;

        let entryContainerHtml = document.createElement("div");
        entryContainerHtml.setAttribute('id', 'timeEntryContainer' + countEntries);
        entryContainerHtml.setAttribute('class', 'time_entry_container d-flex flex-wrap');

        //Show add/remove buttons
        //Create buttons container
        let agregateButtonsContainer = document.createElement("div");
        agregateButtonsContainer.setAttribute('class', 'order-10 align-self-center');        
        agregateButtonsContainer.setAttribute('id', 'addRemoveEntryContainer');

        //Plus button
        let plusButton = document.createElement("a");
        plusButton.innerText = '+';
        plusButton.setAttribute('class', "btn btn-add")
        plusButton.setAttribute('onclick', 'addEntry(' + countEntries + ')');
        agregateButtonsContainer.appendChild(plusButton);

        //Take off button
        let takeOffButton = document.createElement("a");
        takeOffButton.innerText = '-';
        takeOffButton.setAttribute('class', "btn btn-remove")
        takeOffButton.setAttribute('onclick', 'removeEntry(' + countEntries + ')');
        agregateButtonsContainer.appendChild(takeOffButton);

        entryContainerHtml.appendChild(agregateButtonsContainer);

        //Show day with datepiker
        let formGroup1 = document.createElement("div");
        formGroup1.setAttribute('class', 'form-group form_group_1');
        let labelDay = document.createElement("label");
        labelDay.innerText = "*{{ __('message.day') }}: ";
        labelDay.setAttribute('for', 'dp' + countEntries);
        formGroup1.appendChild(labelDay);
        let inputDay = document.createElement("input");
        inputDay.setAttribute('name', 'days[]');
        inputDay.setAttribute('class', 'form-control');
        inputDay.setAttribute('id', 'dp' + countEntries);
        inputDay.setAttribute('onclick', "$('#dp" + countEntries + "').datepicker({dateFormat: 'dd/mm/yy'}).val();$('#dp" + countEntries + "').datepicker('show');");
        inputDay.setAttribute('placeholder', 'dd/mm/aaaa');
        
        formGroup1.appendChild(inputDay);
        entryContainerHtml.appendChild(formGroup1);

        //Show hours
        let formGroup2 = document.createElement("div");
        formGroup2.setAttribute('class', 'form-group form_group_2');
        formGroup2.setAttribute('oninput', 'createCountOfHours()');
        let labelHours = document.createElement("label");
        labelHours.setAttribute('for', 'hours' + countEntries);
        labelHours.innerText = "*{{ __('message.hours') }}: ";
        formGroup2.appendChild(labelHours);
        let inputHours = document.createElement("input");
        inputHours.setAttribute('id', 'hours' + countEntries)
        inputHours.setAttribute('name', 'hours[]');
        inputHours.setAttribute('type', 'number');
        inputHours.setAttribute('class', 'hours form-control');
        inputHours.setAttribute('placeholder', "{{ __('message.hours') }} ");

        formGroup2.appendChild(inputHours);
        entryContainerHtml.appendChild(formGroup2);

        if (containerId == 1 && countEntries == 1) {
            document.getElementById('timeEntriesForm').appendChild(entryContainerHtml);
            document.getElementById('timeEntryContainer1').getElementsByTagName('div')[0].getElementsByTagName('a')[1].setAttribute('class', "btn disabled btn-remove");
        } else {
            document.getElementById('timeEntryContainer' + containerId).after(entryContainerHtml);
        }

        showCustomersOfUser(countEntries);
        
        //Create submit button
        if (document.getElementById("submitContainer") != null)
            document.getElementById("submitContainer").remove();
        let buttonContainer = document.createElement("div");
        buttonContainer.setAttribute('class', 'form-group');
        buttonContainer.setAttribute('id', 'submitContainer');
        let submitHtml = document.createElement("button");
        submitHtml.innerText = "{{ __('message.save') }}";
        submitHtml.setAttribute('type', 'submit');
        submitHtml.setAttribute('class', 'btn btn-primary');
        buttonContainer.appendChild(submitHtml);

        document.getElementById('timeEntriesForm').appendChild(buttonContainer);

        //Create total count of hours
        createCountOfHours();
        
        if(countEntries != 1){
            $('#timeEntryContainer'+countEntries).collapse();
        }
    }

    addEntry(1);


</script>

@endsection
