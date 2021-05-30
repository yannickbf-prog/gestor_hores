@extends('layout')

@section('title')
{{ __("message.control_panel") }} - {{ __('message.add_new')." ".__('message.time_entry') }}
@endsection

@section('content')
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

            }

    function showHideImputedHours(containerId, projectsInUser) {

        if (projectsInUser.length > 0) {
            let projectId = document.getElementById("projects" + containerId).value;

            let res = projectsInUser.filter((item) => {
                return item.id == projectId;
            });

            let projectBagHourAvailable = res[0]['bag_hour'];

            if (document.getElementById('inputedHoursContainer' + containerId) != null) {
                document.getElementById('inputedHoursContainer' + containerId).remove();
            }

            if (projectBagHourAvailable) {

                let formGroup4 = document.createElement("div");
                formGroup4.setAttribute('class', 'form-group');
                formGroup4.setAttribute('id', 'inputedHoursContainer' + containerId);

                let strongImputedHours = document.createElement("strong");
                strongImputedHours.innerText = "*{{ __('message.inputed_hours') }}: ";
                formGroup4.appendChild(strongImputedHours);

                let imputedHoursHtml = document.createElement("input");
                imputedHoursHtml.setAttribute('type', 'number');
                imputedHoursHtml.setAttribute('name', 'inputed_hours[]');

                formGroup4.appendChild(imputedHoursHtml);
                document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup4);
            } else {
                if (document.getElementById('inputedHoursContainer' + containerId) != null) {
                    document.getElementById('inputedHoursContainer' + containerId).remove();
                }
            }
        }
        else{
            
        }



        showDescription(containerId);
    }

    function showProjectsOfUser(containerId) {

        let formGroup4 = document.createElement("div");
        formGroup4.setAttribute('class', 'form-group');
        formGroup4.setAttribute('id', 'projectContainer' + containerId);
        let strongProject = document.createElement("strong");
        strongProject.innerText = "*{{ __('message.project') }}: ";
        formGroup4.appendChild(strongProject);

        //Create the select of projects
        let projectSelectHtml = document.createElement("select");
        projectSelectHtml.name = "projects[]";
        projectSelectHtml.setAttribute('id', 'projects' + countEntries)

        let userId = document.getElementById('users' + containerId).value;
        let res = users_info.filter((item) => {
            return item.id == userId;
        });
        let projectsInUser = res[0]['projects'];

        if (projectsInUser.length > 0) {
            for (project of projectsInUser) {
                let option = document.createElement("option");
                option.value = project.id;
                option.innerText = project.name + " (" + project.customer + ")";
                projectSelectHtml.appendChild(option);
            }
        } else {
            let option = document.createElement("option");
            option.value = "no_project";
            option.innerText = "No projects asigned to this user";
            projectSelectHtml.disabled = true;
            projectSelectHtml.appendChild(option);

            if (document.getElementById('inputedHoursContainer' + containerId) != null) {
                document.getElementById('inputedHoursContainer' + containerId).remove();
            }
        }

        if (document.getElementById('projectContainer' + containerId) != null) {
            document.getElementById('projectContainer' + containerId).remove();
        }

        formGroup4.appendChild(projectSelectHtml);
        document.getElementById('timeEntryContainer' + containerId).appendChild(formGroup4);

        showHideImputedHours(containerId, projectsInUser);


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
        inputDay.setAttribute('name', 'day[]');
        inputDay.setAttribute('id', 'dp');
        inputDay.setAttribute('onclick', "$('#dp').datepicker({dateFormat: 'dd/mm/yy'}).val();$('#dp').datepicker('show');");

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

        //Select users
        let formGroup3 = document.createElement("div");
        formGroup3.setAttribute('class', 'form-group');
        let strongUser = document.createElement("strong");
        strongUser.innerText = "*{{ __('message.user') }}: ";
        formGroup3.appendChild(strongUser);

        let userSelectHtml = document.createElement("select");
        userSelectHtml.setAttribute('id', 'users' + countEntries);
        userSelectHtml.setAttribute('name', 'users[]');
        userSelectHtml.setAttribute('onchange', 'showProjectsOfUser(' + countEntries + ')');
        if (users_info.length > 0) {
            for (user of users_info) {
                let option = document.createElement("option");
                option.value = user.id;
                option.innerText = user.nickname;
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

        showProjectsOfUser(countEntries);



    }

    addEntry(1);
    /*var projectsInUser;
     function onChangeUser(users_info) {
     
     //Create the select of projects
     let projectSelectHtml = document.createElement("select");
     projectSelectHtml.name = "projects";
     projectSelectHtml.setAttribute("onchange", "onChangeProject()");
     
     //Get the projects of the users from the json
     let userId = document.getElementsByName('users')[0].value;
     let res = users_info.filter((item) => {
     return item.id == userId;
     });
     projectsInUser = res[0]['projects'];
     
     if (projectsInUser.length > 0) {
     for (project of projectsInUser) {
     let option = document.createElement("option");
     option.value = project.id;
     option.innerText = project.name + " (" + project.customer + ")";
     projectSelectHtml.appendChild(option);
     }
     } else {
     let option = document.createElement("option");
     option.value = "no_project";
     option.innerText = "No projects asigned to this user";
     projectSelectHtml.disabled = true;
     projectSelectHtml.appendChild(option);
     }
     
     if (document.getElementsByName('projects')[0] != null) {
     document.getElementById("projectSelectContainer").removeChild(document.getElementsByName('projects')[0]);
     }
     
     document.getElementById("projectSelectContainer").insertBefore(projectSelectHtml, document.getElementById("projectSelectContainer").getElementsByTagName("a")[0]);
     
     
     }
     
     function onChangeProject() {
     
     //        let projectId = document.getElementsByName('projects')[0].value;
     //        
     //        if (projectsInUser.length > 0) {
     //            let res = projectsInUser.filter((item) => {
     //                return item.id == projectId;
     //            });
     //            let bagHourInProject = res[0]['bag_hour'];
     //            
     //            if(bagHourInProject == true){
     //                let inputedHoursContainerHtml = document.createElement("div");
     //                inputedHoursContainerHtml.id = 'inputedHoursContainer';
     //                
     //                let inputedHoursTitleHtml = document.createElement("strong");
     //                inputedHoursTitleHtml.innerText = "*{{__('message.hours_imputed')}}:";
     //                let inputedHoursInputHtml = document.createElement("input");
     //                inputedHoursInputHtml.type = "name";
     //                inputedHoursInputHtml.name = "hours_imputed";
     //                inputedHoursContainerHtml.appendChild(inputedHoursTitleHtml);
     //                inputedHoursContainerHtml.appendChild(inputedHoursInputHtml);
     //                document.getElementById("projectSelectContainer").insertBefore(projectSelectHtml, document.getElementById("projectSelectContainer").getElementsByTagName("a")[0]);
     //            }
     //        }
     //        
     
     }
     
     
     //Get the object from json
     var users_info = @json($users_info);
     //Charge the projects depending on users on load page
     onChangeUser(users_info);
     
     window.onload = function () {
     
     //Listener for onchange user
     document.getElementsByName('users')[0].addEventListener("change", function () {
     onChangeUser(users_info);
     });
     
     }
     * 
     */
</script>

@endsection
