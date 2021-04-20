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
                <label for="workSector"><strong>*{{ "Work sector" }}:</strong></label>
                <select class="form-control" id="workSector" name="work_sector">
                    <option value="automotive_sector" {{ setActiveSelect('automotive_sector', $company->work_sector) }}>Automotive sector</option>
                    <option value="computer_science" {{ setActiveSelect('computer_science', $company->work_sector) }}>Computer science</option>
                    <option value="construction" {{ setActiveSelect('construction', $company->work_sector) }}>Construction</option>
                    <option value="telecomunications" {{ setActiveSelect('telecomunications', $company->work_sector) }}>Telecommunications</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('message.description')}}:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="{{__('message.enter')." ".__('message.description')}}">{{old('description', $company->description)}}</textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.email')}}:</strong>
                <input type="text" name="email" value="{{old('email', $company->email)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.email')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.phone')}}:</strong>
                <input type="text" name="phone" value="{{old('phone', $company->phone)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.phone')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('Website')}}:</strong>
                <input type="text" name="website" value="{{old('website', $company->website)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('Website')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('Default language')}}:</strong>
                <input type="text" name="default_lang" value="{{old('default_lang', $company->default_lang)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('Website')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="defaultLang"><strong>*{{__('Default language')}}</strong></label>
                <select class="form-control" id="defaultLang" name="default_lang">
                    <option value="en" {{ setActiveSelect('en', $company->default_lang) }}>{{__('message.english')}}</option>
                    <option value="es" {{ setActiveSelect('es', $company->default_lang) }}>{{__('message.spanish')}}</option>
                    <option value="ca" {{ setActiveSelect('ca', $company->default_lang) }}>{{__('message.catalan')}}</option>
                </select>
            </div>
        </div>
    </div>

</form>
@endsection