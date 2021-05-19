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
        <select name="users" id="numRecords">
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
        
    </div>
</div>
@endsection


@section('js')
<script type="text/javascript">

    function onChangeUser(users_info) {
        
        //Create the select of projects
        let projectSelectHtml = document.createElement("select");
        projectSelectHtml.name = "projects";
        
        //Get the projects of the users from the json
        let userId = document.getElementsByName('users')[0].value; 
        let res = users_info.filter((item) => {
            return item.id == userId;
        });

        let projectsInUser = res[0]['projects'];
        
        /*if(projectsInUser.length > 0){
            for (projectsInUser of project){
                let option = document.createElement("option");
                option.value = project.id;
                console.log(option);
            }
        }*/
        
        console.log(projectsInUser);
    }

    window.onload = function () {
        
        //Get the object from json
        var users_info = @json($users_info);
                console.log(users_info[0]);

        //Listener for onchange user
        document.getElementsByName('users')[0].addEventListener("change", function(){
            onChangeUser(users_info);
        });
        
        //Charge the projects on load page
        onChangeUser(users_info);

    }
</script>
@endsection
