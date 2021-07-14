@extends('layout')

@section('title', __('message.control_panel')." - ". __('message.home'))

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
        <div class="d-flex justify-content-end">
            <a class="btn btn-info mr-1" href="{{ route($lang.'_projects.create') }}">{{ __('message.create') }} {{ __('message.project') }}<a>
            <a class="btn btn-info mr-1" href="{{ route($lang.'_bag_hours.create') }}">{{ __('message.create') }} {{ __('message.bag_of_hours') }}<a>
            <a class="btn btn-info" href="{{ route($lang.'_time_entries.create') }}">{{ __('message.create') }} {{ __('message.time_entries') }}<a>
        </div>
    </div>
</div>

<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3> {{ __('message.unvalidated_time_entries') }}</h3>
        </div>
    </div>
</div>

<table class="table">
    @if (count($info_for_table) > 0)
    <thead>
        <tr>
            <th>Nº</th>
            <th>{{ __('message.user') }}</th>
            <th>{{ __('message.bag_hour_type') }}</th>
            <th>{{ __('message.project_name') }}</th>
            <th>{{ __('message.customer_name') }}</th>
            <th>{{ __('message.hours') }}</th>
            <th>{{ __('message.creation_day') }}</th>
        </tr>
    </thead>
        @endif
    <tbody class="b-0">
        @forelse ($info_for_table as $value)
    
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $value->user_name }}</td>
            <td>{{ $value->type_bag_hour_name }}</td>
            <td>{{ $value->project_name }} </td>
            <td>{{ $value->customer_name }}</td>
            <td>{{ $value->hour_entry_hours }}h</td>
            <td>{{ Carbon\Carbon::parse($value->hour_entry_created_at)->format('d/m/y') }}</td>
            <td class="align-middle">

                <div class="validate_btns_container d-flex align-items-stretch justify-content-around">
                    
                    <a href="{{ route('home_entry_hours.validate',[$value->hours_entry_id, $lang]) }}"  style="text-decoration: none" class="text-success">
                        <i class="bi bi-check-square-fill fa-lg"></i>
                    </a>
                </div>
                
            </td>
        </tr>
    
    @empty
    <li>{{__('message.no')}} {{__('message.time_entries')}} {{__('message.to_show')}}</li>
    @endforelse
    </tbody>
</table> 
<a class="btn general_button" href="{{ route('home_entry_hours.validate_all', $lang) }}">{{ __('message.validate_all_hours') }}</a>
<div id="paginationContainer">
    {!! $info_for_table->links() !!} 
</div>

@endsection

@section('js')
<script type="text/javascript" src="{{ URL::asset('js/home_index.js') }}"></script>
@endsection
