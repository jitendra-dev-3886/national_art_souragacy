@extends('layouts.admin.admin_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
        .csp-admin-table{
            min-width: 845px;
        }

    </style>
<div class="container-fluid">


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">List of the Users</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display csp-admin-table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>User Name</th>
                                    <th>Designation</th>
                                    <th>Email ID</th>
                                    <th>Mobile Number</th>
                                    <th>Address</th>
                                    <!-- <th>Status</th> -->
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i =1;
                                @endphp
                                @foreach ($get_userData as $user_list)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $user_list->username }}</td>
                                        <td>{{ $user_list->designation }}</td>
                                        <td>{{ $user_list->email }}</td>
                                        <td>{{ $user_list->mobile_no }}</td>
                                        <td>{{ $user_list->address }}</td>
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