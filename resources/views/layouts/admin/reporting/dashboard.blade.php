@extends('layouts.admin.admin_master')

@section('title','Dynamic Reporting Dashboard')

@section('content')

<div class="container-fluid">

    @include('layouts.admin.reporting.partials.header')

    @include('layouts.admin.reporting.partials.statistics')

</div>

@endsection