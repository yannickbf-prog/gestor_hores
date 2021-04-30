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
                <input type="text" name="name" class="form-control" placeholder="Name" value="@if(session('type_bag_hour_name') != '%'){{session('type_bag_hour_name')}}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('message.hour_price') }}:</strong>
                <input type="text" name="hour_price" class="form-control" placeholder="Hour price" value="@if(session('type_bag_hour_price') != '%'){{session('type_bag_hour_price')}}@endif">
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
    <button type="submit" class="btn btn-success">{{ __('message.filter') }}</button>
</form>

<form action="{{ route('type-bag-hours.delete_filters') }}" method="POST"> 
    @csrf
    <input type="hidden" name="lang" value="{{ $lang }}">
    <button type="submit" class="btn btn-success">{{ __('message.delete_all_filters') }}</button>
</form>

<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3>Bag hours types list</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route($lang.'_bag_hours_types.create') }}">{{ __("message.create")." ".__("message.new")." ".__("message.bag_hours_types") }}</a>
        </div>
    </div>
</div>

<table class="table table-bordered">
    @if (count($data) > 0)
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Hour price</th>
        <th>Details</th>
        <th width="280px">Action</th>
    </tr>
    @endif
    @forelse ($data as $key => $value)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $value->name }}</td>
        <td>{{ $value->hour_price }}€</td>
        <td>@if ($value->description == "") {{ 'No description' }} @else {{ \Str::limit($value->description, 100) }} @endif</td>
        <td>
            <form action="{{ route('bag_hours_types.destroy',[$value->id, $lang]) }}" method="POST"> 
                <a class="btn btn-primary" href="{{ route($lang.'_bag_hours_types.edit',$value->id) }}">Edit</a>
                @csrf
                @method('DELETE')
                
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @empty
    <li>No Bag hours types to show</li>
    @endforelse

</table> 
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection