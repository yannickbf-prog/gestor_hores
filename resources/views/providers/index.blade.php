@extends('layout')

@section('title', __('message.control_panel')." - ". __('message.providers'))

@section('content')
@if ($message = Session::get('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ $message }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('message.providers') }}</h2>
        </div>
    </div>
</div>


@if ($errors->any())
<div class="alert alert-danger mt-3">
    @php
    $show_create_edit = true
    @endphp
    <strong>{{__('message.woops!')}}</strong> {{__('message.input_problems')}}<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ ucfirst($error) }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="px-2 py-3 create_edit_container">
    <div id="addEditHeader" class="d-inline-flex align-content-stretch align-items-center ml-3">
        
        <h3 class="d-inline-block m-0">{{ ($provider_to_edit == null) ? __('message.add_new')." ".__('message.provider') : __('message.edit')." ".__('message.provider') }}</h3>
        <i class="bi bi-chevron-down px-2 bi bi-chevron-down fa-lg" id="addEditChevronDown"></i>
    </div>

    <div id="addEditContainer">
        <div class="alert alert-info m-2 mt-3">
            <strong>{{__('message.fields_are_required')}}</strong>
        </div>
        
        <form action="{{ ($provider_to_edit == null) ? route('providers.store',$lang) : route('providers.update',[$provider_to_edit->id, $lang]) }}" method="POST" class="px-3 pt-2">
            @csrf

            <div class="row">

                <div class="form-group col-xs-12 col-sm-6 col-md-3 form_group_new_edit">  
                    <label for="newEditName">{{ __('message.name') }}:</label>
                    <input id="newEditName" type="text" name="name" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.name') }}" value="{{ ($provider_to_edit == null) ? old('name') : old('name', $provider_to_edit->name) }}">
                </div>

                <div class="form-group col-xs-12 col-sm-6 col-md-3 form_group_new_edit">
                    <label for="newEditEmail">{{ __('message.email') }}:</label>
                    <input id="newEditEmail" type="text" name="email" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.email') }}" value="{{ ($provider_to_edit == null) ? old('email') : old('email', $provider_to_edit->email) }}">
                </div>

                <div class="form-group col-xs-12 col-sm-6 col-md-3 form_group_new_edit">
                    <label for="newEditPhone">{{ __('message.phone') }}:</label>
                    <input id="newEditPhone" type="text" name="phone" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.phone') }}" value="{{ ($provider_to_edit == null) ? old('phone') : old('phone', $provider_to_edit->phone) }}">
                </div>

                <div class="form-group col-xs-12 col-sm-6 col-md-3 form_group_new_edit">
                    <label for="newEditTaxNumber">{{__('message.tax_number')}}:</label>
                    <input id="newEditTaxNumber" type="text" name="tax_number" class="form-control" placeholder="{{__('message.enter')}} {{__('message.tax_number')}}" value="{{ ($provider_to_edit == null) ? old('tax_number') : old('tax_number', $provider_to_edit->tax_number) }}">
                </div>

                <div class="form-group col-xs-12 col-sm-6 col-md-3 form_group_new_edit">
                    <label for="newEditContactPerson">{{ __('message.contact_person') }}:</label>
                    <input id="newEditContactPerson" type="text" name="contact_person" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.contact_person') }}" value="{{ ($provider_to_edit == null) ? old('contact_person') : old('contact_person', $provider_to_edit->contact_person) }}">
                </div>

                <div class="form-group col-xs-12 col-sm-6 col-md-3 form_group_new_edit">
                    <label for="newEditAddress">{{ __('message.address') }}:</label>
                    <input id="newEditAddress" type="text" name="address" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.address') }}" value="{{ ($provider_to_edit == null) ? old('address') : old('address', $provider_to_edit->address) }}">
                </div>

                <div class="form-group col-xs-12 col-sm-6 col-md-3 form_group_new_edit">
                    <label for="newEditPostalCode">{{ __('message.postal_code') }}:</label>
                    <input id="newEditPostalCode" type="text" name="postal_code" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.postal_code') }}" value="{{ ($provider_to_edit == null) ? old('postal_code') : old('postal_code', $provider_to_edit->postal_code) }}">
                </div>

                <div class="form-group col-xs-12 col-sm-6 col-md-3 form_group_new_edit">
                    <label for="newEditPostalCode">IBAN:</label>
                    <input id="newEditPostalCode" type="text" name="iban" class="form-control" placeholder="{{__('message.enter')}} IBAN" value="{{ ($provider_to_edit == null) ? old('iban') : old('iban', $provider_to_edit->iban) }}">
                </div>

                <div class="form-group col-xs-12 col-sm-6 col-md-3" id="formCountries">
                    <label for="selectCountries">{{ __('message.country') }}</label>
                    <select id="selectCountries" name="country" class="form-control" onchange="showProvienciesofCountry()">
                        @forelse ($countries as $value)
                        <option value="{{ $value->code }}">
                            {{ $value->name }}
                        </option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="form-group col-xs-12 col-sm-6 col-md-3" id="formProvinces">
                    <label for="selectProvinces">{{ __('message.province') }}</label>
                    <select id="selectProvinces" name="province" class="form-control" onchange="showMunicipiesofProviencies()">
						<option value=""></option>
                    </select>
                </div>

                <div class="form-group col-xs-12 col-sm-6 col-md-3" id="formMunicipalities">
                    <label for="selectMunicipalities">{{ __('message.municipality') }}</label>
                    <select id="selectMunicipalities" name="municipality" class="form-control">
                        <option value=""></option>
                    </select>
                </div>

                <div class="form-group col-xs-12 col-sm-8 col-md-5 form_group_new_edit">
                    <label for="newEditDesc">{{__('message.observations')}}:</label>
                    <textarea id="newEditDesc" class="form-control" name="description" placeholder="{{__('message.enter')." ".__('message.observations')}}">{{ ($provider_to_edit == null) ? old('description') : old('description', $provider_to_edit->description) }}</textarea>
                </div>

                <div class="form-group d-flex justify-content-end col-12 pr-0 mb-0">
                    @if ($provider_to_edit !== null)
                    <a class="btn general_button mr-0" href="{{route('providers.cancel_edit',$lang)}}">{{__('message.cancel')}}</a>
                    @endif
                    <button type="submit" class="btn general_button mr-2">{{ ($provider_to_edit == null) ? __('message.save') : __('message.update')}}</button>

                </div>
                
            </div>
        </form>
    </div>

</div>

<div id="filterDiv" class="p-4 my-3">
    <div class="mb-4" id="filterTitleContainer">
        <div class="d-flex align-content-stretch align-items-center">
            <h3 class="d-inline-block m-0">{{ __('message.filters') }}</h3><i class=" px-2 bi bi-chevron-down fa-lg" id="filterChevronDown"></i>
        </div>
    </div>
    <div id="filtersContainer">
        <form action="{{ route($lang.'_providers.index') }}" method="GET" class="row"> 
            @csrf

            <div class="form-group col-xs-12 col-sm-6 col-md-3">  
                <label for="filterName">{{ __('message.name') }}:</label>
                <input id="filterName" type="text" name="name" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.name') }}" value="@if(session('provider_name') != '%'){{session('provider_name')}}@endif">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-3">
                <label for="filterEmail">{{ __('message.email') }}:</label>
                <input id="filterEmail" type="text" name="email" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.email') }}" value="@if(session('provider_email') != '%'){{session('provider_email')}}@endif">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-3">
                <label for="filterPhone">{{ __('message.phone') }}:</label>
                <input id="filterPhone" type="text" name="phone" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.phone') }}" value="@if(session('provider_phone') != '%'){{session('provider_phone')}}@endif">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-3">
                <label for="filterTaxNumber">{{__('message.tax_number')}}:</label>
                <input id="filterTaxNumber" type="text" name="tax_number" class="form-control" placeholder="{{__('message.enter')}} {{__('message.tax_number')}}" value="@if(session('provider_tax_number') != '%'){{session('provider_tax_number')}}@endif">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-3">
                <label for="filterContactPerson">{{ __('message.contact_person') }}:</label>
                <input id="filterContactPerson" type="text" name="contact_person" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.contact_person') }}" value="@if(session('provider_contact_person') != '%'){{session('provider_contact_person')}}@endif">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-3">
                <label for="filterBag">Tenent bosses:</label>
                <select name="bag" id="filterBag" class="form-control form-select">
                    <option value="all">{{ __('message.all_m') }}</option>
                    <option value="yes" @if(session('provider_bag') == 'yes'){{'selected'}}@endif >{{ __('message.Yes') }}</option>
                    <option value="no" @if(session('provider_bag') == 'no'){{'selected'}}@endif>{{ __('message.No') }}</option>
                </select>
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-3">
                <label for="filterAddress">{{ __('message.address') }}:</label>
                <input id="filterAddress" type="text" name="address" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.address') }}" value="@if(session('provider_address') != '%'){{session('provider_address')}}@endif">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-3">
                <label for="filterPostalCode">{{ __('message.postal_code') }}:</label>
                <input id="filterPostalCode" type="text" name="postal_code" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.postal_code') }}:" value="@if(session('provider_postal_code') != '%'){{session('provider_postal_code')}}@endif">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-3" id="filterCountries">
                <label for="filterCountry">{{ __('message.country') }}:</label>
                <select id="filterCountry" name="country" class="form-control" onchange="filterProvienciesofCountry()">
                <option value=""></option>
                    @forelse ($countries as $value)
                    <option value="{{ $value->code }}"  @if(session('provider_country') == $value->code){{'selected'}}@endif >
                        {{ $value->name }}
                    </option>
                    @empty
                    @endforelse
                </select>
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-3" id="filterProvinces">
                <label for="filterProvince">{{ __('message.province') }}:</label>
                <select id="filterProvince" name="province" class="form-control" onchange="filterMunicipiesofProviencies()">
					<option value=""></option>
                </select>
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-3" id="filterMunicipalities">
                <label for="filterMunicipality">{{ __('message.municipality') }}:</label>
                <select id="filterMunicipality" name="municipality" class="form-control">
                    <option value=""></option>
                </select>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6 form-group align-self-end">

                <button type="button" class="btn m-0" id="datePopoverBtn" data-placement="top">{{ __('message.date_creation_interval') }}</button>

                <div class="popover fade bs-popover-top show invisible" id="datePopover" role="tooltip" style="position: absolute; transform: translate3d(-51px, -186px, 0px); top: 0px; left: 0px;" x-placement="top">
                    <div class="arrow" style="left: 114px;"></div>
                    <div class="popover-body">
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="close" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="form-group mt-2">
                                    <label for="filterDateFrom">{{ __('message.from') }}:</label>
                                    <input id="filterDateFrom" autocomplete="off" name="date_from" type="text" class="datepicker form-control form-control-sm" value="@if(session('provider_date_from') != ''){{session('provider_date_from')}}@endif">
                                </div>
                                <div class="form-group">
                                    <label for="filterDateTo">{{ __('message.to') }}:</label><br>
                                    <input id="filterDateTo" autocomplete="off" type="text" name="date_to" class="datepicker form-control form-control-sm" value="@if(session('provider_date_to') != ''){{session('provider_date_to')}}@endif">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="form-group d-flex justify-content-end mb-0 col-12">
                <a href="{{ route('providers.delete_filters', $lang) }}" class="btn general_button mr-0 mb-2">{{ __('message.delete_all_filters') }}</a>
                <button type="submit" class="btn general_button mr-0 mb-2">{{ __('message.filter') }}</button>
            </div>

        </form>
    </div>
</div>

<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3>{{ __('message.providers_list') }}</h3>
        </div>
    </div>
</div>

<table class="table">
    @if (count($data) > 0)
    <thead>
        <tr class="thead-light">
            <th>Nº</th>
            <th><a href="{{ route('providers.orderby', ['name',$lang]) }}">{{ __('message.name') }}</a></th>
            <th><a href="{{ route('providers.orderby', ['email',$lang]) }}">{{ __('message.email') }}</a></th>
            <th><a href="{{ route('providers.orderby', ['phone',$lang]) }}">{{ __('message.phone') }}</a></th>
            <th><a href="{{ route('providers.orderby', ['description',$lang]) }}">{{ __('message.observations') }}</a></th>
            <th><a href="{{ route('providers.orderby', ['tax_number',$lang]) }}">{{ __('message.tax_number') }}</a></th>
            <th><a href="{{ route('providers.orderby', ['contact_person',$lang]) }}">{{ __('message.contact_person') }}</a></th>
            <th><a href="{{ route('providers.orderby', ['address',$lang]) }}">Adreça</a></th>
            <!--<th><a href="{{ route('providers.orderby', ['postal_code',$lang]) }}">Codi postal</a></th>-->
            <th><a href="{{ route('providers.orderby', ['country',$lang]) }}">Pais</a></th>
            <th><a href="{{ route('providers.orderby', ['province',$lang]) }}">Province</a></th>
            <th><a href="{{ route('providers.orderby', ['created_at',$lang]) }}">{{ __('message.created_at') }}</a></th>
            <th></th>
        </tr>
    </thead>
    @endif
    <tbody>
        @forelse ($data as $value)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $value->name }}</td>
             <td>{{ $value->email }}</td>
            <td>{{ $value->phone }}</td>
            <td>@if ($value->description == ''){{ __('message.no_description') }} @else {{ \Str::limit($value->description, 100) }} @endif</td>
            <td>{{ $value->tax_number }}</td>
            <td>{{ $value->contact_person }}</td>
            <td>{{ $value->address }}</td>
            <!--<td>{{ $value->postal_code }}</td>-->
            <td>{{ $value->country_name}}</td>
            <td>{{ $value->province_name }}</td>
            <td>{{ $value->created_at->format('d/m/y') }}</td>
            <td class="align-middle">
                <div class="validate_btns_container d-flex align-items-stretch justify-content-around">
                    
                    @php
                    $form_id = "editForm".$value->id;
                    $form_dom = "document.getElementById('editForm".$value->id."').submit();";
                    @endphp

                    <form action="{{ route($lang.'_providers.index') }}" method="GET" class="invisible" id="{{ $form_id }}"> 
                        @csrf
                        <input type="hidden" name="provider_id" value="{{ $value->id }}">
                    </form>

                    <a style="text-decoration: none" class="text-dark">
                        <i onclick="{{ $form_dom }}" class="bi bi-pencil-fill fa-lg"></i>
                    </a>
                    
                    
                    @php
                    $id = "exampleModal".$value->id;
                    @endphp

                    <a href="#{{$id}}" data-toggle="modal" data-target="#{{$id}}" style="text-decoration: none" class="text-dark">
                        <i class="bi bi-trash-fill fa-lg"></i>
                    </a>

                    <!-- Modal -->
                    <div class="modal fade" id="{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <form action="{{ route('providers.destroy',[$value->id, $lang]) }}" method="POST"> 
                            @csrf
                            @method('DELETE')  

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('message.delete') }} {{ $value->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ __('message.confirm') }} {{ __('message.delete') }} {{ __('message.the') }} {{ __("message.provider") }} <b>{{ $value->name }}</b>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('message.close') }}</button>
                                        <button type="submit" class="btn btn-success">{{ __('message.delete') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>   
                    
                </div>
               
            </td>
        </tr>
        @empty
    <li>{{__('message.no')}} {{__('message.providers')}} {{__('message.to_show')}}</li>
    @endforelse
</tbody>
</table> 
@if (count($data) > 0)
<form action="{{ route('providers.change_num_records', $lang) }}" method="GET"> 
    @csrf
    <div class="form-group d-flex align-items-center">
        <strong>{{ __('message.number_of_records') }}:</strong>
        <select name="num_records" id="numRecords" onchange="this.form.submit()" class="form-control form-select ml-2">
            <option value="10">10</option>
            <option value="50" @if(session('providers_num_records') == 50){{'selected'}}@endif>50</option>
            <option value="100" @if(session('providers_num_records') == 100){{'selected'}}@endif>100</option>
            <option value="all" @if(session('providers_num_records') == 'all'){{'selected'}}@endif>{{ __('message.all') }}</option>
        </select>
    </div>
</form>
@endif
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection
@section('js')
<script>

    var provinces = @json($provinces);
    var municipalities = @json($municipalities);

    showProvienciesofCountry();
    filterProvienciesofCountry();

    function showProvienciesofCountry(){

        let formCountries = document.getElementById("formCountries");
        let formProvinces = document.getElementById("formProvinces");

            //Create the select of provinces
            let ProvinciesSelectHtml = document.createElement("select");
            ProvinciesSelectHtml.name = "province";
            ProvinciesSelectHtml.setAttribute('id', 'selectProvinces');
            ProvinciesSelectHtml.setAttribute('onchange', 'showMunicipiesofProviencies()');
            ProvinciesSelectHtml.setAttribute('class', 'form-control');

            let CountriesId = document.getElementById('selectCountries').value;
           
            let res = provinces.filter((item) => {
				return item.code_country == CountriesId;
			});

            let option = document.createElement("option");
                option.value = "";
                option.innerText = "";
                ProvinciesSelectHtml.appendChild(option);
            console.info( );
            for (province of res) {
                let option = document.createElement("option");
                option.value = province.id;
                option.innerText = province.name;
                /*if ()
                    option.selected = true;
*/
                ProvinciesSelectHtml.appendChild(option);
            }

            if (document.getElementById("selectProvinces") != null) {
                document.getElementById("selectProvinces").remove();
            }
            
            formProvinces.appendChild(ProvinciesSelectHtml);
            showMunicipiesofProviencies();
    }

    function showMunicipiesofProviencies(){
        let formMunicipalities = document.getElementById("formMunicipalities");
        let formProvinces = document.getElementById("formProvinces");

            //Create the select of provinces
            let MunicipalitiesSelectHtml = document.createElement("select");
            MunicipalitiesSelectHtml.name = "municipality";
            MunicipalitiesSelectHtml.setAttribute('id', 'selectMunicipalities');
            MunicipalitiesSelectHtml.setAttribute('class', 'form-control');

            let ProvincesId = document.getElementById('selectProvinces').value;

            let res = municipalities.filter((item) => {
				return item.id_provincie == ProvincesId;
			});

            let option = document.createElement("option");
                option.value = "";
                option.innerText = "";
                MunicipalitiesSelectHtml.appendChild(option);

            for (province of res) {
                let option = document.createElement("option");
                option.value = province.id;
                option.innerText = province.name;/*
                if (old_data.length != 0 && provider.provider_id == old_data.old_providers[old_data_index])
                    option.selected = true;
                else if (values_before_edit !== null && provider.provider_id == values_before_edit.provider_id)
                    option.selected = true;*/
                MunicipalitiesSelectHtml.appendChild(option);
            }

            if (document.getElementById("selectMunicipalities") != null) {
                document.getElementById("selectMunicipalities").remove();
            }

            formMunicipalities.appendChild(MunicipalitiesSelectHtml);
    }

    function filterProvienciesofCountry(){

        let filtpro="{{session('provider_province')}}";
        
        let formCountries = document.getElementById("filterCountries");
        let formProvinces = document.getElementById("filterProvinces");

            //Create the select of provinces
            let ProvinciesSelectHtml = document.createElement("select");
            ProvinciesSelectHtml.name = "province";
            ProvinciesSelectHtml.setAttribute('id', 'filterProvince');
            ProvinciesSelectHtml.setAttribute('onchange', 'filterMunicipiesofProviencies()');
            ProvinciesSelectHtml.setAttribute('class', 'form-control');

            let CountriesId = document.getElementById('filterCountry').value;
           
            let res = provinces.filter((item) => {
				return item.code_country == CountriesId;
			});

            let option = document.createElement("option");
                option.value = "";
                option.innerText = "";
                ProvinciesSelectHtml.appendChild(option);

            for (province of res) {
                let option = document.createElement("option");
                option.value = province.id;
                option.innerText = province.name;
                if (option.value==filtpro)
                    option.selected = true;
                ProvinciesSelectHtml.appendChild(option);
            }

            if (document.getElementById("filterProvince") != null) {
                document.getElementById("filterProvince").remove();
            }
            
            formProvinces.appendChild(ProvinciesSelectHtml);
            filterMunicipiesofProviencies();
    }

    function filterMunicipiesofProviencies(){

        let filtpro="{{session('provider_municipality')}}";

        let formMunicipalities = document.getElementById("filterMunicipalities");
        let formProvinces = document.getElementById("filterProvinces");

            //Create the select of provinces
            let MunicipalitiesSelectHtml = document.createElement("select");
            MunicipalitiesSelectHtml.name = "municipality";
            MunicipalitiesSelectHtml.setAttribute('id', 'filterMunicipality');
            MunicipalitiesSelectHtml.setAttribute('class', 'form-control');

            let ProvincesId = document.getElementById('filterProvince').value;

            let res = municipalities.filter((item) => {
				return item.id_provincie == ProvincesId;
			});

            let option = document.createElement("option");
                option.value = "";
                option.innerText = "";
                MunicipalitiesSelectHtml.appendChild(option);
            
            for (province of res) {
                let option = document.createElement("option");
                option.value = province.id;
                option.innerText = province.name;
                if (option.value==filtpro)
                    option.selected = true;
                MunicipalitiesSelectHtml.appendChild(option);
            }

            if (document.getElementById("filterMunicipality") != null) {
                document.getElementById("filterMunicipality").remove();
            }

            formMunicipalities.appendChild(MunicipalitiesSelectHtml);
    }
    
    var addEditCount = 1;
    $("#addEditHeader").click(function () {

        if (addEditCount % 2 == 0)
            $('#addEditChevronDown').css("transform", "rotate(0deg)");

        else
            $('#addEditChevronDown').css("transform", "rotate(180deg)");

        addEditCount++;

        // show hide paragraph on button click
        $("#addEditContainer").toggle(400);
    });
    
    var filterCount = 1;
    $("#filterTitleContainer").click(function () {

        if (filterCount % 2 == 0)
            $('#filterChevronDown').css("transform", "rotate(0deg)");

        else
            $('#filterChevronDown').css("transform", "rotate(180deg)");

        filterCount++;

        // show hide paragraph on button click
        $("#filtersContainer").toggle(400);
    });


    //Code for show filters when filter
    var show_create_edit = @json($show_create_edit);
    var show_filters = @json($show_filters);
    
    if (show_create_edit){
        $('#addEditChevronDown').css("transform", "rotate(180deg)");
        $('#addEditContainer').show(400);
        addEditCount = 2;
    }
    
    if (show_filters) {
        $('#filterChevronDown').css("transform", "rotate(180deg)");
        $('#filtersContainer').show(400);
        filterCount = 2;
    }
</script>
<script type="text/javascript" src="{{ URL::asset('js/provider_index.js') }}"></script>
@endsection