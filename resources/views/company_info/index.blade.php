@extends('layout')

@section('title', __('message.control_panel')." - ". __('Company Info'))

@section('content')
@if ($message = Session::get('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<a class="btn btn-primary" href="{{ route($lang.'_company_info.edit') }}">{{ __('message.edit') }}</a>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('Information on the company providing the services') }}</h2>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.name') }}:</strong><span> {{ $company->name }}</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('Logo') }}:</strong><span> {{ $company->img_logo }}</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('Work sector') }}:</strong><span> {{ $company->work_sector }}</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.description') }}:</strong><p> {{ $company->description }}</p>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.email') }}:</strong><span> {{ $company->email }}</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.phone') }}:</strong><span> {{ $company->phone }}</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('Website') }}:</strong><span> {{ $company->website }}</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('Default language') }}:</strong><span> {{ $company->default_lang }}</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3>{{ __('Statistics') }}</h3>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('Customers') }}:</strong><span> {{ $customers_count }}</span>
        </div>
    </div>
</div>

@endsection