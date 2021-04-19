@extends('layout')

@section('title', 'Control panel - Company Info - Edit '.$company->name)

@section('content')
<div class="pull-right">
    <a class="btn btn-primary" href="{{ route($lang.'_company_info.index') }}">{{__('message.back')}}</a>
</div>
@endsection