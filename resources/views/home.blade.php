@extends('layout')

@section('title', __('message.control_panel')." - ". __('message.home'))

@section('content')
<table class="table table-bordered">
    @if (count($info_for_table) > 0)
    <tr>
        <th>Nº</th>
        <th>{{ __('message.user') }}</th>
        <th>{{ __('message.bag_hour_type') }}</th>
        <th>{{ __('message.project_name') }}</th>
        <th>{{ __('message.customer_name') }}</th>
        <th>{{ __('message.hours') }}</th>
        <th>{{ __('message.creation_day') }}</th>
        <th>{{ __('message.action') }}</th>
    </tr>
    @endif
    @forelse ($info_for_table as $value)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $value->user_name }}</td>
        <td>{{ $value->type_bag_hour_name }}</td>
        <td>{{ $value->project_name }} </td>
        <td>{{ $value->customer_name }}</td>
        <td>{{ $value->hour_entry_hours }}h</td>
        <td>{{ Carbon\Carbon::parse($value->hour_entry_created_at)->format('d/m/y') }}</td>
        <td>
            @if($value->hour_entry_validate == '0')
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#validateModal">
                {{ __('message.validate') }}
            </button>
            <!-- Modal Validate-->
            <div class="modal fade" id="validateModal" tabindex="-1" role="dialog" aria-labelledby="validateModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('message.validate') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ __('message.confirm_validate') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('message.close') }}</button>
                            <a class="btn btn-success" href="{{ route('entry_hours.validate',[$value->hours_entry_id, $lang]) }}">{{ __('message.validate') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#invalidateModal">
                {{ __('message.invalidate') }}
            </button>
            <!-- Modal Invalidate-->
            <div class="modal fade" id="invalidateModal" tabindex="-1" role="dialog" aria-labelledby="invalidateModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">{{ __('message.invalidate') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ __('message.confirm_invalidate') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('message.close') }}</button>
                            <a class="btn btn-success" href="{{ route('entry_hours.invalidate',[$value->hours_entry_id, $lang]) }}">{{ __('message.invalidate') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </td>
        <td>{{ $value->hours_entry_id }}</td>
    </tr>
    @empty
    <li>{{__('message.no')}} {{__('message.time_entries')}} {{__('message.to_show')}}</li>
    @endforelse

</table> 
<div id="paginationContainer">
    {!! $info_for_table->links() !!} 
</div>

@endsection
