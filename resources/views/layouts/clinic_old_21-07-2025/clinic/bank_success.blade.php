@extends('layouts.clinic.clinic_master')
@section('content')

<style nonce="{{$cspNonce}}">
    .csp-clinic-alert-primary {
        background-color: #0b5ed7c7;
        border-color: #0b5ed7;
        color: white;
    }

    .csp-clinic-alert-primary h4 {
        color: white;
    }

    .csp-clinic-btn-view {
        background-color: #0b49f9;
        border-color: #0b5ed7;
        color: white;
    }
</style>

<div class="container mt-5">
    <div class="alert alert-primary csp-clinic-alert-primary">
        @if(Session()->has('success'))
        <h4>{{ session('success') }}</h4>
        @endif

        <p><strong>Application Number:</strong> {{ $appNo }}</p>

        <a href="{{ route("clinic.bankForm_view", $app_bclinic_id) }}" class="btn btn csp-clinic-btn-view">
            <i class="fas fa-eye"></i> View Application Form
        </a>
    </div>   
</div>
@endsection
