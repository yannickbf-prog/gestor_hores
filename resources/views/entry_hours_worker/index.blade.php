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
    <div class="col-xs-8 col-sm-8 col-md-8 invisible" id="secondForm">
        <form action="{{ route('bag_hours.store',$lang) }}" method="POST">
            @csrf
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h3>Service</h3>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @if (count($bag_hours) > 0)
                <select name="bag_hours_in_project">
                    @foreach($bag_hours as $key => $value)
                    <option value='{{$value->bag_hour_id}}'>{{$value->type_bag_hour_name}}</option>
                    @endforeach
                </select>
                @else
                <li>{{ __('message.no') }} {{ __('message.bag_hours') }} {{ __('message.avalible') }} </li>
                @endif
            </div>

            <div class="col-xs-8 col-sm-8 col-md-8">

                <div class="form-group">
                    <strong>*{{__('message.hours')}}:</strong>
                    <input type="text" name="hours_worked" class="form-control" placeholder="{{__('message.enter')." ".__('message.hours_worked')}}" value="{{old('hours_worked')}}">
                </div>
            </div>
            
            <button type="submit" class="btn btn-success">{{ __('message.go') }}</button>
            
        </form>
    </div>

   
</form>
</div>
</div>

@stop