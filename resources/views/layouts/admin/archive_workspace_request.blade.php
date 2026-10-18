
@extends('layouts.admin.admin_master')
@section('content')

 <style nonce="{{ $cspNonce }}">
    .csp-admin-message-alert{
        background-color: #0b5ed7; border-color: #0b5ed7; color: white;
    }
    .margin111-top {
        margin-top: 15px;
    }
</style>
    {{-- @php dd($medical_status->medical_report); @endphp --}}
 
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <style nonce="{{ $cspNonce }}">
                        .table tbody tr td:last-child { text-align: start; padding-right: 1.563rem; }
                        .table thead tr th:last-child { text-align: start; } -->
    </style>
    <script nonce="{{ $cspNonce }}" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif --}}

    
    <script nonce="{{ $cspNonce }}"  src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @if (session('success'))
        <div class="col-lg-6 offset-lg-3">
            <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-alert">
                <strong> {{ session('success') }}</strong>
            </div>
        </div>
    @endif


    <div class="container-fluid">
        {{-- <div class="row">
            <div class="col-12">
                <div class="col-xs-12">
                    <div class="alert alert-success col-xs-12" style="background-color: #0b0283;">
                        {{-- <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h4 style="margin: 0;color: white;">Application Number: {{ $data->appno }}</h4>

                        </div> --}}
                    {{-- </div>
                </div>
            </div>
        </div> --}} 


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><strong>Archive Work Space</strong></h5>
                    </div>
                    <div class="container mt-5">
                       
                  
                          <form action="{{ route('add_archive_approve') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            
                            <input type="hidden" name="id" value="{{ $data[0]->id }}"/>

                            @if($data[0]->archive_status == 0)
                            <input type="hidden" name="archive_status" value="{{ $data[0]->archive_status }}"/>
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" readonly id="Archive" name="archive_request" placeholder="Enter your Remarks" value="Archive Request">
                                </div>
                              </div> 
                              @elseif($data[0]->archive_status == 1)
                              <input type="hidden" name="archive_status" value="{{ $data[0]->archive_status }}"/>
                              <div class="mb-3 row">
                                  <label for="name" class="col-sm-2 col-form-label">Status</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" readonly id="Archive" name="archive_approved" placeholder="Enter your Remarks" value="Archive Approved">
                                  </div>
                                </div>

                                @elseif($data[0]->archive_status == 3)
                                <input type="hidden" name="archive_status" value="{{ $data[0]->archive_status }}"/>
                                <div class="mb-3 row">
                                    <label for="name" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" readonly id="Archive" name="un_archive_approved" placeholder="Enter your Remarks" value="Un Archive Approved">
                                    </div>
                                  </div>
                            
                            @else
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">Archive Status</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" readonly id="Archive" name="archive_request" placeholder="Enter your Remarks" value="Archive Request">
                                </div>
                              </div> 
                            @endif

                            <div class="mb-3 row">
                              <label for="name" class="col-sm-2 col-form-label">Remarks</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter your Remarks">
                              </div>
                            </div>       
                            <div class="mb-3 row">
                              <label for="email" class="col-sm-2 col-form-label">Description</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="description" placeholder="Enter your Description">
                              </div>
                            </div>                       
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </form>
                          
                      </div>
                </div>
            </div>
            </br>

        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
@endsection();

<script nonce="{{ $cspNonce }}"  src="{{ url('public/js/jquery.min.js') }}"></script>
