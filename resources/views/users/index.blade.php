@extends('layout')

@section('title', __('message.control_panel')." - ". __('message.users'))

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
            <h2>{{ __('message.users') }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route($lang.'_users.create') }}">{{ __('message.create') }} {{ __('message.new') }} {{ __('message.user') }}</a>

        </div>
    </div>
</div>

<div id="filterDiv" class="p-4 my-3">
    <div class="mb-4" id="filterTitleContainer">
        <div class="d-flex align-content-stretch align-items-center">
            <h3 class="d-inline-block m-0">Filtre</h3><i class=" px-2 bi bi-chevron-down fa-lg"></i>
        </div>
    </div>
    <div id="filtersContainer">
        <div class="row">

            <div class="form-group col-xs-3 col-sm-3 col-md-3">
                <strong>{{ __('message.surname') }}:</strong>
                <input type="text" name="surname" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.surname') }}" value="@if(session('user_surname') != '%'){{session('user_surname')}}@endif">
            </div>

            <div class="form-group col-xs-3 col-sm-3 col-md-3">
                <strong>{{ __('message.name') }}:</strong>
                <input type="text" name="name" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.name') }}" value="@if(session('user_name') != '%'){{session('user_name')}}@endif">
            </div>

            <div class="col-xs-3 col-sm-3 col-md-3 form-group">
                <strong>{{ __('message.email') }}:</strong>
                <input type="text" name="email" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.email') }}" value="@if(session('user_email') != '%'){{session('user_email')}}@endif">
            </div>

            <div class="col-xs-3 col-sm-3 col-md-3 form-group">
                <strong>{{ __('message.username') }}:</strong>
                <input type="text" name="username" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.username') }}" value="@if(session('user_username') != '%'){{session('user_username')}}@endif">
            </div>

            <div class="col-xs-3 col-sm-3 col-md-3 form-group">
                <strong>{{ __('message.phone') }}:</strong>
                <input type="text" name="phone" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.phone') }}" value="@if(session('user_phone') != '%'){{session('user_phone')}}@endif">
            </div>


            <div class="col-xs-3 col-sm-3 col-md-3 form-group">
                <strong>{{ __('message.role') }}:</strong>
                <select name="role" id="role" class="form-control form-select">
                    <option value="all">{{ __('message.all') }}</option>
                    <option value="admin" @if(session('user_role') == 'admin'){{'selected'}}@endif >{{ __('message.admin') }}</option>
                    <option value="user" @if(session('user_role') == 'user'){{'selected'}}@endif >{{ __('message.worker') }}</option>
                </select>
            </div>


            <div class="col-xs-6 col-sm-6 col-md-6 form-group align-self-end">
                
                <button type="button" class="btn m-0" id="datePopoverBtn" data-placement="top">{{ __('message.date_creation_interval') }}</button>

                <div class="popover fade bs-popover-top show invisible" id="datePopover" role="tooltip" style="position: absolute; transform: translate3d(-31px, -176px, 0px); top: 0px; left: 0px;" x-placement="top">
                    <div class="arrow" style="left: 114px;"></div>
                    <div class="popover-body">
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="close" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="form-group mt-2">
                                    <strong>{{ __('message.from') }}:</strong>
                                    <input autocomplete="off" name="date_from" type="text" class="datepicker form-control form-control-sm" value="@if(session('user_date_from') != ''){{session('user_date_from')}}@endif">
                                </div>
                                <div class="form-group">
                                    <strong>{{ __('message.to') }}:</strong><br>
                                    <input autocomplete="off" type="text" name="date_to" class="datepicker form-control form-control-sm" value="@if(session('user_date_to') != ''){{session('user_date_to')}}@endif">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div id="filterDiv" class="p-4 my-3">
    <div class="mb-4">
        <div class="d-flex align-content-stretch align-items-center">
            <h3 class="d-inline-block m-0">Filtre</h3><i class=" px-2 bi bi-chevron-down fa-lg"></i>
        </div>
    </div>
    <div>

        <form action="{{ route($lang.'_users.index') }}" method="GET"> 
            @csrf

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('message.surname') }}:</strong>
                        <input type="text" name="surname" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.surname') }}" value="@if(session('user_surname') != '%'){{session('user_surname')}}@endif">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('message.name') }}:</strong>
                        <input type="text" name="name" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.name') }}" value="@if(session('user_name') != '%'){{session('user_name')}}@endif">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('message.email') }}:</strong>
                        <input type="text" name="email" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.email') }}" value="@if(session('user_email') != '%'){{session('user_email')}}@endif">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('message.username') }}:</strong>
                        <input type="text" name="username" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.username') }}" value="@if(session('user_username') != '%'){{session('user_username')}}@endif">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('message.phone') }}:</strong>
                        <input type="text" name="phone" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.phone') }}" value="@if(session('user_phone') != '%'){{session('user_phone')}}@endif">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('message.role') }}:</strong>
                        <select name="role" id="role">
                            <option value="all">{{ __('message.all') }}</option>
                            <option value="admin" @if(session('user_role') == 'admin'){{'selected'}}@endif >{{ __('message.admin') }}</option>
                            <option value="user" @if(session('user_role') == 'user'){{'selected'}}@endif >{{ __('message.worker') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">

                        <button type="button" class="btn btn-md btn-primary" id="datePopoverBtn" data-placement="top">{{ __('message.date_creation_interval') }}</button>

                        <div class="popover fade bs-popover-top show invisible" id="datePopover" role="tooltip" style="position: absolute; transform: translate3d(-31px, -146px, 0px); top: 0px; left: 0px;" x-placement="top">
                            <div class="arrow" style="left: 114px;"></div>
                            <div class="popover-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="button" class="close" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="form-group">
                                            <strong>{{ __('message.from') }}:</strong>
                                            <input autocomplete="off" name="date_from" type="text" class="datepicker" value="@if(session('user_date_from') != ''){{session('user_date_from')}}@endif">
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ __('message.to') }}:</strong>
                                            <input autocomplete="off" type="text" name="date_to" class="datepicker" value="@if(session('user_date_to') != ''){{session('user_date_to')}}@endif">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('message.order') }}:</strong>
                        <select name="order" id="order">
                            <option value="asc">{{ __('message.old_first') }}</option>
                            <option value="desc" @if(session('user_order') == 'desc'){{'selected'}}@endif>{{ __('message.new_first') }}</option>
                        </select>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>{{ __('message.number_of_records') }}: </strong>
                        <select name="num_records" id="numRecords">
                            <option value="10">10</option>
                            <option value="50" @if(session('user_num_records') == 50){{'selected'}}@endif>50</option>
                            <option value="100" @if(session('user_num_records') == 100){{'selected'}}@endif>100</option>
                            <option value="all" @if(session('user_num_records') == 'all'){{'selected'}}@endif>{{ __('message.all') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">{{ __('message.filter') }}</button>
        </form>

    </div>


</div>

<form action="{{ route('users.delete_filters') }}" method="POST"> 
    @csrf
    <input type="hidden" name="lang" value="{{ $lang }}">
    <button type="submit" class="btn btn-success">{{ __('message.delete_all_filters') }}</button>
</form>
<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3>{{ __('message.projects_list') }}</h3>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route($lang.'_users.create') }}">{{ __('message.create') }} {{ __('message.new') }} {{ __('message.user') }}</a>
        </div>
    </div>
</div>

<table class="table table-striped">
    @if (count($data) > 0)
    <thead class="sticky-top table">
        <tr style="background-color: white;">
            <td colspan="10" style="height: 7px" class="border-top-0"></td>
        </tr>
        <tr class="thead-light">
            <th>Nº</th>
            <th>{{ __('message.username') }}</th>
            <th>{{ __('message.name') }}</th>
            <th>{{ __('message.surname') }}</th>
            <th>{{ __('message.email') }}</th>
            <th>{{ __('message.phone') }}</th>
            <th>{{ __('message.description') }}</th>
            <th>{{ __('message.role') }}</th>
            <th>{{ __('message.created_at') }}</th>
            <th>{{ __('message.action') }}</th>
        </tr>
    </thead>

    @endif
    <tbody>
        @forelse ($data as $key => $value)
        <tr class="table-striped">
            <td>{{ ++$i }}</td>
            <td>{{ $value->nickname }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->surname }}</td>
            <td>{{ $value->email }}</td>
            <td>{{ $value->phone }}</td>
            <td>@if ($value->description == ''){{ __('message.no_description') }} @else {{ \Str::limit($value->description, 100) }} @endif</td>
            <td>{{ ($value->role=="user")? __('message.worker') : __('message.admin') }} </td>
            <td>{{ $value->created_at->format('d/m/y') }}</td>
            <td>
                <form action="{{ route('users.destroy',[$value->id, $lang]) }}" method="POST"> 
                    <a class="btn btn-primary" href="{{ route($lang.'_users.edit',$value->id) }}">{{ __('message.edit') }}</a>
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
                                    {{ __('message.confirm') }} {{ __('message.delete') }} {{ __('message.the') }} {{ __("message.customer") }} <b>{{ $value->name }}</b>?
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
    <li>{{__('message.no')}} {{__('message.customers')}} {{__('message.to_show')}}</li>
    @endforelse
</tbody>
</table> 
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{ URL::asset('js/users_index.js') }}"></script>
@endsection