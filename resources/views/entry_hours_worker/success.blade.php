@extends('layout')

@section('title', 'Login - Home')

@section('nav_and_content')
<div class="row bg bg-warning">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <h2>Entry worked hours</h2><br>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-info" role="alert">
            Worked hours entry successfuly
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <a class="btn btn-info" href="{{ route('en_entry_hours.index') }}">Entry more hours</a>
    </div>

@stop
