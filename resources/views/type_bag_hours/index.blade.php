@extends('layout')

@section('title', __('message.control_panel')." - ". __('message.bag_hours_types'))

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
            <h2>{{ __('message.bag_hours_types') }}</h2>
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

        <h3 class="d-inline-block m-0">{{ ($type_bag_hour_to_edit == null) ? __('message.add_new')." ".__('message.bag_hours_types') : __('message.edit')." ".__('message.bag_hours_types') }}</h3>
        <i class="bi bi-chevron-down px-2 bi bi-chevron-down fa-lg" id="addEditChevronDown"></i>
    </div>

    <div id="addEditContainer">
        <div class="alert alert-info m-2 mt-3">
            <strong>{{__('message.fields_are_required')}}</strong>
        </div>

        <form action="{{ ($type_bag_hour_to_edit == null) ? route('bag_hours_types.store',$lang) : route('bag_hours_types.update',[$type_bag_hour_to_edit->id, $lang]) }}" method="POST" class="px-3 pt-2">
            @csrf

            <div class="row">

                <div class="form-group col-xs-12 col-sm-7 col-md-3 form_group_new_edit mb-md-0">
                    <label for="nameInput">*{{__('message.name')}}:</label>
                    <input id="nameInput" type="text" name="name" class="form-control" placeholder="{{__('message.enter')." ".__('message.name')}}" value="{{old('name')}}">
                </div>

                <div class="form-group col-xs-12 col-sm-5 col-md-2 form_group_new_edit mb-md-0">
                    <label for="hourPriceInput">*{{__('message.hour_price')}}:</label>
                    <input id="hourPriceInput" type="text" name="hour_price" class="form-control" placeholder="{{__('message.enter')." ".__('message.hour_price')}}"  value="{{old('hour_price')}}">

                </div>

                <div class="form-group col-xs-6 col-sm-12 col-md-5 form_group_new_edit mb-md-0">
                    <label for="descriptionInput">{{__('message.description')}}:</label>
                    <textarea id="descriptionInput" class="form-control" name="description" placeholder="{{__('message.enter')." ".__('message.description')}}">{{old('description')}}</textarea>
                </div>

                <div class="form-group d-flex justify-content-end col-12 pr-0 mb-0 pt-4">
                    @if ($type_bag_hour_to_edit !== null)
                    <a class="btn general_button mr-0" href="{{route('bag_hours.cancel_edit',$lang)}}">{{__('message.cancel')}}</a>
                    @endif

                    <button type="submit" class="btn general_button mr-2">{{ ($type_bag_hour_to_edit == null) ? __('message.save') : __('message.update')}}</button>
                </div>

            </div>
        </form>
    </div>

</div>
<form action="{{ route($lang.'_bag_hours_types.index') }}" method="GET"> 
    @csrf

    <div class="row py-2">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>{{ __('message.filters') }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('message.name') }}:</strong>
                <input type="text" name="name_id" class="form-control" placeholder="{{ __('message.enter')." ".__('message.name') }}" value="@if(session('type_bag_hour_name') != '%'){{session('type_bag_hour_name')}}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('message.hour_price') }}:</strong>
                <input type="text" name="hour_price" class="form-control" placeholder="{{ __('message.enter')." ".__('message.hour_price') }}" value="@if(session('type_bag_hour_price') != '%'){{ session('type_bag_hour_price') }}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">

                <button type="button" class="btn btn-md btn-primary" id="datePopoverBtn" data-placement="top">{{ __('message.date_creation_interval') }}</button>

                <div class="popover fade bs-popover-top show invisible" id="datePopover" role="tooltip" style="position: absolute; transform: translate3d(-31px, -146px, 0px); top: 0px; left: 0px;" x-placement="top">
                    <div class="arrow" style="left: 114px;"></div>
                    <div class="popover-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="button" class="close" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="form-group">
                                    <strong>{{ __('message.from') }}:</strong>
                                    <input autocomplete="off" name="date_from" type="text" class="datepicker" value="@if(session('type_bag_hour_date_from') != ''){{session('type_bag_hour_date_from')}}@endif">
                                </div>
                                <div class="form-group">
                                    <strong>{{ __('message.to') }}:</strong>
                                    <input autocomplete="off" type="text" name="date_to" class="datepicker" value="@if(session('type_bag_hour_date_to') != ''){{session('type_bag_hour_date_to')}}@endif">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('message.order') }}:</strong>
                <select name="order" id="order">
                    <option value="asc">{{ __('message.old_first') }}</option>
                    <option value="desc" @if(session('type_bag_hour_order') == 'desc'){{'selected'}}@endif>{{ __('message.new_first') }}</option>
                </select>
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('message.number_of_records') }}: </strong>
                <select name="num_records" id="numRecords">
                    <option value="10">10</option>
                    <option value="50" @if(session('type_bag_hour_num_records') == 50){{'selected'}}@endif>50</option>
                    <option value="100" @if(session('type_bag_hour_num_records') == 100){{'selected'}}@endif>100</option>
                    <option value="all" @if(session('type_bag_hour_num_records') == 'all'){{'selected'}}@endif>{{ __('message.all') }}</option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success">{{ __('message.filter') }}</button>
</form>

<form action="{{ route('type_bag_hours.delete_filters') }}" method="POST"> 
    @csrf
    <input type="hidden" name="lang" value="{{ $lang }}">
    <button type="submit" class="btn btn-success">{{ __('message.delete_all_filters') }}</button>
</form>

<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3>{{ __("message.bag_hour_type_list") }}</h3>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route($lang.'_bag_hours_types.create') }}">{{ __('message.create_new_type_hour_bag') }}</a>
        </div>
    </div>
</div>

<table class="table">
    @if (count($data) > 0)
    <thead>
        <tr class="thead-light">
            <th>Nº</th>
            <th>{{ __('message.name') }}</th>
            <th>{{ __('message.description') }}</th>
            <th>{{ __('message.hour_price') }}</th>
            <th>{{ __('message.total_price') }}</th>
            <th>{{ __('message.number_of_hours') }}</th>
            <th>{{ __('message.created_at') }}</th>
            <th></th>
        </tr>
    </thead>
    @endif
    <tbody>
        @forelse ($data as $key => $value)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $value->name }}</td>
            <td>@if ($value->description == "") {{ __('message.no_description') }} @else {{ \Str::limit($value->description, 100) }} @endif</td>
            <td>{{ number_format($value->hour_price, 2, ',', '.') }}€</td>
            <td>{{ number_format($value->total_price_bag_type, 2, ',', '.')}}€</td>
            <td>{{ ($value->total_hours_bag_type == null) ? 0 : $value->total_hours_bag_type }}h</td>
            <td>{{ $value->created_at->format('d/m/y') }}</td>
            <td class="align-middle">
                <div class="validate_btns_container d-flex align-items-stretch justify-content-around">

                    @php
                    $form_id = "editForm".$value->id;
                    $form_dom = "document.getElementById('editForm".$value->id."').submit();";
                    @endphp

                    <form action="{{ route($lang.'_bag_hours_types.index') }}" method="GET" class="invisible" id="{{ $form_id }}"> 
                        @csrf
                        <input type="hidden" name="edit_bag_hour_type_id" value="{{ $value->id }}">
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
                        <form action="{{ route('bag_hours_types.destroy',[$value->id, $lang]) }}" method="POST"> 
                            @csrf
                            @method('DELETE')  

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('message.delete') }} {{ $value->type_name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ __('message.confirm') }} {{ __('message.delete') }} {{ __('message.the_f') }} {{ __("message.bag_hour") }} <b>{{ $value->type_name }}</b> {{ __("message.in_the") }} {{ __("message.project") }} <b>{{ $value->project_name }}</b>?
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
    <li>{{__('message.no')}} {{__('message.bag_hours_types')}} {{__('message.to_show')}}</li>
    @endforelse
</tbody>
</table> 
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{ URL::asset('js/hour_bag_types_index.js') }}"></script>
<script>
var show_create_edit = @json($show_create_edit);
        if (show_create_edit) {
    $('#addEditChevronDown').css("transform", "rotate(180deg)");
    $('#addEditContainer').show(400);
    addEditCount = 2;
}
</script>
@endsection