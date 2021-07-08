@extends('layout')

@section('title', 'Login - Home')

@section('nav_and_content')

@if ($message = Session::get('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ ($values_before_edit_json == null) ? __('message.add_new')." ".__('message.time_entry') : __('message.edit')." ".__('message.time_entry') }}</h2>
        </div>
    </div>
</div>

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

<div class="mt-2 pt-1" id="timeEntriesFormContainer">
    <strong class="ml-2">{{__('message.fields_are_required')}}</strong>
    <form action="{{ ($values_before_edit_json == null) ? route('entry_hours.store', $lang) : route('hours_entry.update',[$values_before_edit_json['hour_entry_id'], $lang]) }}" method="POST" id="timeEntriesForm">
        @csrf

    </form>
</div>

<div id="filterDiv" class="p-4 my-3">
    <div class="mb-4">
        <div class="d-flex align-content-stretch align-items-center" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <h3 class="d-inline-block m-0">Filtre</h3><i class=" px-2 bi bi-chevron-down fa-lg"></i>
        </div>
    </div>
    <div  class="collapse" id="collapseExample">

        <form action="{{ route($lang.'_entry_hours.index') }}" method="GET"> 
            @csrf
            <div class="d-flex" id="inputsContainer">
                <div class="form-group" id="formGroupFilterCustomer">
                    <label for="selectFilterCustomers">{{__('message.customer')}}</label>
                    <select id="selectFilterCustomers" name="select_filter_customer" class="form-control" onchange="filterShowProjectsOfUserAndCustomer()">
                        @forelse ($user_customers_data as $value)
                        <option value="{{ $value->customer_id }}">
                            {{ $value->customer_name }}
                        </option>
                        @empty
                        <li>{{__('message.no')}} {{__('message.customers')}} {{__('message.to_show')}}</li>
                        @endforelse
                    </select>
                </div>
            </div>

            <div class="form-group d-flex justify-content-end mb-0">
                <a href="{{ route('hours_entry.delete_filters', [$lang]) }}" class="btn general_button mr-0 mb-2">{{ __('message.delete_all_filters') }}</a>
                <button type="submit" class="btn general_button mr-0 mb-2">{{ __('message.filter') }}</button>
            </div>
        </form>

    </div>


</div>

<h3 class="mt-5">Llistat d'hores</h3>
<table class="table mt-3">
    @if (count($data) > 0)
    <thead>
        <tr>   
            <th>{{ __('message.date') }}</th>  
            <th>{{ __('message.project') }}</th>
            <th>{{ __('message.customer_name') }}</th>
            <th>{{ __('message.bag_hour') }}</th>
            <th>{{ __('message.dedicated_hours') }}</th>
            <th>{{ __('message.imputed_hours') }}</th>
            <th>{{ __('message.created_at') }}</th>
            <th>{{ __('message.validated') }}</th>
            <th></th>
        </tr>
    </thead>
    @endif
    <tbody>
        @forelse ($data as $value)

        <tr>

            <td class="align-middle">{{ Carbon\Carbon::parse($value->hours_entry_day)->format('d/m/y') }}</td>
            <td class="align-middle">{{ $value->project_name }} </td>
            <td class="align-middle">{{ $value->customer_name }}</td>
            <td class="align-middle">{{ $value->type_bag_hour_name }}</td>
            <td class="align-middle">{{ $value->hour_entry_hours }}h</td>
            <td class="align-middle">{{ $value->hour_entry_hours_imputed }}h</td>
            <td class="align-middle">{{ Carbon\Carbon::parse($value->hour_entry_created_at)->format('d/m/y') }}</td>
            <td class="align-middle">
                <div class="validate_btns_container d-flex align-items-stretch justify-content-around">
                    @if($value->hour_entry_validate == '1')
                    <div class="d-flex align-items-stretch justify-content-center text-success">
                        <i class="bi bi-check-square-fill validate_icon"></i>
                    </div>         
                    @endif
                </div>
            </td>

            <td class="align-middle">
                <div class="validate_btns_container d-flex align-items-stretch justify-content-around">


                    @php
                    $form_id = "editForm".$value->hours_entry_id;
                    $form_dom = "document.getElementById('editForm".$value->hours_entry_id."').submit();";
                    @endphp

                    <form action="{{ route($lang.'_entry_hours.index') }}" method="GET" class="invisible" id="{{ $form_id }}"> 
                        @csrf
                        <input type="hidden" name="entry_hour_id" value="{{ $value->hours_entry_id }}">
                    </form>

                    <a style="text-decoration: none" class="text-dark">
                        <i onclick="{{ $form_dom }}" class="bi bi-pencil-fill fa-lg"></i>
                    </a>


                    @php
                    $id = "exampleModal".$value->hours_entry_id;
                    @endphp

                    <a href="#{{$id}}" data-toggle="modal" data-target="#{{$id}}" style="text-decoration: none" class="text-dark">
                        <i class="bi bi-trash-fill fa-lg"></i>
                    </a>

                    <!-- Modal -->
                    <div class="modal fade" id="{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <form action="{{ route('hours_entry.destroy',[$value->hours_entry_id, $lang]) }}" method="POST"> 
                            @csrf
                            @method('DELETE')  

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('message.delete') }} {{ $value->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ __('message.confirm') }} {{ __('message.delete') }} {{ __('message.the') }} {{ __("message.hour_entry") }} <b>{{ $value->name }}</b>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('message.close') }}</button>
                                        <button type="submit" class="btn btn-success">{{ __('message.delete') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>   
                </div>
            </td>
        </tr>

        @empty
    <li>{{__('message.no')}} {{__('message.time_entries')}} {{__('message.to_show')}}</li>
    @endforelse
</tbody>
</table> 
@if (count($data) > 0)

<form action="{{ route('hours_entry.change_num_records', $lang) }}" method="GET"> 
    @csrf
    <div class="form-group">
        <strong>{{ __('message.number_of_records') }}: </strong>
        <select name="num_records" id="numRecords" onchange="this.form.submit()">
            <option value="10">10</option>
            <option value="50" @if(session('hour_entry_worker_num_records') == 50){{'selected'}}@endif>50</option>
            <option value="100" @if(session('hour_entry_worker_num_records') == 100){{'selected'}}@endif>100</option>
            <option value="all" @if(session('hour_entry_worker_num_records') == 'all'){{'selected'}}@endif>{{ __('message.all') }}</option>
        </select>
    </div>
</form>

@endif

<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@stop

@section('js')
<script>
//Efect in alert when edit and save customer
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
    var json_data = @json($json_data);

    function createCountOfHours() {

        if (document.getElementById('totalCount') != null) {
            document.getElementById('totalCount').remove();
        }

        let totalCountHtml = document.createElement("div");
        totalCountHtml.setAttribute('id', 'totalCount');
        totalCountHtml.setAttribute('onchange', 'createCountOfHours()');
        totalCountHtml.setAttribute('class', 'mt-3');

        let strongTotalcount = document.createElement("strong");
        strongTotalcount.setAttribute('class', 'ml-2');
        strongTotalcount.innerText = "{{ __('message.hour_count') }}: ";

        let totalCount = 0;
        for (let i = 0; i < document.getElementsByName('hours[]').length; i++) {
            if (document.getElementsByName('inputed_hours[]')[i] == null) {
                if (Number.isInteger(parseInt(document.getElementsByName('hours[]')[i].value))) {
                    totalCount += parseInt(document.getElementsByName('hours[]')[i].value);
                }
            } else {
                if (Number.isInteger(parseInt(document.getElementsByName('inputed_hours[]')[i].value))) {
                    totalCount += parseInt(document.getElementsByName('inputed_hours[]')[i].value);
                }
            }
        }

        strongTotalcount.innerText += totalCount + "h";

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
        let inputDesc = document.createElement("textarea");
        inputDesc.setAttribute('name', 'desc[]');
        inputDesc.setAttribute('id', 'desc' + containerId);
        inputDesc.setAttribute('placeholder', "{{ __('message.task_description') }}");
        inputDesc.setAttribute('class', "form-control");

        if (old_data.length != 0 && !loadFinish && old_data.old_desc[old_data_index] != null) {
            inputDesc.innerText = old_data.old_desc[old_data_index];
        } else if (values_before_edit !== null) {
            inputDesc.innerText = values_before_edit.description;
        }

        old_data_index++;

        formGroup6.appendChild(inputDesc);
        document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup6);
    }

    function showHideImputedHours(containerId) {

        let descValueBeforeRefresh = null;

//        if (document.getElementById("desc" + containerId) != null) {
//            descvalueBeforeRefresh = document.getElementById("desc" + containerId).innerText;
//        }
//        
//        console.log(descValueBeforeRefresh);

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

            if (old_data.length != 0 && !loadFinish && old_data.old_inputed_hours[old_inputed_hours_index] != null) {
                imputedHoursHtml.setAttribute('value', old_data.old_inputed_hours[old_inputed_hours_index]);
            } else if (values_before_edit !== null) {
                imputedHoursHtml.setAttribute('value', values_before_edit.hours_imputed);
            }

            old_inputed_hours_index++;

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

            if (old_data.length != 0 && project.project_id == old_data.old_projects[old_data_index])
                option.selected = true;

            if (values_before_edit === null & last_customer_and_project != null && project.project_id == last_customer_and_project.project_id && "{{ $load_old_hour_entries }}" == false)
                option.selected = true;

            if (values_before_edit !== null && project.project_id == values_before_edit.project_id) {
                option.selected = true;
            }

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

            console.log(old_data)
            if (old_data.length != 0 && customer.customer_id == old_data.old_customers[old_data_index])
                option.selected = true;

            console.log(last_customer_and_project)
            if (values_before_edit === null & last_customer_and_project != null && customer.customer_id == last_customer_and_project.customer_id && "{{ $load_old_hour_entries }}" == false)
                option.selected = true;

            console.log(values_before_edit)
            if (values_before_edit !== null && customer.customer_id == values_before_edit.customer_id) {
                option.selected = true;
            }

            customerSelectHtml.appendChild(option);
        }

        formGroup3.appendChild(customerSelectHtml);
        document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup3);

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
        } else if (values_before_edit !== null) {
            inputDay.setAttribute('value', values_before_edit.day);
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
        } else if (values_before_edit !== null) {
            inputHours.setAttribute('value', values_before_edit.hours);
        } else {
            inputHours.setAttribute('value', 8)
        }

        formGroup2.appendChild(inputHours);
        entryContainerHtml.appendChild(formGroup2);

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

        if (values_before_edit !== null) {
            let cancelHtml = document.createElement("a");
            cancelHtml.innerText = "{{ __('message.cancel') }}";
            cancelHtml.setAttribute('class', 'btn general_button mr-0');
            cancelHtml.setAttribute('href', '{{ route("hours_entry.cancel_edit", $lang) }}');
            buttonContainer.appendChild(cancelHtml);

        }

        let submitHtml = document.createElement("button");
        submitHtml.innerText = "{{ __('message.save') }}";
        submitHtml.setAttribute('type', 'submit');
        submitHtml.setAttribute('class', 'btn general_button');
        buttonContainer.appendChild(submitHtml);

        document.getElementById('timeEntriesForm').appendChild(buttonContainer);

        //Create total count of hours
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

        let customerId = document.getElementById('selectFilterCustomers').value;

        for (project of users_projects_with_customer) {
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

    var last_customer_and_project = @json($last_customer_and_project);

    var old_data = @json($old_data);

    var old_data_index = 0;
    var old_inputed_hours_index = 0;

    var loadFinish = false;

    var values_before_edit = @json($values_before_edit_json);

    if ("{{ $load_old_hour_entries }}") {
        let numEntries = parseInt("{{ session('count_hours_entries_user') }}");

        for (let i = 1; i <= numEntries; i++) {
            addEntry(i);
        }

        loadFinish = true;
    } else {
        addEntry(1);
    }

    //Filters principal program
    var users_projects_with_customer = @json($users_projects_with_customer);

    filterShowProjectsOfUserAndCustomer();



</script>

@endsection
