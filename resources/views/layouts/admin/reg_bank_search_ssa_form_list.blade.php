@extends('layouts.admin.ssa_master')
@section('content')

    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div{
            background-color: #141481; border-color: #0b5ed7; color: white;
        }
        .csp-admin-table{
            min-width: 845px;
        }
        .csp-admin-red-color{
            color:red;
        }
        .csp-admin-bank-form{
            display: flex; align-items: center;
        }
        .csp-admin-form-input{
            width: 300px; margin-bottom: 10px; margin-right: 10px; display: inline-block;
        }
        .csp-admin-inline-block{
            display: inline-block;
        }

    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (session('upd_success'))
                <div class="col-lg-6 offset-lg-3">
                    <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-div">
                        <strong> {{ session('upd_success') }}</strong>
                    </div>
                </div>
            @endif
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Applications for the ART Bank</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display csp-admin-table">
                              
                                @if(session('error'))
                                <p class="csp-admin-red-color">{{ session('error') }}</p>
                            @endif
                            
                            <form method="GET" action="{{ route('admin.regbanksearchApplication') }}" class="csp-admin-bank-form">
                                <input type="text" id="searchApplicationNo" name="application_no" placeholder="Enter Application No."
                                    class="form-control csp-admin-form-input" value="{{ request('application_no') }}">
                                <button type="submit" class="btn btn-primary csp-admin-inline-block" >Search</button>
                            </form>
                            
                            @if(isset($errorMessage))
                                <p class="csp-admin-red-color">{{ $errorMessage }}</p>
                            @endif
                            
                            @if(isset($ssabankformList) && count($ssabankformList) > 0)
                                <div id="result">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Application No.</th>
                                                <th>Clinic Name</th>
                                                <th>Email ID</th>
                                                <th>Address</th>
                                                <th>State</th>
                                                <th>District</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ssabankformList as $key => $form)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $form->bankclinics->bapp_no->applicationno ?? 'N/A' }}</td>
                                                    <td>{{ $form->clinicname ?? 'N/A' }}</td>
                                                    <td>{{ $form->email ?? 'N/A' }}</td>
                                                    <td>{{ $form->address ?? 'N/A' }}</td>
                                                    <td>{{ $form->state ?? 'N/A' }}</td>
                                                    <td>{{ $form->district ?? 'N/A' }}</td>
                                                    <td>
                                                        @php
                                                $registered = $regssabankformList->firstWhere('id', $form->id);
                                               
                                            @endphp
                                            @if (empty($registered))
                                                <a href="{{ route('admin.reg_receivedbankssaForm_list', ['id' => Crypt::encrypt($form->id)]) }}" class="link">
                                                    Action
                                                </a>                                              
                                            @else
                                                <span>-</span>
                                            @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            
                            
                                {{-- <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($ssaartformList as $formList)
                                   
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ @$formList->artclinics->app_no->applicationno }}</td>
                                            <td>{{ @$formList->clinicname }}</td>
                                            <td>{{ @$formList->email }}</td>
                                            <td>{{ @$formList->address }}</td>
                                            <td>{{ @$formList->state }}</td>
                                            <td>{{ @$formList->district }}</td>
                                            <td>
                                                @if (@$formList->artclinics->app_received == 'received')
                                                    <span>-</span>
                                                @else
                                                   
                                                    <a href="{{ route('admin.receivedssaForm_list',['id' => Crypt::encrypt($formList->artclinics->id)]) }}" class="link">
                                                        Action
                                                    </a>
                                                @endif
                                            </td>    
                                        </tr>
                                    @endforeach
                                </tbody> --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   
@endsection
