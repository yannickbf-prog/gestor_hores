@extends('layout')

@section('title')
{{ __("message.control_panel") }} - {{ __("message.user") }} - {{ __("message.edit") }} {{ $user->nickname}}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('message.edit') }} {{__('message.user')}}: {{ $user->nickname }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route($lang.'_users.index') }}">{{__('message.back')}}</a>
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

<form action="{{ route('users.update',[$user->id, $lang]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.username')}}:</strong>
                <input type="text" name="nickname" value="{{old('nickname', $user->nickname)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.nickname')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.name')}}:</strong>
                <input type="text" name="name" value="{{old('name', $user->name)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.name')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.surname')}}:</strong>
                <input type="text" name="surname" value="{{old('surname', $user->surname)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.surname')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.email')}}:</strong>
                <input type="text" name="email" value="{{old('email', $user->email)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.email')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.phone')}}:</strong>
                <input type="text" name="phone" value="{{old('phone', $user->phone)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.phone')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('message.description')}}:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="{{__('message.enter')." ".__('message.description')}}">{{old('description', $user->description)}}</textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="alert alert-info mt-2">
                <strong>{{__('message.password_edit_info')}}</strong>
            </div>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.password')}}:</strong>
                <input type="password" id="password" name="password" autocomplete="new-password" class="form-control" placeholder="{{__('message.enter')." ".__('message.password')}}" value="{{old('password')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.password_confirm')}}:</strong>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="{{__('message.enter')." ".__('message.password')}}" value="{{old('password_confirmation')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.role')}}:</strong><br><br>
                <input type="radio" id="user" name="role" value="user" {{ ($user->role=="user")? "checked" : "" }}>
                <label for="user">{{ __('message.worker') }}</label><br>
                <input type="radio" id="admin" name="role" value="admin" {{ ($user->role=="admin")? "checked" : "" }}>
                <label for="admin">{{ __('message.admin') }}</label><br>  
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">{{__('message.submit')}}</button>
        </div>
    </div>
@endsection