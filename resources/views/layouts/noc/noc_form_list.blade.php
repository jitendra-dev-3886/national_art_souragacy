@extends('layouts.noc.noc_master')
@section('content')
<style nonce="{{ $cspNonce }}">
.text-transform-csp-noc-sixtyone{
text-transform: lowercase;
}
.bc-br-color-white-csp-noc-sixtytwo{
    background-color: #0b5ed7; border-color: #0b5ed7; color: white;
}
.bc-br-color-white-csp-noc-sixtythree{
  background-color: #13139d; border-block-color: #10107d; border-color: blue;
}
    
    
</style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (session('success_user_add'))
                    <div class="col-lg-6 offset-lg-3">
                        <div class="alert alert-success alert-dismissible alert-alt fade show bc-br-color-white-csp-noc-sixtytwo">
                            <strong> {{ session('success_user_add') }}</strong>
                        </div>
                    </div>
                @endif
               
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">NOC form Application List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Transfer</th>
                                        <th>Transfer <span class="text-transform-csp-noc-sixtyone">of</span></th>
                                        <th>Address</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>Date <span class="text-transform-csp-noc-sixtyone">of</span> Submission</th>
                                        <th>View</th>
                                        <th>Status</th>

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
                                                        class="btn btn-info bc-br-color-white-csp-noc-sixtythree">
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
                                            <td><a href="{{ route('noc.nocForm_view', ['id' => Crypt::encrypt($formList->id)]) }}"
                                                    class="link" target="_blank"> <i class="fa fa-eye"></i></a></td>
                                            <td>Under Process</td>
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
