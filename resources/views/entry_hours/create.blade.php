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

<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <strong>*{{ __('message.user') }}: </strong>
        @if (count($users_data) > 0)
        <select name="users">
            @foreach($users_data as $user)
            <option value="{{ $user->id }}">{{$user->nickname}} -> @if ($user->role == 'admin'){{__('message.admin')}} @else{{__('message.worker')}} @endif -> {{__('message.name')}}: {{ $user->name }} {{ $user->surname }}. {{__('message.email')}}: {{$user->email}}. @if (isset($user->phone)) {{__('message.phone')}}: {{$user->phone}}@endif</option>
            @endforeach
        </select>
        @else
        <li>{{ __('message.no') }} {{ __('message.users') }} {{ __('message.avalible') }} {{ __('message.create_user') }}</li>
        @endif
        <a href="{{ route($lang."_users.create") }}" type="button" class="btn btn-primary btn-sm">{{ __('message.create') }} {{ __('message.user') }}</a>
    </div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group" id="projectSelectContainer">
        <strong>*{{ __('message.projects') }}: </strong>
        <select name="projects" onchange="onChangeProject()">

        </select>
        <a href="{{ route($lang."_projects.create") }}" type="button" class="btn btn-primary btn-sm">{{ __('message.create') }} {{ __('message.project') }}</a>
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group" id="bagHourSelectContainer">
        <strong>*{{ __('message.bags_of_hours') }}: </strong>
        <a href="{{ route($lang."_bag_hours.create") }}" type="button" class="btn btn-primary btn-sm">{{ __('message.create') }} {{ __('message.bag_of_hours') }}</a>
    </div>
</div>
@endsection


@section('js')
<script>
    function onChangeUser(users_info) {

        //Get the projects of the users from the json
        let userId = document.getElementsByName('users')[0].value;
        let res = users_info.filter((item) => {
            return item.id == userId;
        });

        projectsInUser = res[0]['projects'];

        console.log(projectsInUser);

        if (projectsInUser.length > 0) {
            for (project of projectsInUser) {
                let option = document.createElement("option");
                option.value = project.id;
                option.innerText = project.name + " (" + project.customer + ")";
                document.getElementsByName('projects')[0].appendChild(option)
            }
        }/*
         else{
         let option = document.createElement("option");
         option.innerText = "No projects asigned to this user";
         projectSelectHtml.disabled = true;
         document.getElementsByName('projects')[0].appendChild(option);
         }
         
         if(document.getElementsByName('projects')[0] != null){
         document.getElementById("projectSelectContainer").removeChild(document.getElementsByName('projects')[0]);
         }
         
         document.getElementById("projectSelectContainer").insertBefore(projectSelectHtml, document.getElementById("projectSelectContainer").getElementsByTagName("a")[0]);
         
         //document.getElementById("projectSelectContainer").appendChild(projectSelectHtml);
         
         console.log(projectsInUser);*/

    }

    /*function onChangeProject (users_info){
     
     
     alert("hello");
     
     
     
     
     let res = projectsInUser.filter((item) => {
     return item.id == projectId;
     });
     
     bagHoursInProject = res[0]['bag_hours'];
     
     if(bagHoursInProject.length > 0){
     for (bag_hour of bagHoursInProject){
     let option = document.createElement("option");
     option.value = bag_hour.bag_hour_id;
     option.innerText = bag_hour.bag_hour_type_name;
     bagHourSelectHtml.appendChild(option);
     }
     }
     else{
     let option = document.createElement("option");
     option.innerText = "No bag hours asigned to this project";
     bagHourSelectHtml.disabled = true;
     bagHourSelectHtml.appendChild(option);
     }
     
     if(document.getElementsByName('bag_hours')[0] != null){
     document.getElementById("bagHourSelectContainer").removeChild(document.getElementsByName('bag_hours')[0]);
     }
     
     document.getElementById("bagHourSelectContainer").insertBefore(bagHourSelectHtml, document.getElementById("bagHourSelectContainer").getElementsByTagName("a")[0]);
     
     }*/

    //Get the object from json
    var users_info = @json($users_info);
            //Charge the projects depending on users on load page
            onChangeUser(users_info);

    window.onload = function (users_info) {


        //Charge the bag hours depending on project on load page
        //onChangeProject(users_info);

        //Listener for onchange user
        document.getElementsByName('users')[0].addEventListener("change", function () {
            onChangeUser(users_info);
        });

        //Listener for onchange projects
        /*document.getElementsByName('projects')[0].addEventListener("change", function(){
         onChangeProject(users_info);
         });*/


    }
</script>
@endsection
