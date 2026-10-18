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
                                    <th>Email ID</th>
                                    <th>Role</th>                                           
                                    <th>Service</th>
                                    <th>Action</th>
                                    <!-- <th>Status</th> -->
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i =1;
                                @endphp
                                
                                @foreach ($userrolesaccesstable as $user_list)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $user_list->user->username}}</td>
                                        <td>{{ $user_list->user->email}}</td>
                                        <td>{{ $user_list->role->role_name  }}</td>
                                        <td>{{ $user_list->rolesAccess->service->service_name}}</td>

                                        <td><a href='{{ route('admin.service_approval',$user_list->rolesAccess->id) }}'>Send for approval</a></td>
                                     
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