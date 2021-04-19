@extends('layout')

@section('title', 'Control panel - Company Info - Edit '.$company->name)

@section('content')
<div class="pull-right">
    <a class="btn btn-primary" href="{{ route($lang.'_company_info.index') }}">{{__('message.back')}}</a>
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

<form action="{{ route('company-info.update', $lang) }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.name')}}:</strong>
                <input type="text" name="name" value="{{old('name', $company->name)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.name')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('Logo')}}:</strong>
                <input type="text" name="logo" value="{{old('logo', $company->img_logo)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('Logo')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('Work sector')}}:</strong>
                <input type="text" name="work_sector" value="{{old('work_sector', $company->work_sector)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('Work sector')}}">
            </div>
        </div>
    </div>

</form>
@endsection