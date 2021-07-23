@extends('layout')

@section('title', __('message.control_panel')." - ". __('message.projects'))

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
            <h2>{{ __('message.projects') }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route($lang.'_projects.create') }}">{{ __('message.create') }} {{ __('message.new') }} {{ __('message.project') }}</a>

        </div>
    </div>
</div>

<form action="{{ route($lang.'_projects.index') }}" method="GET" id="filtersForm"> 
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
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group" id="customerContainer">
                <strong>{{ __('message.customer_name') }}:</strong>
                <select name="customer_name2" id="customer" onchange="loadProjectsOfCustomer()" @if(count($customers) < 0) {{"disabled"}} @endif>
                    @if(count($customers) > 0)
                    <option value="%">{{ __('message.all_m') }}</option>
                    @foreach($customers as $key => $value)
                    <option value="{{$value->id}}">{{ $value->name }}</option>
                    @endforeach
                    @else
                    <option value="no_customers" selected>No customers available</option>
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('message.state') }}: </strong>
                <select name="state" id="state">
                    <option value="%" @if(session('project_state') == '%'){{'selected'}}@endif>{{ __('message.all_m') }}</option>
                    <option value="1" @if(session('project_state') == "1"){{'selected'}}@endif>{{ __('message.active') }}</option>
                    <option value="0" @if(session('project_state') == "0"){{'selected'}}@endif>{{ __('message.inactive') }}</option>

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
                                    <input autocomplete="off" name="date_from" type="text" class="datepicker" value="@if(session('project_date_from') != ''){{session('project_date_from')}}@endif">
                                </div>
                                <div class="form-group">
                                    <strong>{{ __('message.to') }}:</strong>
                                    <input autocomplete="off" type="text" name="date_to" class="datepicker" value="@if(session('project_date_to') != ''){{session('project_date_to')}}@endif">
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
                    <option value="desc">{{ __('message.new_first') }}</option>
                    <option value="asc" @if(session('project_order') == 'asc'){{'selected'}}@endif >{{ __('message.old_first') }}</option>
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
                    <option value="50" @if(session('project_num_records') == 50){{'selected'}}@endif>50</option>
                    <option value="100" @if(session('project_num_records') == 100){{'selected'}}@endif>100</option>
                    <option value="all" @if(session('project_num_records') == 'all'){{'selected'}}@endif>{{ __('message.all') }}</option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success">{{ __('message.filter') }}</button>
</form>


<form action="{{ route('projects.delete_filters') }}" method="POST"> 
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
            <a class="btn btn-success" href="{{ route($lang.'_projects.create') }}">{{ __('message.create') }} {{ __('message.new') }} {{ __('message.project') }}</a>
        </div>
    </div>
</div>

@php
$worked_hours_count = 0;
$contracted_hours_count = 0;
$hours_left_count = 0;
@endphp

<table class="table table-bordered">
    @if (count($data) > 0)
    <tr>
        <th>Nº</th>
        <th>{{ __('message.name') }}</th>
        <th>{{ __('message.customer_name') }}</th>
        <th>{{ __('message.state') }}</th>
        <th>{{ __('message.hours_worked') }}</th>
        <th>{{ __('message.contracted_hours') }}</th>
        <th>{{ __('message.hours_left') }}</th>
        <th>{{ __('message.description') }}</th>
        <th>{{ __('message.created_at') }}</th>
        <th>{{ __('message.action') }}</th>
    </tr>
    @endif
    @forelse ($data as $value)
    @php
    $worked_hours_count += $value->total_hours_project;
    $contracted_hours_count += $value->contracted_hours;

    $hours_left = $value->contracted_hours - $value->total_hours_project;
    if($hours_left > 0)
    $hours_left_count += $hours_left;
    @endphp
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $value->project_name }}</td>
        <td>{{ $value->customer_name }}</td>
        <td>@if($value->project_active){{__('message.active')}} @else{{__('message.inactive')}} @endif</td>
        <td>{{ $value->total_hours_project }}</td>
        <td>{{ $value->contracted_hours }}</td>
        <td>@if($value->contracted_hours != null){{ $hours_left }}@endif</td>

        <td>@if ($value->project_description == ''){{ __('message.no_description') }} @else {{ \Str::limit($value->description, 100) }} @endif</td>
        <td>{{ date('d/m/y', strtotime($value->created_at)) }}</td>
        <td>
            <form action="{{ route('projects.destroy',[$value->id, $lang]) }}" method="POST"> 
                <a class="btn btn-primary" href="{{ route($lang.'_projects.edit',$value->id) }}">{{ __('message.edit') }}</a>
                @csrf
                @method('DELETE')      
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                    {{ __('message.delete') }}
                </button>
                <a class="btn btn-primary" href="{{ route($lang.'_projects.add_remove_users',$value->id) }}">{{ __('message.add_remove_users') }}</a>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('message.delete') }} {{ $value->project_name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ __('message.confirm') }} {{ __('message.delete') }} {{ __('message.the') }} {{ __("message.project") }} <b>{{ $value->project_name }}</b>?
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
@if (count($data) > 0)
<div id="totalHourCount" class="row">
    <h4 class="table col-12">{{__('message.total_hours_count')}}</h4>
    <table class="table col-6 ml-3  text-center">
        <thead>
            <tr class="thead-light">
                <th>{{ __('message.hours_worked') }}</th>
                <th>{{ __('message.contracted_hours') }}</th>
                <th>{{ __('message.hours_left') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $worked_hours_count }}h</td>
                <td>{{ $contracted_hours_count }}h</td>
                <td>{{ $hours_left_count }}h</td>
            </tr>
        </tbody>
    </table>
</div>

@endif
<div id="paginationContainer">
    {!! $data->links() !!} 
</div>
@endsection
@section('js')
<script>
    
            function loadProjectsOfCustomer() {

                let customerId = document.getElementById('customer').value;

                if (customerId != "%") {

                    let formGroup = document.createElement("div");
                    formGroup.setAttribute('class', 'form-group');
                    formGroup.setAttribute('id', 'projectContainer');

                    let projects = $.grep(projects_json, function (e) {
                        return e.customer_id == customerId;
                    });

                    let projectSelectHtml = document.createElement("select");
                    projectSelectHtml.setAttribute("onchange", "loadUsersOfProject()");
                    projectSelectHtml.setAttribute("id", "projectSelect");

                    if (projects.length > 0) {

                        let option = document.createElement("option");
                        option.value = "%";
                        option.innerText = "{{__('message.all_m')}}";
                        projectSelectHtml.appendChild(option);
                        

                        for (project of projects) {

                            let option = document.createElement("option");
                            option.value = project.id;
                            option.innerText = project.name;

                            projectSelectHtml.appendChild(option);

                        }

                        formGroup.appendChild(projectSelectHtml);


                        if (document.getElementById('projectContainer') != null) {
                            document.getElementById('projectContainer').remove();
                        }



                        document.getElementById('customerContainer').after(formGroup);
                    } else {
                        if (document.getElementById('projectContainer') != null) {
                            document.getElementById('projectContainer').remove();
                        }

                        let formGroup = document.createElement("div");
                        formGroup.setAttribute('class', 'form-group');
                        formGroup.setAttribute('id', 'projectContainer');

                        let projectSelectHtml = document.createElement("select");
                        projectSelectHtml.setAttribute("onchange", "loadUsersOfProject()");
                        projectSelectHtml.setAttribute("id", "projectSelect");
                        projectSelectHtml.disabled = true;

                        let option = document.createElement("option");
                        option.value = "no_projects";
                        option.selected = true;
                        option.innerText = "{{__('message.no_projects_available')}}";

                        projectSelectHtml.appendChild(option);

                        formGroup.appendChild(projectSelectHtml);
                        document.getElementById('customerContainer').after(formGroup);
                    }

                } else {

                    if (document.getElementById('projectContainer') != null) {
                        document.getElementById('projectContainer').remove();
                    }

                    let formGroup = document.createElement("div");
                    formGroup.setAttribute('class', 'form-group');
                    formGroup.setAttribute('id', 'projectContainer');

                    let projectSelectHtml = document.createElement("select");
                    projectSelectHtml.setAttribute("onchange", "loadUsersOfProject()");
                    projectSelectHtml.setAttribute("id", "projectSelect");

                    let option = document.createElement("option");
                    option.value = "%";
                    option.innerText = "{{__('message.all_m')}}";
                    projectSelectHtml.appendChild(option);

                    for (project of projects_json) {

                        let option = document.createElement("option");
                        option.value = project.id;
                        option.innerText = project.name;

                        projectSelectHtml.appendChild(option);

                    }

                    formGroup.appendChild(projectSelectHtml);
                    document.getElementById('customerContainer').after(formGroup);
                }
                
                loadUsersOfProject()
            }
            
            function loadUsersOfProject() {
                let projectId = document.getElementById('projectSelect').value;
                
                let project = $.grep(projects_json, function (e) {
                    return e.id == projectId;
                });
                
                if(projectId == "%") {
                    
                }
                else if (projectId == 'no_projects') {
                    
                }
                else if (project.length > 0) {
                    if (project[0].users.length > 0) {
                        
                    }
                    else {
                        
                    }
                }
                
                console.log(project)
                
//                let usersInProject = project[0].users;
            }

var projects_json = @json($projects_json);
    console.log(projects_json);
    
    loadProjectsOfCustomer();

</script>
<script type="text/javascript" src="{{ URL::asset('js/projects_index.js') }}"></script>
@endsection