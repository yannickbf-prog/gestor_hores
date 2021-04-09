@extends('layout')

@section('title', 'Control panel - Customers')

@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Customers</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('customers.create') }}">Create New Customer</a>
        </div>
    </div>
</div>
<form action="{{ route('customers.index') }}" method="GET"> 
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
                <input type="text" name="name" class="form-control" placeholder="Name" value="@if(session('customer_name') != '%'){{session('customer_name')}}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                <input type="text" name="email" class="form-control" placeholder="Email" value="@if(session('customer_email') != '%'){{session('customer_email')}}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Phone:</strong>
                <input type="text" name="phone" class="form-control" placeholder="Phone" value="@if(session('customer_phone') != '%'){{session('customer_phone')}}@endif">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success">Filter</button>
</form>

<form action="{{ route('customers.delete_filters') }}" method="POST"> 
    @csrf
    <button type="submit" class="btn btn-success">Delete all filters</button>
</form>

<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3>Customers list</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('customers.create') }}">Create New Customers</a>
        </div>
    </div>
</div>

<table class="table table-bordered">
    @if (count($data) > 0)
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Details</th>
        <th width="280px">Action</th>
    </tr>
    @endif
    @forelse ($data as $key => $value)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $value->name }}</td>
        <td>{{ $value->email }}</td>
        <td>{{ $value->phone }}</td>
        <td>{{ \Str::limit($value->description, 100) }}</td>
        <td>
            <form action="{{ route('customers.destroy',$value->id) }}" method="POST"> 
                <a class="btn btn-primary" href="{{ route('customers.edit',$value->id) }}">Edit</a>
                @csrf
                @method('DELETE')      
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @empty
    <li>No Customers to show</li>
    @endforelse
    
</table> 
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection