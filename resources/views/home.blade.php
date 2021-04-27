@extends('layout')

@section('title', 'Control panel - Home')

@section('content')
    <h1>{{ __('message.home') }}</h1>
    <h2>{{ __('message.unvalidated_hour_bags') }}</h2>
    <table class="table table-bordered">
        <tr>
            <th>{{ __('message.user') }}</th>
            <th>{{ __('message.bag_hour_type') }}</th>
            <th>{{ __('message.project_name') }}</th>
            <th>{{ __('message.customer_name') }}</th>
            <th>{{ __('message.hours') }}</th>
            <th>{{ __('message.creation_day') }}</th>
            
        </tr>
        <tr>
            <td>albert21</td>
            <td>Creacio de xarxa informatica</td>
            <td>Electrodomestics OnClick</td>
            <td>Industries Lopez</td>
            <td>5h</td>
            <td>27/03/2021</td>
            <td>{{ __('message.validate') }}</td>
        </tr>
    </table>
@endsection
