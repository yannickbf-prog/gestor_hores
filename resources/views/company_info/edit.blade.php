@extends('layout')

@section('title', 'Control panel - Company Info - Edit '.$company->name)

@section('content')
@if ($message = Session::get('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
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

<div class="alert alert-info mt-2">
    <strong>{{__('message.fields_are_required')}}</strong>
</div>

<form action="{{ route('company-info.update', $lang) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*{{__('message.name')}}:</strong>
                <input type="text" name="name" value="{{old('name', $company->name)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.name')}}">
            </div>
        </div>



        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('message.logo')}}:</strong>
                @if($company->img_logo != null)
                <br>
                <img src="/storage/{{ $company->img_logo }}" class="logo" alt="Logo {{ $company->name }}">
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                    {{ __('message.delete') }}
                </button>
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
                                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('message.close') }}</button>
                                <a href="{{ route('company-info.destroy_logo', $lang) }}" class="btn btn-success">{{__('message.delete')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <br>
                <span><b>{{__('message.change')}} {{__('message.logo')}}</b></span>
                @else
                <span>{{__('message.no_logo_available')}}</span>
                <br>
                <span><b>{{__('message.add')}} {{__('message.logo')}}</b></span>
                @endif
                
                <input type="file" name="img_logo" class="form-control">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="workSector"><strong>*{{ __("message.work_sector") }}:</strong></label>
                <select class="form-control" id="workSector" name="work_sector">
                    <option value="automotive_sector" {{ setActiveSelect('automotive_sector', $company->work_sector) }}>{{__('message.automotive_sector')}}</option>
                    <option value="computer_science" {{ setActiveSelect('computer_science', $company->work_sector) }}>{{__('message.computer_science')}}</option>
                    <option value="construction" {{ setActiveSelect('construction', $company->work_sector) }}>{{__('message.construction')}}</option>
                    <option value="telecomunications" {{ setActiveSelect('telecomunications', $company->work_sector) }}>{{__('message.telecommunications')}}</option>
                    <option value="other">{{__('message.other')}}</option>
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
                <strong>{{__('message.email')}}:</strong>
                <input type="text" name="email" value="{{old('email', $company->email)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.email')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('message.phone')}}:</strong>
                <input type="text" name="phone" value="{{old('phone', $company->phone)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.phone')}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('message.website')}}:</strong>
                <input type="text" name="website" value="{{old('website', $company->website)}}" class="form-control" placeholder="{{__('message.enter')}} {{__('message.website')}}">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="defaultLang"><strong>*{{__('message.default_lang')}}</strong></label>
                <select class="form-control" id="defaultLang" name="default_lang">
                    <option value="en" {{ setActiveSelect('en', $company->default_lang) }}>{{__('message.english')}}</option>
                    <option value="es" {{ setActiveSelect('es', $company->default_lang) }}>{{__('message.spanish')}}</option>
                    <option value="ca" {{ setActiveSelect('ca', $company->default_lang) }}>{{__('message.catalan')}}</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">{{__('message.submit')}}</button>
        </div>
    </div>

</form>
@endsection
@section('js')
    <script type="text/javascript" src="{{ URL::asset('js/company_info_edit.js') }}"></script>
@endsection