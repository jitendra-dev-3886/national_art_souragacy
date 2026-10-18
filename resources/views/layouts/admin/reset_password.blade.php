@extends('layouts.admin.admin_master')
@section('content')
<div class="container">
    <h3>Send Password Reset Links</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
<link href="{{ url('public/css/select2.min.css') }}" rel="stylesheet">
<form action="{{ route('admin.resetpassword.submit') }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- hidden email from user table --}}
    <input type="hidden" name="hidden_email" value="{{ $users->first()->email ?? '' }}">
    <div class="mb-3">
        <label for="state"><strong>Select State</strong></label>
        <select name="stateid" id="state" class="form-control" required>
            <option value="">-- Select State --</option>
            @foreach($users as $user)
                <option value="{{ $user->state->state_id }}">{{ $user->state->state_name }}</option>
            @endforeach
        </select>
    </div>
  <div class="mb-3">
        <label for="email"><strong>Enter Email</strong></label>
        {{-- <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required> --}}
        <select name="email" id="emailSelect" class="form-control" required>
            <option value="">-- Select Email --</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="pdf"><strong>Upload PDF *</strong></label>
        <input type="file" name="resetfile" id="pdf" class="form-control" accept="application/pdf" required>
    </div>
    <button type="submit" class="btn btn-primary">send reset link</button>
</form>
<br>
</div>
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/select2.min.js') }}"></script>
<script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {
    // Initialize select2 for emails
    $('#emailSelect').select2({
        placeholder: "Select Email",
        allowClear: true,
        ajax: {
            url: "{{ route('ssa.users.by.state') }}", 
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    state_id: document.getElementById('state').value,
                    search: params.term
                };
            },
            processResults: function (data) {
                return { results: data };
            },
            cache: true
        }
    });

    // When state changes → reset email dropdown
    document.getElementById('state').addEventListener('change', function () {
        $('#emailSelect').val(null).trigger('change');
    });

});
</script>

@endsection