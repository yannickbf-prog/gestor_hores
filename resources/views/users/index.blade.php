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
    </div>
</div>



@if ($errors->any())
<div class="alert alert-danger mt-3">
    <strong>{{__('message.woops!')}}</strong> {{__('message.input_problems')}}<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ ucfirst($error) }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="pt-1 create_edit_container">
    <h3>{{ __('message.add_new')." ".__('message.user') }}</h3>
    <strong class="ml-2">{{__('message.fields_are_required')}}</strong>
    <form action="{{ ($user_to_edit == null) ? route('users.store',$lang) : route('users.update',[$user_to_edit->id, $lang]) }}" method="POST" class="px-3 pt-4">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-2 form-group form_group_new_edit">
                <strong>*{{__('message.username')}}:</strong>
                <input type="text" name="nickname" class="form-control" placeholder="{{__('message.enter')." ".__('message.username')}}" value="{{ ($user_to_edit == null) ? old('nickname') : old('nickname', $user_to_edit->nickname) }}">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-2 form-group form_group_new_edit">
                <strong>*{{__('message.name')}}:</strong>
                <input type="text" name="name" class="form-control" placeholder="{{__('message.enter')." ".__('message.name')}}" value="{{ ($user_to_edit == null) ? old('name') : old('name', $user_to_edit->name) }}">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 form-group form_group_new_edit">

                <strong>*{{__('message.surname')}}:</strong>
                <input type="text" name="surname" class="form-control" placeholder="{{__('message.enter')." ".__('message.surname')}}" value="{{ ($user_to_edit == null) ? old('surname') : old('surname', $user_to_edit->surname) }}">

            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 form-group form_group_new_edit">

                <strong>*{{__('message.email')}}:</strong>
                <input type="email" name="email" class="form-control" placeholder="{{__('message.enter')." ".__('message.email')}}" value="{{ ($user_to_edit == null) ? old('email') : old('email', $user_to_edit->email) }}">

            </div>
            <div class="col-xs-12 col-sm-6 col-md-2 form-group form_group_new_edit">

                <strong>{{__('message.phone')}}:</strong>
                <input type="text" name="phone" class="form-control" placeholder="{{__('message.enter')." ".__('message.phone')}}" value="{{ ($user_to_edit == null) ? old('phone') : old('phone', $user_to_edit->phone) }}">

            </div>
            <div class="col-xs-12 col-sm-8 col-md-5 form-group form_group_new_edit">

                <strong>{{__('message.observations')}}:</strong>
                <textarea class="form-control" name="description" placeholder="{{__('message.enter')." ".__('message.observations')}}">{{ ($user_to_edit == null) ? old('description') : old('description', $user_to_edit->description) }}</textarea>

            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 form-group form_group_new_edit">

                <strong>*{{__('message.password')}}:</strong>
                <input type="password" id="password" name="password" autocomplete="new-password" class="form-control" placeholder="{{__('message.enter')." ".__('message.password')}}" value="{{ ($user_to_edit == null) ? old('password') : old('password', $user_to_edit->password) }}">

            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 form-group form_group_new_edit">

                <strong>*{{__('message.password_confirm')}}:</strong>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="{{__('message.enter')." ".__('message.password')}}" value="{{ ($user_to_edit == null) ? old('password_confirmation') : old('password_confirmation', $user_to_edit->surname) }}">

            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 form-group form_group_new_edit">

                <strong>{{ __('message.role') }}:</strong><br>
                <input type="radio" id="user" name="role" value="user" checked>
                <label for="user">{{ __('message.worker') }}</label><br>
                @php
                $checked = "";
                if($user_to_edit == null) {
                    if(old('role') == "admin") {
                        $checked = 'checked';
                    }
                }
                else {
                    if($user_to_edit->role == "admin") {
                        $checked = 'checked';
                    }
                    else {
                        $checked = '';
                    }
                    
                    if(old('role') !== null) {
                        if(old('role') == "admin") {
                            $checked = 'checked';
                        }
                        else {
                            $checked = '';
                        }
                    }
                    
                }
                @endphp
                <input type="radio" id="admin" name="role" value="admin" {{$checked}}>
                <label for="admin">{{ __('message.admin') }}</label><br>  

            </div>

            <div class="form-group d-flex justify-content-end col-12 pr-0 mb-0">
                <button type="submit" class="btn general_button">{{ __('message.save') }}</button>
            </div>
        </div>
    </form>
</div>

<div id="filterDiv" class="p-4 my-3">
    <div class="mb-4" id="filterTitleContainer">
        <div class="d-flex align-content-stretch align-items-center">
            <h3 class="d-inline-block m-0">Filtre</h3><i class=" px-2 bi bi-chevron-down fa-lg"></i>
        </div>
    </div>
    <div id="filtersContainer">
        <form action="{{ route($lang.'_users.index') }}" method="GET" class="row"> 
            @csrf

            <div class="form-group col-xs-12 col-sm-6 col-md-3">
                <strong>{{ __('message.surname') }}:</strong>
                <input type="text" name="surname" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.surname') }}" value="@if(session('user_surname') != '%'){{session('user_surname')}}@endif">
            </div>

            <div class="form-group col-xs-12 col-sm-6 col-md-3">
                <strong>{{ __('message.name') }}:</strong>
                <input type="text" name="name" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.name') }}" value="@if(session('user_name') != '%'){{session('user_name')}}@endif">
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 form-group">
                <strong>{{ __('message.email') }}:</strong>
                <input type="text" name="email" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.email') }}" value="@if(session('user_email') != '%'){{session('user_email')}}@endif">
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 form-group">
                <strong>{{ __('message.username') }}:</strong>
                <input type="text" name="username" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.username') }}" value="@if(session('user_username') != '%'){{session('user_username')}}@endif">
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 form-group">
                <strong>{{ __('message.phone') }}:</strong>
                <input type="text" name="phone" class="form-control" placeholder="{{__('message.enter')}} {{ __('message.phone') }}" value="@if(session('user_phone') != '%'){{session('user_phone')}}@endif">
            </div>


            <div class="col-xs-12 col-sm-6 col-md-3 form-group">
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

            <div class="form-group d-flex justify-content-end mb-0 col-12">
                <a href="{{ route('users.delete_filters', $lang) }}" class="btn general_button mr-0 mb-2">{{ __('message.delete_all_filters') }}</a>
                <button type="submit" class="btn general_button mr-0 mb-2">{{ __('message.filter') }}</button>
            </div>

        </form>
    </div>
</div>


<div class="row py-2">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h3>{{ __('message.user_list') }}</h3>
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
            <th>{{ __('message.surname') }}</th>
            <th>{{ __('message.name') }}</th>
            <th>{{ __('message.email') }}</th>
            <th>{{ __('message.phone') }}</th>
            <th>{{ __('message.observations') }}</th>
            <th>{{ __('message.role') }}</th>
            <th>{{ __('message.created_at') }}</th>
            <th></th>
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
            <td>@if ($value->description == ''){{ __('message.no_observations') }} @else {{ \Str::limit($value->description, 100) }} @endif</td>
            <td>{{ ($value->role=="user")? __('message.worker') : __('message.admin') }} </td>
            <td>{{ $value->created_at->format('d/m/y') }}</td>
            <td class="align-middle">
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




                <div class="validate_btns_container d-flex align-items-stretch justify-content-around">
                    

                    @php
                    $form_id = "editForm".$value->id;
                    $form_dom = "document.getElementById('editForm".$value->id."').submit();";
                    @endphp

                    <form action="{{ route($lang.'_users.index') }}" method="GET" class="invisible" id="{{ $form_id }}"> 
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $value->id }}">
                    </form>

                    <a style="text-decoration: none" class="text-dark">
                        <i onclick="{{ $form_dom }}" class="bi bi-pencil-fill fa-lg"></i>
                    </a>

            </td>
        </tr>
        @empty
    <li>{{__('message.no')}} {{__('message.customers')}} {{__('message.to_show')}}</li>
    @endforelse
</tbody>
</table> 
@if (count($data) > 0)
<form action="{{ route('users.change_num_records', $lang) }}" method="GET"> 
    @csrf
    <div class="form-group d-flex align-items-center">
        <strong>{{ __('message.number_of_records') }}:</strong>
        <select name="num_records" id="numRecords" onchange="this.form.submit()" class="form-control form-select ml-2">
            <option value="10">10</option>
            <option value="50" @if(session('users_num_records') == 50){{'selected'}}@endif>50</option>
            <option value="100" @if(session('users_num_records') == 100){{'selected'}}@endif>100</option>
            <option value="all" @if(session('users_num_records') == 'all'){{'selected'}}@endif>{{ __('message.all') }}</option>
        </select>
    </div>
</form>
@endif
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{ URL::asset('js/users_index.js') }}"></script>
@endsection