@extends('layout')

@section('title', 'Control panel - Customers - Edit '.$customer->name)

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Type bag hour: {{ $customer->name }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route($lang.'_customers.index') }}"> Back</a>
        </div>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger mt-3">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="alert alert-success mt-2">
    <strong>Fields with * are required</strong>
</div>

<form action="{{ route('customers.update',['customer' => $customer->id, 'lang' => $lang ]) }}" method="POST">
    @csrf


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*Name:</strong>
                <input type="text" name="name" value="{{old('name', $customer->name)}}" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*Email:</strong>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{old('email', $customer->email)}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>*Phone:</strong>
                <input type="text" name="phone" class="form-control" placeholder="Enter Phone" value="{{old('phone', $customer->phone)}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="Enter Description">{{old('description', $customer->description)}}</textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

</form>
@endsection