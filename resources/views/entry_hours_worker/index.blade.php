@extends('layout')

@section('title', 'Login - Home')

@section('nav_and_content')
<div class="row bg bg-warning">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <h2>Entry worked hours</h2><br>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form action="{{ route($lang.'_entry_hours.index') }}" method="GET">
            @csrf
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h3>Projects</h3>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @if (count($data) > 0)
                <select name="projects">
                    @foreach($data as $key => $value)
                    <option value='{{$value->project_id}}'>{{$value->project_name}} ({{$value->customer_name}})</option>
                    @endforeach
                </select>
                @else
                <li>{{ __('message.no') }} {{ __('message.projects') }} {{ __('message.avalible') }} </li>
                @endif
            </div>
            <button type="submit" class="btn btn-success">{{ __('message.go') }}</button>
        </form>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 invisible" id="secondForm">
        <form action="{{ route('bag_hours.store',$lang) }}" method="POST">
            @csrf
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h3>Service</h3>
            </div>
           
            <button type="submit" class="btn btn-success">{{ __('message.go') }}</button>
        </form>
    </div>
</div>

@stop