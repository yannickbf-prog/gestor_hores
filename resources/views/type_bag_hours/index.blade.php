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
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route($lang.'_bag_hours_types.create') }}">{{ __('message.create_new_type_hour_bag') }} </a>
        </div>
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
                <input type="text" name="name" class="form-control" placeholder="{{ __('message.enter')." ".__('message.name') }}" value="@if(session('type_bag_hour_name') != '%'){{session('type_bag_hour_name')}}@endif">
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

<table class="table table-bordered">
    @if (count($data) > 0)
    <tr>
        <th>Nº</th>
        <th>{{ __('message.name') }}</th>
        <th>{{ __('message.description') }}</th>
        <th>{{ __('message.hour_price') }}</th>
        <th>{{ __('message.created_at') }}</th>
        <th width="280px">{{ __('message.action') }}</th>
    </tr>
    @endif
    @forelse ($data as $key => $value)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $value->name }}</td>
        <td>@if ($value->description == "") {{ __('message.no_description') }} @else {{ \Str::limit($value->description, 100) }} @endif</td>
        <td>{{ number_format($value->hour_price, 2, ',', '.') }}€</td>
        <td>{{ $value->created_at->format('d/m/y') }}</td>
        <td>
            <form action="{{ route('bag_hours_types.destroy',[$value->id, $lang]) }}" method="POST"> 
                <a class="btn btn-primary" href="{{ route($lang.'_bag_hours_types.edit',$value->id) }}">{{ __('message.edit') }}</a>
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                    {{ __('message.delete') }}
                </button>
                 <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('message.delete') }} {{ $value->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ __('message.confirm') }} {{ __('message.delete') }} {{ __('message.the') }} {{ __("message.bag_hour_type") }} <b>{{ $value->name }}</b>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('message.close') }}</button>
                                <button type="submit" class="btn btn-success">{{ __('message.delete') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </td>
    </tr>
    @empty
    <li>{{__('message.no')}} {{__('message.bag_hours_types')}} {{__('message.to_show')}}</li>
    @endforelse

</table> 
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection
@section('js')
    <script type="text/javascript" src="{{ URL::asset('js/hour_bag_types_index.js') }}"></script>
@endsection