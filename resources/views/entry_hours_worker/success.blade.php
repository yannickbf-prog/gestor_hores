@extends('layout')

@section('title', 'Login - Home')

@section('nav_and_content')
<div class="row bg bg-warning">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <h2>{{__('message.entry_hours_worked') }}</h2><br>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-info" role="alert">
            {{__('message.hours_worked_successfully_recorded') }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <a class="btn btn-info" href="{{ route('en_entry_hours.index') }}">{{__('message.entry_more')}} {{__('message.hours_worked') }}</a>
    </div>

@stop
