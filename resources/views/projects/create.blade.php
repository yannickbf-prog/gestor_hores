@extends('layout')

@section('title')
{{ __("message.control_panel") }} - {{ __('message.add_new')." ".__('message.project') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('message.add_new')." ".__('message.project') }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route($lang.'_projects.index') }}"> {{__('message.back')}}</a>
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

<form action="{{ route('projects.store',$lang) }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.name')}}:</strong>
                <input type="text" name="name" class="form-control" placeholder="{{__('message.enter')." ".__('message.name')}}" value="{{old('name')}}">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{ __('message.customer') }}: </strong>
                @if (count($customers) > 0)
                <select name="customer_id" id="numRecords">
                    @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{$customer->name}}</option>
                    @endforeach
                </select>
                @else
                <li>{{ __('message.no') }} {{ __('message.customers') }} {{ __('message.avalible') }} {{ __('message.create customer') }}</li>
                @endif
                <a href="{{ route($lang."_customers.create") }}" type="button" class="btn btn-primary btn-sm">{{ __('message.create') }} {{ __('message.customer') }}</a>
            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{ __('message.state') }}:</strong><br>
                <input type="radio" id="active" name="active" value="1" checked>
                <label for="active">{{__('message.active')}}</label><br>
                <input type="radio" id="inactive" name="active" value="0">
                <label for="inactive">{{__('message.inactive')}}</label><br>  
            </div>

        </div> 
        
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('message.description')}}:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="{{__('message.enter')." ".__('message.description')}}">{{old('description')}}</textarea>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">{{__('message.submit')}}</button>
        </div>
    </div>

</form>
@endsection