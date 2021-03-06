@extends('layout')

@section('title')
{{ __("message.control_panel") }} - {{ __("message.projects") }} - {{ __("message.add_remove_users") }} - {{ $project->name}} ({{$customer->name}})
@endsection


@section('content')
@if ($message = Session::get('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('message.add_remove_users')}} {{ __('message.to_project')}} {{ $project->name}} ({{$customer->name}})</h2>
        </div>
    </div>
</div>

<div class="row mt-2 pl-2">

    <div class="col-12 margin-tb pull-left">
        <h3>{{ __('message.users') }} {{ __('message.working_in_project') }} {{ $project->name}}:</h3>
    </div>
    <div class="col-12 margin-tb pull-left">
    @if (count($users_in_project) > 0)
    <ul class="list-group">
        @foreach($users_in_project as $user)

        <li name="user_id" class="list-group-item list-group-item-info">
            <form action="{{ route('projects.remove_user', [$project->id, $lang]) }}" method="POST" class="d-flex justify-content-between mb-0"> 
                @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                {{$user->nickname}} -> @if ($user->role == 'admin'){{__('message.admin')}} @else{{__('message.worker')}} @endif -> {{__('message.name')}}: {{ $user->name }} {{ $user->surname }}. {{__('message.email')}}: {{$user->email}}. @if (isset($user->phone)) {{__('message.phone')}}: {{$user->phone}}@endif
                <button type="submit" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </button>
            </form>
        </li>

        @endforeach
    </ul>
    @else
    <li>{{ __('message.no_users_assigned_to_project') }} {{ $project->name}}</li>
    @endif
    </div>

    <div class="col-12 margin-tb pull-left mt-4">
        <h3>{{ __('message.assign') }} {{ __('message.users') }} {{ __('message.to_a') }} {{ $project->name}}:</h3>
    </div>
    @if (count($users_not_in_project) > 0)
    <form action="{{ route('projects.add_user', [$project->id, $lang]) }}" method="POST" class="col-12">
        @csrf
        <select name="user" class="form-control form-select">
            @foreach($users_not_in_project as $user)
            <option value="{{$user->id}}|{{$user->nickname}}">{{$user->nickname}} -> @if ($user->role == 'admin'){{__('message.admin')}} @else{{__('message.worker')}} @endif -> {{__('message.name')}}: {{ $user->name }} {{ $user->surname }}. {{__('message.email')}}: {{$user->email}}. @if (isset($user->phone)) {{__('message.phone')}}: {{$user->phone}}@endif</option>
            @endforeach
        </select>

        <button type="submit" class="btn general_button ml-0 text-uppercase">{{ __('message.assign') }}</button>

    </form>
    @else
    <li>{{ __('message.no_users_available') }}</li>
    @endif
 


</div>

@endsection
@section('js')
<script type="text/javascript" src="{{ URL::asset('js/projects_add_remove_users.js') }}"></script>
@endsection