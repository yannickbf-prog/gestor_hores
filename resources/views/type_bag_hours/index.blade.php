@extends('layout')

@section('title', 'Control panel - Type bag hours')

@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Bag hours types</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('type-bag-hours.create') }}">Create New Bag hour type</a>
        </div>
    </div>
</div>
<form action="{{ route('type-bag-hours.index') }}" method="GET"> 
    @csrf

    <div class="row py-2">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>Filters</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Name" value="@if(session('type_bag_hour_name') != '%'){{session('type_bag_hour_name')}}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Hour price:</strong>
                <input type="text" name="hour_price" class="form-control" placeholder="Hour price" value="@if(session('type_bag_hour_price') != '%'){{session('type_bag_hour_price')}}@endif">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success">Filter</button>
</form>

<form action="{{ route('type-bag-hours.delete_filters') }}" method="POST"> 
    @csrf
    <button type="submit" class="btn btn-success">Delete all filters</button>
</form>

<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3>Bag hours types list</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('type-bag-hours.create') }}">Create New Bag hour type</a>
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
            <form action="{{ route('type-bag-hours.destroy',$value->id) }}" method="POST"> 
                <a class="btn btn-primary" href="{{ route('type-bag-hours.edit',$value->id) }}">Edit</a>
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