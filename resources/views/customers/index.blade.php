@extends('layout')

@section('title', 'Control panel - Customers')

@section('content')

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
            <form action="{{ route('type-bag-hours.destroy',$value->id) }}" method="POST"> 
                <a class="btn btn-primary" href="{{ route('type-bag-hours.edit',$value->id) }}">Edit</a>
                @csrf
                @method('DELETE')      
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @empty
    <li>Not Bag hours types to show</li>
    @endforelse
    
</table> 
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection