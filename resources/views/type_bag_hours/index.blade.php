@extends('layout')

@section('title', 'Control panel - Type bag hours')

@section('content')
    <h1>Home</h1>
    <p>lorem ipsumm</p>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($data as $key => $value)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ \Str::limit($value->description, 100) }}</td>
            
        </tr>
        @endforeach
    </table>  
@endsection