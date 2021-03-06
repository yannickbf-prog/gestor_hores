@extends('layout')

@section('title', __('message.control_panel').' - '.__('message.company_info').' - '.$company->name)

@section('content')
@if ($message = Session::get('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

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

<form action="{{ route('company-info.update', $lang) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <h3>{{ __("message.company_info_providing") }}</h3>
    <div class="row">

        <div class="form-group col-xs-12 col-sm-6 col-md-3">
            <label for="company-name">{{__('message.company_name')}}</label>
            <input id="company-name" type="text" name="name" value="{{old('name', $company->name)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.name')}}">
        </div>

        <div class="form-group col-xs-12 col-sm-6 col-md-3">
            <label for="contact-email">{{__('message.contact_email')}}</label>
            <input id="contact-email" type="text" name="email" value="{{old('email', $company->email)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.email')}}">
        </div>
        
        <div class="form-group col-xs-12 col-sm-6 col-md-3 ml-auto">
            <label for="defaultLang">{{__('message.language')}}</label>
            <select class="form-control" id="defaultLang" name="default_lang">
                <option value="en" {{ setActiveSelect('en', $company->default_lang) }}>{{__('message.english')}}</option>
                <option value="es" {{ setActiveSelect('es', $company->default_lang) }}>{{__('message.spanish')}}</option>
                <option value="ca" {{ setActiveSelect('ca', $company->default_lang) }}>{{__('message.catalan')}}</option>
            </select>
        </div>

        <div class="form-group col-md-6">
            <span>{{__('message.logo')}}</span>
            @if($company->img_logo != null)
            <br>
            <img src="/storage/{{ $company->img_logo }}" class="logo" alt="Logo {{ $company->name }}">

            <i id="trashLogoIcon" class="bi bi-trash-fill fa-6x align-middle ml-1" data-toggle="modal" data-target="#exampleModal"></i>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('message.delete') }} {{ __("message.logo") }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ __('message.confirm') }} <b>{{ __('message.delete') }}</b> {{ __('message.the') }} {{ __("message.logo") }} ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">{{ __('message.close') }}</button>
                            <a href="{{ route('company-info.destroy_logo', $lang) }}" class="btn btn-danger">{{__('message.delete')}}</a>
                        </div>
                    </div>
                </div>
            </div

            <br>
            <br>

            @else
            <li>{{__('message.no_logo_available')}}</li>
            <br>
            @endif      
            <label class="btn general_button mt-1" for="add-change-logo">{{__('message.browse')}}</label>
            <input id="add-change-logo" onchange="browseChange()" type="file" name="img_logo" class="d-none">
            <div>
                <span id="img-info"></span>
            </div>
        </div>

        <div class="col-12 text-right">
            <button id="add-change-logo" type="submit" class="btn general_button">{{__('message.update')}}</button>
        </div>
        
    </div>

</form>

<div class="row" id="statistics">

    <div class="col-xs-12 col-sm-6 col-md-3">
        <span>{{ __('message.users') }}:</span><br><strong> {{ $users_count }}</strong>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3">
        <span>{{ __('message.customers') }}:</span><br><strong> {{ $customers_count }}</strong>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3">
        <span>{{ __('message.projects') }}:</span><br><strong> {{ $projects_count }}</strong>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3">
        <span>{{ __('message.bag_hours_types') }}:</span><br><strong> {{ $types_hour_bags_count }}</strong>
    </div>

</div>


@endsection
@section('js')

<script>
    function browseChange() {
        var pdrs = document.getElementById('add-change-logo').files[0].name;
        document.getElementById('img-info').innerHTML = '{{ __("message.new_logo") }}' + ": " + pdrs;
    }
</script>

<script type="text/javascript" src="{{ URL::asset('js/company_info_edit.js') }}"></script>
@endsection
