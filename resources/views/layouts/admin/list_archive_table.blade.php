@extends('layouts.admin.admin_master')

@section('content')

    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div{
            background-color: #141481; border-color: #0b5ed7; color: white;
        }
    </style>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="col-lg-6 offset-lg-3">
                    <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-div">
                        <strong>{{ session('success') }}</strong>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="col-lg-6 offset-lg-3">
                    <div class="alert alert-danger alert-dismissible alert-alt fade show">
                        <strong>{{ session('error') }}</strong>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">List of Archival Applications</h4>
                </div>
                <div class="card-body">
                    {{-- <div class="table-responsive"> --}}
                        @php $i = 1; @endphp
                        @foreach ($combinedList as $list_data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                @if(!empty($list_data->surrogacyclinics) && !empty($list_data->surrogacyclinics->sapp_no))
                                    {{ $list_data->surrogacyclinics->sapp_no->applicationno }}
                                @elseif(!empty($list_data->bankclinics) && !empty($list_data->bankclinics->bapp_no))
                                    {{ $list_data->bankclinics->bapp_no->applicationno }}
                                @elseif(!empty($list_data->artclinics) && !empty($list_data->artclinics->app_no))
                                    {{ $list_data->artclinics->app_no->applicationno }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $list_data->clinicname }}</td>
                            <td>{{ $list_data->state }}</td>
                            <td>{{ $list_data->mobile }}</td>
                        </tr>
                        @endforeach
                        
                        
                        {{-- @php
                        $showTable = (!empty($clinicType) && !empty($startDate) && !empty($endDate));
                    @endphp
                    @if ($showTable)
                    <form action="#" method="post">
                        @csrf
                        <table id="example5" class="display data-table" style="min-width: 845px">
                            <!-- your table content -->
                        </table>
                    </form>
                    @endif --}}
                        {{-- <form action="#" method="GET">
                            @csrf
                            <label>Select Clinic Type:</label>
                            <select name="clinic_type">
                                <option value="">All</option>
                                <option value="surrogacy">Surrogacy Clinic</option>
                                <option value="art">ART Clinic</option>
                                <option value="bank">ART Bank</option>
                            </select>
                        
                            <label>Select Date Range:</label>
                            <input type="date" name="start_date">
                            <input type="date" name="end_date">
                        
                            <button type="submit">Filter</button>
                        </form>  --}}

                        {{-- <form action="{{ route('admin.list_archive') }}" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-xl-2 mb-3">
                                    
                                </div>
                                <div class="col-xl-2">
                                    <label for="clinic_type">Starting Date</label>
                                    <select name="clinic_type" id="clinic_type" class="form-control">
                                        <option value="" {{ request('clinic_type') == '' ? 'selected' : '' }}>All</option>
                                        <option value="surrogacy" {{ request('clinic_type') == 'surrogacy' ? 'selected' : '' }}>Surrogacy Clinic</option>
                                        <option value="art" {{ request('clinic_type') == 'art' ? 'selected' : '' }}>ART Clinic</option>
                                        <option value="bank" {{ request('clinic_type') == 'bank' ? 'selected' : '' }}>ART Bank</option>
                                    </select>
                                </div>
                                <div class="col-xl-2">
                                    <label for="start_date">End Date</label>
                                    <input class="form-control" type="date" id="start_date" name="start_date" value="">
                                </div>
                                <div class="col-xl-2">
                                    <label for="end_date">End Date</label>
                                    <input class="form-control" type="date" id="end_date" name="end_date" value="">
                                </div>
                                <div class="col-xl-2">
                                    <button type="submit" class="btn btn-sm btn-primary" style="margin-top: 32px;">Filter</button>
                                </div>
                            </div>



                            
                          
                        
                            
                        </form>
                        <table id="example5" class="display data-table" style="min-width: 845px;" >
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Application No.</th>
                                    <th>Name of Clinic</th>
                                    <th>State</th>
                                    <th>Phone No</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($combinedList as $list_data)
                                    <tr>                                           
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            @if(!empty($list_data->surrogacyclinics) && !empty($list_data->surrogacyclinics->sapp_no))
                                                {{ $list_data->surrogacyclinics->sapp_no->applicationno }}
                                            @elseif(!empty($list_data->bankclinics) && !empty($list_data->bankclinics->bapp_no))
                                                {{ $list_data->bankclinics->bapp_no->applicationno }}
                                            @elseif(!empty($list_data->artclinics) && !empty($list_data->artclinics->app_no))
                                                {{ $list_data->artclinics->app_no->applicationno }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $list_data->clinicname }}</td>
                                        <td>{{ $list_data->state }}</td>
                                        <td>{{ $list_data->mobile }}</td>                                          
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                        

                        {{-- <form action="#" method="post">
                            @csrf
                            
                            <table id="example5" class="display data-table" style="min-width: 845px">
                                <thead>
                                    <tr>
                                       
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Name of Clinic</th>
                                        <th>State</th>
                                        <th>Phone No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($combinedList as $list_data)
                                        <tr>                                           
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                @if(!empty($list_data->surrogacyclinics) && !empty($list_data->surrogacyclinics->sapp_no))
                                                    {{ $list_data->surrogacyclinics->sapp_no->applicationno }}
                                                @elseif(!empty($list_data->bankclinics) && !empty($list_data->bankclinics->bapp_no))
                                                    {{ $list_data->bankclinics->bapp_no->applicationno }}
                                                    @elseif(!empty($list_data->artclinics) && !empty($list_data->artclinics->app_no))
                                                    {{ $list_data->artclinics->app_no->applicationno }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $list_data->clinicname }}</td>
                                            <td>{{ $list_data->state }}</td>
                                            <td>{{ $list_data->mobile }}</td>                                          
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>                            
                        </form> --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script>
{{-- <script nonce="{{ $cspNonce }}">
    $(document).ready(function () {
        $('#archiveFilterForm').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.list_archive') }}",
                type: "GET",
                data: formData,
                beforeSend: function () {
                    $('#archiveResults').html('<p>Loading...</p>');
                },
                success: function (response) {
                    $('#archiveResults').html(response);
                },
                error: function () {
                    alert('Something went wrong. Please try again.');
                }
            });
        });
    });
</script> --}}

{{-- <script nonce="{{ $cspNonce }}">
    document.getElementById("checkAll").addEventListener("change", function () {
        let checkboxes = document.querySelectorAll(".customSingleCheckBox");
        alert(checkboxes)
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script> --}}
{{-- <script nonce="{{ $cspNonce }}">
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form[method='GET']");
        const clinicType = form.querySelector("select[name='clinic_type']");
        const startDate = form.querySelector("input[name='start_date']");
        const endDate = form.querySelector("input[name='end_date']");
        const button = form.querySelector("button[type='submit']");

        form.addEventListener("submit", function (e) {
            if (!clinicType.value || !startDate.value || !endDate.value) {
                e.preventDefault();
                alert("Please select clinic type and date range.");
            }
        });
    });
</script> --}}
@endsection

