@extends('layout')

@section('title', 'Login - Home')

@section('nav_and_content')
<div class="row bg bg-warning">
    <div class="col-12">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h2>{{ __('message.entry_hours_worked') }}</h2>
            <form action="{{ route($lang.'_entry_hours.index') }}" method="GET">
                @csrf
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h3>{{ __('message.select') }} {{ __('message.project') }}</h3>
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
                <br>
                <button type="submit" class="btn btn-success">{{ __('message.select_project') }}</button>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="col-xs-12 col-sm-12 col-md-12 invisible" id="secondForm">
            <form action="{{ route($lang.'_entry_hours.store') }}" method="POST">
                @csrf
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h3>{{ __('message.service_on_project') }}: @if($bag_hours != []){{$bag_hours[0]->project_name}}. {{ __('message.customer') }}: {{ $customer_name->customer_name }}@endif</h3>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <strong>*{{__('message.service')}}:</strong><br>
                    @if (count($bag_hours) > 0)
                    <select name="bag_hour_in_project">
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
                        <input type="number" name="hours_worked" class="form-control" placeholder="{{__('message.enter')." ".__('message.hours_worked')}}" value="{{old('hours_worked')}}">
                    </div>
                </div>

                <input type="hidden" name="user_id" value="{{$user_id}}">
                <input type="hidden" name="project_id" value="{{$project_id}}">

                <button type="submit" class="btn btn-success">{{ __('message.entry_hours_worked') }}</button>

            </form>
        </div>
    </div>

</form>
</div>

@stop