@extends('layout')

@section('title', __('message.control_panel')." - ". __('message.company_info_providing'))

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
            <h2>{{ __('message.company_info_providing') }}</h2>
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
            <strong>{{ __('message.logo') }}:</strong><br>
            @if($company->img_logo != null)
            <img src="/storage/{{ $company->img_logo }}" class="logo" alt="Logo {{ $company->name }}">
            @else
            <span>{{ __('message.no_logo_available') }}</span>
            @endif
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.work_sector') }}:</strong><span> {{ __("message.".$company->work_sector) }}</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.description') }}:</strong><p> @if($company->description != null) {{ $company->description }} @else {{ __('message.no_description_available')}} @endif</p>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.email') }}:</strong><span> @if($company->email != null) {{ $company->email }} @else {{ __('message.no_email_available')}} @endif</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.phone') }}:</strong><span> @if($company->phone != null) {{ $company->phone }} @else {{__('message.no_phone_available')}} @endif</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.website') }}:</strong><span> @if($company->website != null) <a href="{{ "//".$company->website }}" target="_blank">{{ $company->website }}</a> @else {{__('message.no_website_available')}} @endif</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.default_lang') }}:</strong><span> {{ __('message.'.$company->default_lang) }}</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3>{{ __('message.statistics') }}</h3>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.users') }}:</strong><span> {{ $users_count }}</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.customers') }}:</strong><span> {{ $customers_count }}</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.projects') }}:</strong><span> {{ $projects_count }}</span>
        </div>
    </div>
</div>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <strong>{{ __('message.bag_hours_types') }}:</strong><span> {{ $types_hour_bags_count }}</span>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script type="text/javascript" src="{{ URL::asset('js/company_info_index.js') }}"></script>
@endsection