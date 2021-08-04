@extends('layout')

@section('title', __('message.control_panel')." - ". __('message.bags_of_hours'))

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
            <h2>{{ __('message.bags_of_hours') }}</h2>
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

        <h3 class="d-inline-block m-0">{{ ($bag_hour_to_edit == null) ? __('message.add_new')." ".__('message.bag_hour') : __('message.edit')." ".__('message.bag_hour') }}</h3>
        <i class="bi bi-chevron-down px-2 bi bi-chevron-down fa-lg" id="addEditChevronDown"></i>
    </div>

    <div id="addEditContainer">
        <div class="alert alert-info m-2 mt-3">
            <strong>{{__('message.fields_are_required')}}</strong>
        </div>

        <form action="{{ ($bag_hour_to_edit == null) ? route('bag_hours.store',$lang) : route('bag_hours.update',[$bag_hour_to_edit->id, $lang]) }}" method="POST" class="px-3 pt-2">
            @csrf

            <div class="row">
                @php
                $json_value = old('type_id');
                if($json_value != null){
                $old_value_to_php = json_decode($json_value, true);
                $old_bag_id = $old_value_to_php['bht_id'];
                }
                
                @endphp
                <div class="form-group col-xs-12 col-sm-6 col-md-4 form_group_new_edit mb-md-0">
                    <label for="typeSelect">*{{ __('message.bag_hour_type') }}: </label>
                    @if (count($bags_hours_types) > 0)
                    <select name="type_id" id="typeSelect" class="form-control mb-">
                        @foreach($bags_hours_types as $key => $bag_hours_type)
                        <option value='{"bht_id":{{$bag_hours_type->id}} , "bht_hp":{{$bag_hours_type->hour_price}}}' 
                                @if($bag_hour_to_edit == null)
                                    @if($json_value != null)
                                        @if($old_bag_id == $bag_hours_type->id){{ "selected" }} @endif 
                                    @endif
                                @else
                                    @if($json_value === null)
                                        @if($bag_hour_to_edit->type_id == $bag_hours_type->id){{ "selected" }} @endif 
                                    @endif
                                @endif
                                
                            >{{$bag_hours_type->name}}</option>
                        @endforeach
                    </select>
                    <span>{{ __('message.hour_price') }}: </span><strong id="hourPrice"></strong><strong>€</strong>
                    @else
                    <li>{{ __('message.no') }} {{ __('message.bag_hour_type') }} {{ __('message.avalible') }} </li>
                    @endif
                    <a href="{{ route($lang."_bag_hours_types.index") }}" type="button" class="btn btn-sm general_button text-uppercase m-2">{{ __('message.create') }} {{ __('message.bag_hour_type') }}</a>
                </div>


                <div class="form-group col-xs-12 col-sm-6 col-md-4 form_group_new_edit mb-md-0">
                    <label for="projectSelect">*{{ __('message.project') }}: </label>
                    @if (count($bags_hours_types) > 0)
                    <select name="project_id" id="projectSelect" class="form-control mb-1">
                        @foreach($projects as $key => $project)
                        <option value="{{ $project->id }}">{{$project->name}}</option>
                        @endforeach
                    </select>
                    @else
                    <li>{{ __('message.no') }} {{ __('message.project') }} {{ __('message.avalible') }} </li>
                    @endif
                    <a href="{{ route($lang."_projects.create") }}" type="button" class="btn btn-sm general_button text-uppercase m-1">{{ __('message.create') }} {{ __('message.project') }}</a>

                </div>


                <div class="form-group col-xs-6 col-sm-3 col-md-2 form_group_new_edit mb-md-0">
                    <label for="contractedHours">*{{__('message.contracted_hours')}}:</label>
                    <input type="text" name="contracted_hours" class="form-control" id="contractedHours" placeholder="{{__('message.enter')." ".__('message.contracted_hours')}}" value="{{old('contracted_hours')}}">
                </div>


                <div class="form-group col-xs-6 col-sm-3 col-md-2 form_group_new_edit mb-md-0">
                    <label for="totalPrice">*{{__('message.total_price')}}:</label>
                    <input type="text" name="total_price" class="form-control" id="totalPrice" placeholder="{{__('message.enter')." ".__('message.total_price')}}" value="{{old('total_price')}}">
                </div>

                <div class="col-xs-12 col-sm-6 col-md-9">
                    <div class="alert alert-primary mt-2 mb-0 d-none" id="alertCalculatedPrice">
                        <strong></strong>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-3 d-flex justify-content-end align-items-start pr-1 pt-3 pt-sm-0">
                    <a class="btn general_button text-uppercase disabled m-0" id="calculatePrice">{{__('message.calculate_price')}}</a>
                </div>

                <div class="form-group d-flex justify-content-end col-12 pr-0 mb-0 pt-4">
                    <button type="submit" class="btn general_button mr-2">{{__('message.save')}}</button>
                </div>

            </div>
        </form>
    </div>

</div>


<form action="{{ route($lang.'_bag_hours.index') }}" method="GET">
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
                <strong>{{ __('message.bag_of_hours_type') }}:</strong>
                <input type="text" name="type" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.bag_of_hours_type') }}" value="@if(session('bag_hour_type') != '%'){{session('bag_hour_type')}}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('message.project') }}:</strong>
                <input type="text" name="project" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.project') }}" value="@if(session('bag_hour_project') != '%'){{session('bag_hour_project')}}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('message.contracted_hours') }}:</strong>
                <input type="text" name="contracted_hours_filter" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.contracted_hours') }}" value="@if(session('bag_hour_contracted_hours') != '%'){{session('bag_hour_contracted_hours')}}@endif">
            </div>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('message.hours_available') }}:</strong>
                <input type="text" name="hours_available" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.hours_available') }}" value="@if(session('bag_hour_hours_available') != '%'){{session('bag_hour_hours_available')}}@endif">
            </div>
        </div>
    </div>-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('message.hour_price') }}:</strong>
                <input type="text" name="hour_price" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.hour_price') }}" value="@if(session('bag_hour_hour_price') != '%'){{ session('bag_hour_hour_price') }}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('message.total_price') }}:</strong>
                <input type="text" name="total_price" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.total_price') }}" value="@if(session('bag_hour_total_price') != '%'){{ session('bag_hour_total_price') }}@endif">
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
                                    <input autocomplete="off" name="date_from" type="text" class="datepicker" value="@if(session('bag_hour_date_from') != ''){{session('bag_hour_date_from')}}@endif">
                                </div>
                                <div class="form-group">
                                    <strong>{{ __('message.to') }}:</strong>
                                    <input autocomplete="off" type="text" name="date_to" class="datepicker" value="@if(session('bag_hour_date_to') != ''){{session('bag_hour_date_to')}}@endif">
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
                    <option value="desc">{{ __('message.new_first') }}</option>
                    <option value="asc" @if(session('bag_hour_order') == 'asc'){{'selected'}}@endif >{{ __('message.old_first') }}</option>
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
                    <option value="50" @if(session('bag_hour_num_records') == 50){{'selected'}}@endif>50</option>
                    <option value="100" @if(session('bag_hour_num_records') == 100){{'selected'}}@endif>100</option>
                    <option value="all" @if(session('bag_hour_num_records') == 'all'){{'selected'}}@endif>{{ __('message.all') }}</option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success">{{ __('message.filter') }}</button>
</form>

<form action="{{ route('bag_hours.delete_filters') }}" method="POST"> 
    @csrf
    <input type="hidden" name="lang" value="{{ $lang }}">
    <button type="submit" class="btn btn-success">{{ __('message.delete_all_filters') }}</button>
</form>

<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3>{{ __('message.bags_of_hours_list') }}</h3>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route($lang.'_bag_hours.create') }}">{{ __('message.create') }} {{ __('message.new_f') }} {{ __('message.bag_of_hours') }}</a>
        </div>
    </div>
</div>

<table class="table">
    @if (count($data) > 0)
    <thead>
        <tr class="thead-light">
            <th>Nº</th>
            <th>{{ __('message.project') }}</th>
            <th>{{ __('message.customer_name') }}</th>
            <th>{{ __('message.type') }}</th>
            <th>{{ __('message.contracted_hours') }}</th>
            <th>{{ __('message.hours_available') }}</th>
            <th>{{ __('message.hour_price') }}</th>
            <th>{{ __('message.total_price') }}</th>
            <th>{{ __('message.created_at') }}</th>
            <th></th>
        </tr>
    </thead>
    @endif
    <tbody>
        @forelse ($data as $key => $value)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $value->project_name }}</td>
            <td>{{ $value->customer_name }}</td>
            <td>{{ $value->type_name }}</td>
            <td>{{ $value->contracted_hours }}h</td>
            <td>{{ $value->contracted_hours - $value->total_hours_project }}h</td>
            <td>{{ number_format($value->type_hour_price, 2, ',', '.') }}€</td>
            <td style="width:100px">{{ number_format($value->total_price, 2, ',', '.') }}€</td>
            <td>{{ $value->created_at->format('d/m/y') }}</td>
            <td class="align-middle">
                <div class="validate_btns_container d-flex align-items-stretch justify-content-around">

                    @php
                    $form_id = "editForm".$value->id;
                    $form_dom = "document.getElementById('editForm".$value->id."').submit();";
                    @endphp

                    <form action="{{ route($lang.'_bag_hours.index') }}" method="GET" class="invisible" id="{{ $form_id }}"> 
                        @csrf
                        <input type="hidden" name="edit_bag_hour_id" value="{{ $value->bag_hour_id }}">
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
                        <form action="{{ route('bag_hours.destroy',[$value->bag_hour_id, $lang]) }}" method="POST"> 
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
    <li>{{__('message.no')}} {{__('message.bags_of_hours')}} {{__('message.to_show')}}</li>
    @endforelse
</tbody>
</table> 
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{ URL::asset('js/hour_bags_index.js') }}"></script>
<script>
var show_create_edit = @json($show_create_edit);
if (show_create_edit) {
    $('#addEditChevronDown').css("transform", "rotate(180deg)");
    $('#addEditContainer').show(400);
    addEditCount = 2;
}


</script>
@endsection