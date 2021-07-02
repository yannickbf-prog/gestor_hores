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

@php
$load_old_hour_entries = false;
@endphp

@if ($errors->any())
<div class="alert alert-danger mt-3">
    <strong>{{__('message.woops!')}}</strong> {{__('message.input_problems')}}<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@php
$load_old_hour_entries = true;
@endphp
@endif

<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('message.time_entries') }}</h2>
        </div>
    </div>
</div>
<div class="mt-2 pt-1" id="timeEntriesFormContainer">
    <strong class="ml-2">{{__('message.fields_are_required')}}</strong>
    <form action="{{ route('time_entries.store',$lang) }}" method="POST" id="timeEntriesForm">
        @csrf

    </form>
</div>

<div id="filterDiv" class="p-4 mb-2">
    <div class="mb-4">
        <div class="d-flex align-content-stretch align-items-center" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <h3 class="d-inline-block m-0">Filtre</h3><i class=" px-2 bi bi-chevron-down fa-lg"></i>
        </div>
    </div>
    <div  class="collapse" id="collapseExample">
        <form action="{{ route($lang.'_time_entries.index') }}" method="GET"> 
            @csrf
            <div class="d-flex" id="inputsContainer">
                <div class="form-group" id="formGroupFilterName">
                    <label for="selectFilterName">*Cognoms, Nom: </label>
                    <select id="selectFilterName" name="select_filter_name" class="form-control" onchange="filterShowCustomersOfUser()">
                        @forelse ($users_with_projects as $value)
                        <option value="{{ $value->id }}">
                            {{ $value->name." ".$value->surname }}
                        </option>
                        @empty
                        <li>{{__('message.no')}} {{__('message.users')}} {{__('message.to_show')}}</li>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="form-group d-flex justify-content-end mb-0">
                <button type="submit" class="btn general_button mr-0 mb-2">{{ __('message.filter') }}</button>
            </div>
        </form>
        <form action="{{ route('entry_hours.delete_filters') }}" method="POST"> 
            @csrf
            <input type="hidden" name="lang" value="{{ $lang }}">
            <button type="submit" class="btn general_button mr-0 mb-2">{{ __('message.delete_all_filters') }}</button>
        </form>
    </div>


</div>

<table class="table">
    @if (count($data) > 0)
    <tr>   
        <th>{{ __('message.date') }}</th>  
        <th>{{ __('message.worker_name') }}</th>
        <th>{{ __('message.username') }}</th>
        <th>{{ __('message.project') }}</th>
        <th>{{ __('message.customer_name') }}</th>
        <th>{{ __('message.bag_hour') }}</th>
        <th>{{ __('message.dedicated_hours') }}</th>
        <th>{{ __('message.imputed_hours') }}</th>
        <th>{{ __('message.created_at') }}</th>
        <th></th>
    </tr>
    @endif
    @forelse ($data as $value)
    <tr>

        <td>{{ Carbon\Carbon::parse($value->hours_entry_day)->format('d/m/y') }}</td>
        <td>{{ $value->user_name." ".$value->user_surname }}</td>
        <td>{{ $value->user_nickname }}</td>
        <td>{{ $value->project_name }} </td>
        <td>{{ $value->customer_name }}</td>
        <td>{{ $value->type_bag_hour_name }}</td>
        <td>{{ $value->hour_entry_hours }}h</td>
        <td>{{ $value->hour_entry_hours_imputed }}h</td>
        <td>{{ Carbon\Carbon::parse($value->hour_entry_created_at)->format('d/m/y') }}</td>

        <td>
            @if($value->hour_entry_validate == '0')
            <div class="validate_btns_container">

                <a href="{{ route('entry_hours.validate',[$value->hours_entry_id, $lang]) }}"  style="text-decoration: none" class="text-success">
                    <i class="bi bi-check-square-fill fa-lg"></i>
                </a>

            </div>
            @endif
        </td>
    </tr>

    @empty
    <li>{{__('message.no')}} {{__('message.time_entries')}} {{__('message.to_show')}}</li>
    @endforelse

</table> 
@if (count($data) > 0)
<a class="btn general_button" href="{{ route('entry_hours.validate_all', $lang) }}">{{ __('message.validate_all_hours') }}</a>
@endif
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection
@section('js')
<script src="https://kit.fontawesome.com/ad4ed42faf.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ URL::asset('./dom-slider-master/dist/dom-slider.js') }}"></script>

<script>

                    $('#collapseExample').on('show.bs.collapse', function () {
                        $('.bi-chevron-down').css("transform", "rotate(180deg)");
                    })

                    $('#collapseExample').on('hide.bs.collapse', function () {
                        $('.bi-chevron-down').css("transform", "rotate(0deg)");
                    })

                    $(".alert-success").slideDown(400);

                    $(".alert-success").delay(6000).slideUp(400, function () {
                        $(this).alert('close');
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


//Get the object from json
                    var users_info = @json($users_info);
                            var users_customers = @json($users_customers);


                    function createCountOfHours() {

                        let totalCountHtml = document.createElement("div");
                        totalCountHtml.setAttribute('id', 'totalCount');
                        totalCountHtml.setAttribute('class', ' mt-3');
                        totalCountHtml.setAttribute('onchange', 'createCountOfHours()');

                        let strongTotalcount = document.createElement("strong");
                        strongTotalcount.setAttribute('class', 'ml-2');
                        strongTotalcount.innerText = "{{ __('message.hour_count') }}: ";

                        let totalCount = 0;
                        for (let i = 0; i < document.getElementsByClassName('time_entry_container').length; i++) {

                            if (document.getElementsByClassName('time_entry_container')[i].getElementsByClassName('inputed_hours')[0] == null) {
                                if (Number.isInteger(parseInt(document.getElementsByClassName('time_entry_container')[i].getElementsByClassName('hours')[0].value))) {
                                    totalCount += parseInt(document.getElementsByClassName('time_entry_container')[i].getElementsByClassName('hours')[0].value);
                                }
                            } else {
                                if (Number.isInteger(parseInt(document.getElementsByClassName('time_entry_container')[i].getElementsByClassName('inputed_hours')[0].value))) {
                                    totalCount += parseInt(document.getElementsByClassName('time_entry_container')[i].getElementsByClassName('inputed_hours')[0].value);
                                }
                            }
                        }

                        strongTotalcount.innerText += totalCount + "h";

                        totalCountHtml.appendChild(strongTotalcount);

                        if (document.getElementById('totalCount') == null) {
                            document.getElementById('timeEntriesForm').lastChild.appendChild(totalCountHtml);
                        } else {
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
                        formGroup7.setAttribute('class', 'form-group form_group_7');
                        formGroup7.setAttribute('id', 'descContainer' + containerId);
                        let labelDesc = document.createElement("label");
                        labelDesc.innerText = "*{{ __('message.task_description') }}: ";
                        labelDesc.setAttribute('for', 'desc' + containerId);
                        formGroup7.appendChild(labelDesc);
                        let inputDesc = document.createElement("textarea");
                        inputDesc.setAttribute('name', 'desc[]');
                        inputDesc.setAttribute('id', 'desc' + containerId);
                        inputDesc.setAttribute('placeholder', "{{ __('message.task_description') }}");
                        inputDesc.setAttribute('class', "form-control");

                        if (old_data.length != 0 && !loadFinish && old_data.old_desc[old_data_index] != null) {
                            inputDesc.innerHTML = old_data.old_desc[old_data_index];
                        }
                        old_data_index++;

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

                        let res2 = userProjects.filter((item) => {
                            return item.project_id == projectId;
                        });

                        let projectBagHourAvailable = res2[0]['bag_hour'];

                        if (projectBagHourAvailable) {

                            let formGroup6 = document.createElement("div");
                            formGroup6.setAttribute('class', 'form-group form_group_6');
                            formGroup6.setAttribute('id', 'inputedHoursContainer' + containerId);

                            let labelImputedHours = document.createElement("label");
                            labelImputedHours.innerText = "*{{ __('message.inputed_hours') }}: ";
                            labelImputedHours.setAttribute('for', 'inputedHours' + containerId);
                            formGroup6.appendChild(labelImputedHours);

                            let imputedHoursHtml = document.createElement("input");
                            imputedHoursHtml.setAttribute('type', 'number');
                            imputedHoursHtml.setAttribute('name', 'inputed_hours[]');
                            imputedHoursHtml.setAttribute('class', 'inputed_hours form-control');

                            imputedHoursHtml.setAttribute('placeholder', "{{ __('message.inputed_hours') }}");
                            imputedHoursHtml.setAttribute('oninput', 'createCountOfHours()');
                            imputedHoursHtml.setAttribute('id', 'inputedHours' + containerId);
                            imputedHoursHtml.setAttribute('id', 'inputedHours' + containerId);

                            if (old_data.length != 0 && !loadFinish && old_data.old_inputed_hours[old_inputed_hours_index] != null) {
                                imputedHoursHtml.setAttribute('value', old_data.old_inputed_hours[old_inputed_hours_index]);
                            }

                            old_inputed_hours_index++;

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
                        formGroup5.setAttribute('class', 'form-group form_group_5');
                        formGroup5.setAttribute('id', 'projectContainer' + containerId);
                        let labelProject = document.createElement("label");
                        labelProject.setAttribute('for', 'projects' + containerId);
                        labelProject.innerText = "*{{ __('message.project') }}: ";
                        formGroup5.appendChild(labelProject);

                        //Create the select of projects
                        let projectSelectHtml = document.createElement("select");
                        projectSelectHtml.name = "projects[]";
                        projectSelectHtml.setAttribute('id', 'projects' + containerId);
                        projectSelectHtml.setAttribute('onchange', 'showHideImputedHours(' + containerId + ')');
                        projectSelectHtml.setAttribute('class', 'form-control');

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
                                if (old_data.length != 0 && project.project_id == old_data.old_projects[old_data_index])
                                    option.selected = true;
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
                        formGroup4.setAttribute('class', 'form-group form_group_4');
                        formGroup4.setAttribute('id', 'customerContainer' + containerId);
                        let labelCustomer = document.createElement("label");
                        labelCustomer.innerText = "*{{ __('message.customer') }}: ";
                        labelCustomer.setAttribute('for', 'customers' + containerId);
                        formGroup4.appendChild(labelCustomer);


                        //Create the select of customers
                        let customerSelectHtml = document.createElement("select");
                        customerSelectHtml.name = "customers[]";
                        customerSelectHtml.setAttribute('id', 'customers' + containerId);
                        customerSelectHtml.setAttribute('onchange', 'showProjectsOfUserAndCustomer(' + containerId + ')');
                        customerSelectHtml.setAttribute('class', 'form-control');

                        let userId = document.getElementById('users' + containerId).value;
                        let res = users_customers.filter((item) => {
                            return item.user_id == userId;
                        });
                        let customersInUser = res[0]['customers'];

                        for (customer of customersInUser) {
                            let option = document.createElement("option");
                            option.value = customer.customer_id;
                            option.innerText = customer.customer_name;
                            if (old_data.length != 0 && customer.customer_id == old_data.old_customers[old_data_index])
                                option.selected = true;
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

                        $('#timeEntryContainer' + containerId).on('hidden.bs.collapse', function () {
                            document.getElementById("timeEntryContainer" + containerId).remove();
                            createCountOfHours();
                        })

                        $('#timeEntryContainer' + containerId).collapse('hide');

                    }

                    var countEntries = 0;
                    function addEntry(containerId) {

                        countEntries++;

                        let entryContainerHtml = document.createElement("div");
                        entryContainerHtml.setAttribute('id', 'timeEntryContainer' + countEntries);
                        entryContainerHtml.setAttribute('class', 'time_entry_container d-flex flex-wrap mt-4');

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

                        if (old_data.length != 0 && !loadFinish && old_data.old_days[old_data_index] != null) {
                            inputDay.setAttribute('value', old_data.old_days[old_data_index]);
                        } else {
                            inputDay.setAttribute('value', "{{ now()->format('d/m/Y') }}");
                        }

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

                        if (old_data.length != 0 && !loadFinish && old_data.old_hours[old_data_index] != null) {
                            inputHours.setAttribute('value', old_data.old_hours[old_data_index]);
                        } else {
                            inputHours.setAttribute('value', 8)
                        }

                        formGroup2.appendChild(inputHours);
                        entryContainerHtml.appendChild(formGroup2);

                        //Select users
                        let formGroup3 = document.createElement("div");
                        formGroup3.setAttribute('class', 'form-group form_group_3');
                        let labelUser = document.createElement("label");
                        labelUser.setAttribute('for', 'users' + countEntries);
                        labelUser.innerText = "*{{ __('message.user') }}: ";
                        formGroup3.appendChild(labelUser);

                        let userSelectHtml = document.createElement("select");
                        userSelectHtml.setAttribute('id', 'users' + countEntries);
                        userSelectHtml.setAttribute('name', 'users[]');
                        userSelectHtml.setAttribute('onchange', 'showCustomersOfUser(' + countEntries + ')');
                        userSelectHtml.setAttribute('class', 'form-control');
                        if (users_customers.length > 0) {
                            for (user of users_customers) {
                                let option = document.createElement("option");
                                option.value = user.user_id;
                                option.innerText = user.user_nickname;
                                if (old_data.length != 0 && user.user_id == old_data.old_users[old_data_index])
                                    option.selected = true;
                                userSelectHtml.appendChild(option);
                            }
                        }

                        formGroup3.appendChild(userSelectHtml);
                        entryContainerHtml.appendChild(formGroup3);

                        if (containerId == 1 && countEntries == 1) {
                            document.getElementById('timeEntriesForm').appendChild(entryContainerHtml);
                            document.getElementById('timeEntryContainer1').getElementsByTagName('div')[0].getElementsByTagName('a')[1].setAttribute('class', "btn disabled btn-remove");
                        } else {
                            if ("{{ $load_old_hour_entries }}" && !loadFinish) {
                                document.getElementById('timeEntryContainer' + (containerId - 1)).after(entryContainerHtml);
                            } else {
                                document.getElementById('timeEntryContainer' + containerId).after(entryContainerHtml);
                            }
                        }

                        showCustomersOfUser(countEntries);

                        //Create submit button
                        if (document.getElementById("submitContainer") != null)
                            document.getElementById("submitContainer").remove();
                        let buttonContainer = document.createElement("div");
                        buttonContainer.setAttribute('class', 'form-group d-flex justify-content-end');
                        buttonContainer.setAttribute('id', 'submitContainer');
                        let submitHtml = document.createElement("button");
                        submitHtml.innerText = "{{ __('message.save') }}";
                        submitHtml.setAttribute('type', 'submit');
                        submitHtml.setAttribute('class', 'btn general_button');
                        buttonContainer.appendChild(submitHtml);

                        document.getElementById('timeEntriesForm').appendChild(buttonContainer);

                        createCountOfHours();

                        if (countEntries != 1) {
                            $('#timeEntryContainer' + countEntries).collapse();
                        }
                    }

//Filter section functions

                    function filterShowProjectsOfUserAndCustomer() {

                        let formGroup = document.createElement("div");
                        formGroup.setAttribute('class', 'form-group');
                        formGroup.setAttribute('id', 'formGroupFilterProjects');

                        let labelProject = document.createElement("label");
                        labelProject.setAttribute('for', 'selectFilterProjects');
                        labelProject.innerText = "*{{ __('message.project') }}: ";
                        formGroup.appendChild(labelProject);

                        //Create the select of projects
                        let projectSelectHtml = document.createElement("select");
                        projectSelectHtml.name = "select_filter_projects";
                        projectSelectHtml.setAttribute('id', 'selectFilterProjects');
                        projectSelectHtml.setAttribute('class', 'form-control');

                        let userId = document.getElementById('selectFilterName').value;
                        let customerId = document.getElementById('selectFilterCustomers').value;
                        let res = users_info.filter((item) => {
                            return item.user_id == userId;
                        });
                        let projectsInUser = res[0]['user_projects'];

                        for (project of projectsInUser) {
                            if (project.customer_id == customerId) {
                                let option = document.createElement("option");
                                option.value = project.project_id;
                                option.innerText = project.project_name;
                                if (old_data.length != 0 && project.project_id == old_data.old_projects[old_data_index])
                                    option.selected = true;
                                projectSelectHtml.appendChild(option);
                            }
                        }

                        if (document.getElementById('formGroupFilterProjects') != null) {
                            document.getElementById('formGroupFilterProjects').remove();
                        }

                        formGroup.appendChild(projectSelectHtml);
                        document.getElementById('inputsContainer').appendChild(formGroup);

                    }

                    function filterShowCustomersOfUser() {


                        let formGroup = document.createElement("div");
                        formGroup.setAttribute('class', 'form-group');
                        formGroup.setAttribute('id', 'formGroupFilterCustomers');

                        let labelCustomer = document.createElement("label");
                        labelCustomer.innerText = "*{{ __('message.customer') }}: ";
                        labelCustomer.setAttribute('for', 'selectFilterCustomers');
                        formGroup.appendChild(labelCustomer);

                        //Create the select of customers
                        let customerSelectHtml = document.createElement("select");
                        customerSelectHtml.name = "select_filter_customers";
                        customerSelectHtml.setAttribute('id', 'selectFilterCustomers');
                        customerSelectHtml.setAttribute('class', 'form-control');
                        customerSelectHtml.setAttribute('onchange', 'filterShowProjectsOfUserAndCustomer()');

                        let userId = document.getElementById('selectFilterName').value;

                        let res = users_customers.filter((item) => {
                            return item.user_id == userId;
                        });
                        let customersInUser = res[0]['customers'];

                        for (customer of customersInUser) {
                            let option = document.createElement("option");
                            option.value = customer.customer_id;
                            option.innerText = customer.customer_name;
                            if (old_data.length != 0 && customer.customer_id == old_data.old_customers[old_data_index])
                                option.selected = true;
                            customerSelectHtml.appendChild(option);
                        }

                        if (document.getElementById('formGroupFilterCustomers') != null) {
                            document.getElementById('formGroupFilterCustomers').remove();
                        }

                        formGroup.appendChild(customerSelectHtml);

                        document.getElementById("inputsContainer").appendChild(formGroup);

                        filterShowProjectsOfUserAndCustomer();
                    }


                    var old_data = @json($old_data);

                    var old_data_index = 0;
                    var old_inputed_hours_index = 0;

                    var loadFinish = false;

                    if ("{{ $load_old_hour_entries }}") {
                        let numEntries = parseInt("{{ session('count_hours_entries') }}");

                        for (let i = 1; i <= numEntries; i++) {
                            addEntry(i);
                        }

                        loadFinish = true;
                    } else {
                        addEntry(1);
                    }

//Filters principal program
                    filterShowCustomersOfUser();

</script>
@endsection

