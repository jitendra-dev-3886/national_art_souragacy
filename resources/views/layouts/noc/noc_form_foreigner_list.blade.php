@extends('layouts.noc.noc_master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="col-lg-6 offset-lg-3">
                        <div class="alert alert-success alert-dismissible alert-alt fade show"
                            style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;">
                            <strong> {{ session('success') }}</strong>
                        </div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">NOC foreigner form Application List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Transfer</th>
                                        <th>Transfer <span style="text-transform: lowercase;">of</span></th>
                                        <th>Address</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>Date <span style="text-transform: lowercase;">of</span> Submission</th>
                                        <th>View</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($nocformList as $formList)
                                        <tr>
                                            <td>{{ $i++ }}</td>

                                            @if ($formList->level_id == 4)
                                                <td>
                                                    <a href="{{ url('noc/view_user_form/' . Crypt::encrypt($formList->application_id) . '/' . Crypt::encrypt($formList->level_id)) }}"
                                                        style="background-color: #13139d; border-block-color: #10107d; border-color: blue;"
                                                        class="btn btn-info">
                                                        {{ $formList->application_no }}
                                                    </a>
                                                </td>
                                            @else
                                                <td>
                                                    {{ $formList->application_no }}
                                                </td>
                                            @endif


                                            <td>{{ $formList->transfer }}</td>
                                            <td>{{ $formList->transfer_of }}</td>
                                            <td>{{ $formList->address }}</td>
                                            <td>{{ $formList->state ?? 'N/A' }}</td>
                                            <td>{{ $formList->district ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($formList->created_at)->format('d-m-Y H:i:s') }}</td>
                                            <td><a href="{{ route('noc.nocFormnocFormForeigner_view', ['id' => Crypt::encrypt($formList->id)]) }}"
                                                    class="link" target="_blank"> <i class="fa fa-eye"></i></a></td>

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
