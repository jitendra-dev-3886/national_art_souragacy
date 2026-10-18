@extends('layouts.noc.noc_master') 
@section('content')


<style nonce="{{$cspNonce}}">
    .csp-clinic-alert-darkblue {
        background-color: #141481;
        color: white;
        padding: 10px;
    }

    .csp-clinic-alert-darkblue h4 {
        margin: 0;
        color: white;
    }

    .csp-clinic-table {
        min-width: 845px;
    }

    .csp-clinic-pdf-icon {
        font-size: 50px;
        color: #af0f0f;
    }

    .csp-clinic-upload-button {
        margin-left: 625px;
        margin-top: 19px;
        background-color: #141481;
        border-color: #141481;
    }

    .csp-clinic-alert-text-black p {
        color: black;
    }

.csp-clinic-flex-between {
    display: flex;
    justify-content: space-between;
    align-items: center;
}



</style>

<div class="container-fluid">
    <div class="row">
        <!-- Display Back Attachment Documents -->
        <div class="col-12">
            <div class="col-xs-12">
                <div class="alert alert-success col-xs-12 csp-clinic-alert-darkblue">
                  
                        <div class="csp-clinic-flex-between">
                        <h4>Application Number: {{ $view_back_attachment->application_no }}</h4>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12">
                <!-- Card Body Start -->
                <div class="card">
                    <div class="card-header">
                        <h5>Back Attachment Document List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="display csp-clinic-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Remarks</th>
                                        <th>Back Attachment Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getbackdata as $user_get_ref)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user_get_ref->remarks }}</td>       
                                            <td>
                                                <a href="http://localhost/noc_documents/{{$user_get_ref->doc_upload_ref}}" target="_blank">
                                                    <i class="fa-solid fa-file-pdf fa-3x csp-clinic-pdf-icon"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Card Body End -->
            </div>
        </div>
    </div>

    {{-- Back Attachment Upload Form (Commented) --}}
    {{--
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Upload Back Attachment File</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success csp-clinic-alert-text-black">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger csp-clinic-alert-text-black">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <form action="{{ route('back_attach') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Title & description</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" id="inputEmail" name="description" placeholder="Enter your email" required rows="4" cols="50"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="inputFile" class="col-sm-2 col-form-label">Back Attachment Upload File</label>
                        <div class="col-sm-4">
                            <input type="file" class="form-control" id="inputFile" name="file" accept=".pdf" required>
                        </div>
                    </div>

                    <button type="submit" name="submit" value="submit" class="btn btn-success csp-clinic-upload-button">Upload</button>
                </form>
            </div>
        </div>
    </div>
    --}}
</div>
<script nonce="{{ $cspNonce }}">
$(document).ready(function() {
        function initializeTable(tableId) {
            if (!$.fn.dataTable.isDataTable(tableId)) {
                $(tableId).DataTable({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true
                });
            }
        }

        $.extend(true, $.fn.dataTable.defaults.oLanguage.oPaginate, {
            sNext: '<i class="fa fa-chevron-right"></i>',
            sPrevious: '<i class="fa fa-chevron-left"></i>'
        });

        initializeTable('#example1');
    });
</script>
@endsection
