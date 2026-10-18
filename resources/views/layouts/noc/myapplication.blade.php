@extends('layouts.noc.noc_master')
@section('content')
<style nonce="{{ $cspNonce }}">
    .bg-br-color-white-eleven{
        background-color: #0b5ed7; border-color: #0b5ed7; color: white;
    }
    .text-transform-cspnoc-twelve{
        text-transform: lowercase;
    }
    .min-withd-width-thirteen{
       min-width: 845px;
    }
    .bg-bbc-brc-cspnoc{
        background-color: #040464; border-block-color: #0a0a5c;border-color: rgb(3, 3, 90);
    }
</style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                    @if (session('success'))
                        <div class="col-lg-6 offset-lg-3">
                            <div class="alert alert-success alert-dismissible alert-alt fade show bg-br-color-white-eleven">
                                <strong> {{ session('success_user_add') }}</strong>
                            </div>
                        </div>
                    @endif
                <div class="card">
                    <div class="card-header">
                        <h4>List <span class="text-transform-cspnoc-twelve">of</span> Application</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display min-withd-width-thirteen">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Application No</th>
                                        <th>Query Raised Date</th>
                                        <th>Applicant Detail(Name,Email,Mobile)</th>
                                        <th>Embryo/oocyte/Semen</th>
                                        <th>Transfer(Within/Outside India)</th>
                                        <th>purpose(IVF/Surrogacy)</th>
                                        <th>Country/State(From - To)</th>
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
                                                    <a href="{{ url('noc/view_user_form/' . Crypt::encrypt($data->application_id) . '/' . Crypt::encrypt($data->level_id)) }}"
                                                        
                                                        class="btn btn-info bg-bbc-brc-cspnoc">
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
                                            {{-- <td>{!! status_name($data->level_id) !!}</td> --}}
                                             <td>Query Raised</td>
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
