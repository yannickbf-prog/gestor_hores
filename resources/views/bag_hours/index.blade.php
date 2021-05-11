@extends('layout')

@section('title', __('message.control_panel')." - ". __('message.bags_of_hours'))

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
            <h2>{{ __('message.bags_of_hours') }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route($lang.'_bag_hours.create') }}">{{ __('message.create') }} {{ __('message.new') }} {{ __('message.bags_of_hours') }}</a>

        </div>
    </div>
</div>
<form action="{{ route($lang.'_bag_hours.index') }}" method="GET">
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
                <input type="text" name="name" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.name') }}" value="@if(session('project_name') != '%'){{session('project_name')}}@endif">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('message.customer_name') }}:</strong>
                <input type="text" name="customer_name" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.customer_name') }}" value="@if(session('project_customer_name') != '%'){{session('project_customer_name')}}@endif">
            </div>
        </div>
    </div>
    
    <button type="submit" class="btn btn-success">{{ __('message.filter') }}</button>
</form>

<form action="{{ route('bag_hours.delete_filters') }}" method="POST"> 
    @csrf
    <input type="hidden" name="lang" value="{{ $lang }}">
    <button type="submit" class="btn btn-success">{{ __('message.delete_all_filters') }}</button>
</form>

<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3>{{ __('message.bags_of_hours_list') }}</h3>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route($lang.'_bag_hours.create') }}">{{ __('message.create') }} {{ __('message.new') }} {{ __('message.bags_of_hours') }}</a>
        </div>
    </div>
</div>

<table class="table table-bordered">
    @if (count($data) > 0)
    <tr>
        <th>Nº</th>
        <th>{{ __('message.bag_of_hours_type') }}</th>
        <th>{{ __('message.project') }}</th>
        <th>{{ __('message.bag_of_hours_type_description') }}</th>
        <th>{{ __('message.contracted_hours') }}</th>
        <th>{{ __('message.hours_available') }}</th>
        <th>{{ __('message.total_price') }}</th>
        <th>{{ __('message.created_at') }}</th>
        <th>{{ __('message.action') }}</th>
    </tr>
    @endif
    @forelse ($data as $key => $value)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $value->name }}</td>
        <td>{{ $value->customer_name }}</td>
        <td>@if($value->active){{__('message.active')}} @else{{__('message.inactive')}} @endif</td>
        <td>@if ($value->description == ''){{ __('message.no_description') }} @else {{ \Str::limit($value->description, 100) }} @endif</td>
        <td>{{ $value->created_at->format('d/m/y') }}</td>
        <td>
            <form action="{{ route('projects.destroy',[$value->id, $lang]) }}" method="POST"> 
                <a class="btn btn-primary" href="{{ route($lang.'_projects.edit',$value->id) }}">{{ __('message.edit') }}</a>
                @csrf
                @method('DELETE')      
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                    {{ __('message.delete') }}
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('message.delete') }} {{ $value->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ __('message.confirm') }} {{ __('message.delete') }} {{ __('message.the') }} {{ __("message.project") }} <b>{{ $value->name }}</b>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('message.close') }}</button>
                                <button type="submit" class="btn btn-success">{{ __('message.delete') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
        </td>
    </tr>
    @empty
    <li>{{__('message.no')}} {{__('message.projects')}} {{__('message.to_show')}}</li>
    @endforelse

</table> 
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection
@section('js')
    <script type="text/javascript" src="{{ URL::asset('js/projects_index.js') }}"></script>
@endsection