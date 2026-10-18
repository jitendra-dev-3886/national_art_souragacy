@extends('layouts.noc.noc_master')
@section('content')
<style nonce="{{ $cspNonce }}">
    .text-transfer-lowercase-csp-noc{
        text-transform: lowercase;
    }
    
</style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                    @if (session('success'))
                        <div class="col-lg-6 offset-lg-3">
                            <div class="alert alert-success alert-dismissible alert-alt fade show"
                                style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;">
                                <strong> {{ session('success_user_add') }}</strong>
                            </div>
                        </div>
                    @endif
                <div class="card">
                    <div class="card-header">
                        <h4>List <span class="text-transfer-lowercase-csp-noc">of</span> Application</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Application No</th>
                                        <th>Receiving Date</th>
                                        <th>Name <span style="text-transform: lowercase;">of</span> Applicant</th>
                                        <th>Email ID</th>
                                        <th>Address</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>status</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($userdata as $data)
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            @if ($data->level_id == 11)
                                                <td>{{ $data->application_no }}</a></td>
                                            @else
                                                <td>
                                                    <a href="{{ url('noc/view_user_form_foreigner/' . Crypt::encrypt($data->application_id) . '/' . Crypt::encrypt($data->level_id)) }}"
                                                        style="background-color: #040464; border-block-color: #0a0a5c;border-color: rgb(3, 3, 90);"
                                                        class="btn btn-info">
                                                        {{ $data->application_no }}
                                                    </a>
                                                </td>
                                            @endif

                                            <td>{{ $data->created_at }}</td>
                                            <td>{{ $data->name_applicant }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->address }}</td>
                                            <td>{{ $data->state }}</td>
                                            <td>{{ $data->district }}</td>
                                            <td>{!! status_name_foreigner($data->level_id) !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
