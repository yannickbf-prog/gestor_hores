@extends('layout')

@section('title', 'Control panel - Customers - Edit '.$customer->name)

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('message.edit') }} {{__('message.customer')}} {{ $customer->name }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route($lang.'_customers.index') }}">{{__('message.back')}}</a>
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

<div class="alert alert-success mt-2">
    <strong>{{__('message.fields_are_required')}}</strong>
</div>

<form action="{{ route('customers.update',[$customer->id, $lang]) }}" method="POST">
    @csrf


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.name')}}:</strong>
                <input type="text" name="name" value="{{old('name', $customer->name)}}" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.email')}}:</strong>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{old('email', $customer->email)}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.phone')}}:</strong>
                <input type="text" name="phone" class="form-control" placeholder="Enter Phone" value="{{old('phone', $customer->phone)}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('message.description')}}:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="Enter Description">{{old('description', $customer->description)}}</textarea>
            </div>
        </div>
        <input type="hidden" name="lang" value="{{ $lang }}">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">{{__('message.submit')}}</button>
        </div>
    </div>

</form>
@endsection