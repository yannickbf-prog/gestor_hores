@extends('layout')

@section('title', 'Control panel - Home')

@section('content')
    <h1>Home</h1>
    <h2>Unvalidated hour bags</h2>
    <table class="table table-bordered">
        <tr>
            <th>User</th>
            <th>Bag Hour Type</th>
            <th>Project name</th>
            <th>Customer name</th>
            <th>Hours</th>
            <th>Creation day</th>
            
        </tr>
        <tr>
            <td>albert21</td>
            <td>Creacio de xarxa informatica</td>
            <td>Electrodomestics OnClick</td>
            <td>Industries Lopez</td>
            <td>5h</td>
            <td>27/03/2021</td>
            <td>validar</td>
        </tr>
    </table>
@endsection
