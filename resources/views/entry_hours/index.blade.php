@extends('layout')

@section('title', __('message.control_panel')." - ". __('message.time_entries'))

@section('content')
@if ($message = Session::get('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

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

<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('message.time_entries') }}</h2>
        </div>
    </div>
</div>

<table class="table table-bordered">
    @if (count($data) > 0)
    <tr>
        <th>Nº</th>
        <th>{{ __('message.username') }}</th>
        <th>{{ __('message.bag_hour_type') }}</th>
        <th>{{ __('message.project_name') }}</th>
        <th>{{ __('message.customer_name') }}</th>
        <th>{{ __('message.hours') }}</th>
        <th>{{ __('message.state') }}</th>
        <th>{{ __('message.created_at') }}</th>
        <th>{{ __('message.action') }}</th>
    </tr>
    @endif
    @forelse ($data as $key => $value)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $value->user_name }}</td>
        <td>{{ $value->type_bag_hour_name }}</td>
        <td>{{ $value->project_name }} </td>
        <td>{{ $value->customer_name }}</td>
        <td>{{ $value->hour_entry_hours }}h</td>
        <td>{{ ($value->hour_entry_validate == '1') ? __('message.validated') : __('message.invalidated') }}</td>
        <td>{{ Carbon\Carbon::parse($value->hour_entry_created_at)->format('d/m/y') }}</td>
        <td>
            @if($value->hour_entry_validate == '0')
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#validateModal">
                {{ __('message.validate') }}
            </button>
            <!-- Modal Validate-->
            <div class="modal fade" id="validateModal" tabindex="-1" role="dialog" aria-labelledby="validateModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('message.validate') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ __('message.confirm_validate') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('message.close') }}</button>
                            <a class="btn btn-success" href="{{ route('entry_hours.validate',[$value->hours_entry_id, $lang]) }}">{{ __('message.validate') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#invalidateModal">
                {{ __('message.invalidate') }}
            </button>
            <!-- Modal Invalidate-->
            <div class="modal fade" id="invalidateModal" tabindex="-1" role="dialog" aria-labelledby="invalidateModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">{{ __('message.invalidate') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ __('message.confirm_invalidate') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('message.close') }}</button>
                            <a class="btn btn-success" href="{{ route('entry_hours.invalidate',[$value->hours_entry_id, $lang]) }}">{{ __('message.invalidate') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </td>
        <td>{{ $value->hours_entry_id }}</td>
    </tr>
    @empty
    <li>{{__('message.no')}} {{__('message.time_entries')}} {{__('message.to_show')}}</li>
    @endforelse

</table> 
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection
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
    var users_info = @json($users_info);
            var users_customers = @json($users_customers);
    console.log(users_info);
    console.log(users_customers);

    function createCountOfHours() {
        
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
        
        if(document.getElementById('totalCount') == null){
            document.getElementById('timeEntriesForm').lastChild.appendChild(totalCountHtml);
        }
        else{            
            document.getElementById('totalCount').remove();
            document.getElementById('submitContainer').before(totalCountHtml);
        }
    }

    function showDescription(containerId) {
        //Create task description
        if (document.getElementById('descContainer' + containerId) != null) {
            document.getElementById('descContainer' + containerId).remove();
        }
        let formGroup7 = document.createElement("div");
        formGroup7.setAttribute('class', 'form-group');
        formGroup7.setAttribute('id', 'descContainer' + containerId);
        let strongDesc = document.createElement("strong");
        strongDesc.innerText = "*{{ __('message.task_description') }}: ";
        formGroup7.appendChild(strongDesc);
        let inputDesc = document.createElement("input");
        inputDesc.setAttribute('name', 'desc[]');
        formGroup7.appendChild(inputDesc);
        document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup7);
        
        //Create total count of hours
        createCountOfHours();
    }

    function showHideImputedHours(containerId) {

        let userId = document.getElementById("users" + containerId).value;
        let projectId = document.getElementById("projects" + containerId).value;

        let res = users_info.filter((item) => {
            return item.user_id == userId;
        });

        let userProjects = res[0]['user_projects'];
        console.log(userProjects);

        let res2 = userProjects.filter((item) => {
            return item.project_id == projectId;
        });

        let projectBagHourAvailable = res2[0]['bag_hour'];

        if (projectBagHourAvailable) {

            let formGroup6 = document.createElement("div");
            formGroup6.setAttribute('class', 'form-group');
            formGroup6.setAttribute('id', 'inputedHoursContainer' + containerId);

            let strongImputedHours = document.createElement("strong");
            strongImputedHours.innerText = "*{{ __('message.inputed_hours') }}: ";
            formGroup6.appendChild(strongImputedHours);

            let imputedHoursHtml = document.createElement("input");
            imputedHoursHtml.setAttribute('type', 'number');
            imputedHoursHtml.setAttribute('name', 'inputed_hours[]');
            imputedHoursHtml.setAttribute('oninput', 'createCountOfHours()');

            if (document.getElementById('inputedHoursContainer' + containerId) != null) {
                document.getElementById('inputedHoursContainer' + containerId).remove();
            }

            formGroup6.appendChild(imputedHoursHtml);
            document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup6);

        } else {
            if (document.getElementById('inputedHoursContainer' + containerId) != null) {
                document.getElementById('inputedHoursContainer' + containerId).remove();
            }
        }

        showDescription(containerId);
    }

    function showProjectsOfUserAndCustomer(containerId) {
        let formGroup5 = document.createElement("div");
        formGroup5.setAttribute('class', 'form-group');
        formGroup5.setAttribute('id', 'projectContainer' + containerId);
        let strongProject = document.createElement("strong");
        strongProject.innerText = "*{{ __('message.project') }}: ";
        formGroup5.appendChild(strongProject);

        //Create the select of projects
        let projectSelectHtml = document.createElement("select");
        projectSelectHtml.name = "projects[]";
        projectSelectHtml.setAttribute('id', 'projects' + containerId);
        projectSelectHtml.setAttribute('onchange', 'showHideImputedHours(' + containerId + ')');

        let userId = document.getElementById('users' + containerId).value;
        let customerId = document.getElementById('customers' + containerId).value;
        let res = users_info.filter((item) => {
            return item.user_id == userId;
        });
        let projectsInUser = res[0]['user_projects'];

        for (project of projectsInUser) {
            if (project.customer_id == customerId) {
                let option = document.createElement("option");
                option.value = project.project_id;
                option.innerText = project.project_name;
                projectSelectHtml.appendChild(option);
            }
        }

        if (document.getElementById('projectContainer' + containerId) != null) {
            document.getElementById('projectContainer' + containerId).remove();
        }

        formGroup5.appendChild(projectSelectHtml);
        document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup5);

        showHideImputedHours(containerId);
    }

    function showCustomersOfUser(containerId) {
        let formGroup4 = document.createElement("div");
        formGroup4.setAttribute('class', 'form-group');
        formGroup4.setAttribute('id', 'customerContainer' + containerId);
        let strongCustomer = document.createElement("strong");
        strongCustomer.innerText = "*{{ __('message.customer') }}: ";
        formGroup4.appendChild(strongCustomer);

        //Create the select of customers
        let customerSelectHtml = document.createElement("select");
        customerSelectHtml.name = "customers[]";
        customerSelectHtml.setAttribute('id', 'customers' + containerId);
        customerSelectHtml.setAttribute('onchange', 'showProjectsOfUserAndCustomer(' + containerId + ')');

        let userId = document.getElementById('users' + containerId).value;
        let res = users_customers.filter((item) => {
            return item.user_id == userId;
        });
        let customersInUser = res[0]['customers'];

        for (customer of customersInUser) {
            let option = document.createElement("option");
            option.value = customer.customer_id;
            option.innerText = customer.customer_name;
            customerSelectHtml.appendChild(option);
        }

        if (document.getElementById('customerContainer' + containerId) != null) {
            document.getElementById('customerContainer' + containerId).remove();
        }

        formGroup4.appendChild(customerSelectHtml);
        document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup4);

        showProjectsOfUserAndCustomer(containerId)
    }

    function removeEntry(containerId) {
        document.getElementById("timeEntryContainer" + containerId).remove();

        createCountOfHours(countActiveEntries);
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
        formGroup2.setAttribute('oninput', 'createCountOfHours()');
        let strongHours = document.createElement("strong");
        strongHours.innerText = "*{{ __('message.hours') }}: ";
        formGroup2.appendChild(strongHours);
        let inputHours = document.createElement("input");
        inputHours.setAttribute('name', 'hours[]');
        inputHours.setAttribute('type', 'number');

        formGroup2.appendChild(inputHours);
        entryContainerHtml.appendChild(formGroup2);

        //Select users
        let formGroup3 = document.createElement("div");
        formGroup3.setAttribute('class', 'form-group');
        let strongUser = document.createElement("strong");
        strongUser.innerText = "*{{ __('message.user') }}: ";
        formGroup3.appendChild(strongUser);

        let userSelectHtml = document.createElement("select");
        userSelectHtml.setAttribute('id', 'users' + countEntries);
        userSelectHtml.setAttribute('name', 'users[]');
        userSelectHtml.setAttribute('onchange', 'showCustomersOfUser(' + countEntries + ')');
        if (users_customers.length > 0) {
            for (user of users_customers) {
                let option = document.createElement("option");
                option.value = user.user_id;
                option.innerText = user.user_nickname;
                userSelectHtml.appendChild(option);
            }
        }

        formGroup3.appendChild(userSelectHtml);
        entryContainerHtml.appendChild(formGroup3);

        if (containerId == 1) {
            document.getElementById('timeEntriesForm').appendChild(entryContainerHtml);
            document.getElementById('timeEntryContainer1').getElementsByTagName('div')[0].getElementsByTagName('a')[1].setAttribute('class', "btn btn-outline-danger btn-sm disabled");
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
        
        createCountOfHours();

    }

    addEntry(1);

</script>
@endsection

