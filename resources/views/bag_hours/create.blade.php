@extends('layout')

@section('title')
{{ __("message.control_panel") }} - {{ __('message.add_new')." ".__('message.bag_hour') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('message.add_new')." ".__('message.bag_hour_type') }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route($lang.'_bag_hours_types.index') }}"> {{__('message.back')}}</a>
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

<form action="{{ route('bag_hours.store', $lang) }}" method="POST">
    @csrf
  
     <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{ __('message.bag_hour_type') }}: </strong>
                @if (count($bags_hours_types) > 0)
                <select name="type_id">
                    @foreach($bags_hours_types as $key => $bag_hours_type)
                    <option value="{{ $bag_hours_type->id }}">{{$bag_hours_type->name}}</option>
                    @endforeach
                </select>
                @else
                <li>{{ __('message.no') }} {{ __('message.bag_hour_type') }} {{ __('message.avalible') }} </li>
                @endif
                <a href="{{ route($lang."_bag_hours_types.create") }}" type="button" class="btn btn-primary btn-sm">{{ __('message.create') }} {{ __('message.bag_hour_type') }}</a>
            </div>
        </div>
         
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{ __('message.project') }}: </strong>
                @if (count($bags_hours_types) > 0)
                <select name="project_id">
                    @foreach($projects as $key => $project)
                    <option value="{{ $project->id }}">{{$project->name}}</option>
                    @endforeach
                </select>
                @else
                <li>{{ __('message.no') }} {{ __('message.project') }} {{ __('message.avalible') }} </li>
                @endif
                <a href="{{ route($lang."_projects.create") }}" type="button" class="btn btn-primary btn-sm">{{ __('message.create') }} {{ __('message.project') }}</a>
            </div>
        </div>
         
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.contracted_hours')}}:</strong>
                <input type="text" name="contracted_hours" class="form-control" placeholder="{{__('message.enter')." ".__('message.contracted_hours')}}" value="{{old('contracted_hours')}}">
            </div>
        </div>
         
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.total_price')}}:</strong>
                <input type="text" name="total_price" class="form-control" placeholder="{{__('message.enter')." ".__('message.total_price')}}" value="{{old('total_price')}}">
            </div>
        </div>
         
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">{{__('message.submit')}}</button>
        </div>
    </div>
   
</form>
@endsection
@section('js')
    <script type="text/javascript" src="{{ URL::asset('js/bag_hours_create.js') }}"></script>
@endsection