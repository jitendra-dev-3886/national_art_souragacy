@extends('layouts.noc.noc_master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>List of the Users with Role</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>User Name</th>
                                        <th>Email ID</th>
                                        <th>Role</th>
                                        <th>Service</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp

                                    @foreach ($userrolesaccesstable as $user_list)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $user_list->user->username }}</td>
                                            <td>{{ $user_list->user->email }}</td>
                                            <td>{{ $user_list->role->role_name }}</td>
                                            <td>{{ $user_list->rolesAccess->service->service_name }}</td>


                                            <td>

                                                @if ($user_list->rolesAccess->is_active == 2)
                                                    <a href="{{ route('admin.reject_approval', $user_list->rolesAccess->id) }}"
                                                        class="btn btn-warning">Deactivate</a>
                                                @elseif ($user_list->rolesAccess->is_active == 1)
                                                    <a href="{{ route('admin.accept_approval', $user_list->rolesAccess->id) }}"
                                                        class="btn btn-success">Activate</a>
                                                @endif


                                            </td>
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
