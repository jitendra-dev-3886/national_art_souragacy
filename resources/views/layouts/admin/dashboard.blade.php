@extends('layouts.admin.admin_master')

@section('content')
@if (false)
<style nonce="{{$cspNonce}}">
/* Compliance Circular Gauge */
.compliance-circle {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    background: conic-gradient(
        #198754 0% 72%,   /* Green portion */
        #dee2e6 72% 100%  /* Grey remainder */
    );
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.compliance-circle::before {
    content: "";
    position: absolute;
    width: 120px;
    height: 120px;
    background: #fff;
    border-radius: 50%;
}

.inner-text {
    position: relative;
    z-index: 2;
    text-align: center;
}

/* Status Circles */
.status-circle {
    width: 65px;
    height: 65px;
    border-radius: 50%;
    color: #fff;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 6px auto;
    font-size: 18px;
}
</style>

<div class="container-fluid py-4">

    <!-- Top Summary Row -->
    <div class="row g-4">

        <!-- Compliance Gauge -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-semibold">
                    Renewal Compliance Status
                </div>
                <div class="card-body text-center">

                    <div class="compliance-circle mx-auto mb-3">
                        <div class="inner-text">
                            <h4 class="mb-0">72%</h4>
                            <small>Compliance</small>
                        </div>
                    </div>

                    <p class="text-muted mb-0">
                        Overall State-wise Renewal Compliance
                    </p>
                </div>
            </div>
        </div>

        <!-- Renewal Summary -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-semibold">
                    Renewal Application Summary
                </div>
                <div class="card-body">

                    <h2 class="fw-bold mb-0">267</h2>
                    <small class="text-muted">Total Due for Renewal</small>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Approved</span>
                        <span class="text-success fw-semibold">180</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Pending</span>
                        <span class="text-warning fw-semibold">45</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Rejected</span>
                        <span class="text-danger fw-semibold">22</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Under Review</span>
                        <span class="text-secondary fw-semibold">20</span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Risk Section -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-semibold">
                    Expiry & Risk Status
                </div>
                <div class="card-body">

                    <h2 class="text-danger fw-bold mb-0">60</h2>
                    <small class="text-muted">Total Risk Cases</small>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Overdue</span>
                        <span class="badge bg-danger">19</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Auto-Lapsed</span>
                        <span class="badge bg-dark">12</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Expiring in 60 Days</span>
                        <span class="badge bg-warning text-dark">29</span>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Second Row -->
    <div class="row g-4 mt-2">

        <!-- Current Renewal Status -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    Current Renewal Application Status
                </div>
                <div class="card-body d-flex justify-content-around text-center">

                    <div>
                        <div class="status-circle bg-secondary">97</div>
                        <small>In Progress</small>
                    </div>

                    <div>
                        <div class="status-circle bg-warning text-dark">7</div>
                        <small>On Approval</small>
                    </div>

                    <div>
                        <div class="status-circle bg-danger">19</div>
                        <small>Overdue</small>
                    </div>

                    <div>
                        <div class="status-circle bg-dark">5</div>
                        <small>Auto-Lapsed</small>
                    </div>

                </div>
            </div>
        </div>

        <!-- State-wise Table -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    State-wise Renewal Summary
                </div>
                <div class="card-body table-responsive">

                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>State</th>
                                <th>Due</th>
                                <th>Approved</th>
                                <th>Pending</th>
                                <th>Rejected</th>
                                <th>Overdue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Maharashtra</td>
                                <td>80</td>
                                <td class="text-success">60</td>
                                <td class="text-warning">10</td>
                                <td class="text-danger">5</td>
                                <td class="text-danger">5</td>
                            </tr>
                            <tr>
                                <td>Karnataka</td>
                                <td>60</td>
                                <td class="text-success">45</td>
                                <td class="text-warning">8</td>
                                <td class="text-danger">4</td>
                                <td class="text-danger">3</td>
                            </tr>
                            <tr>
                                <td>Tamil Nadu</td>
                                <td>50</td>
                                <td class="text-success">35</td>
                                <td class="text-warning">10</td>
                                <td class="text-danger">3</td>
                                <td class="text-danger">2</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

</div>
@endif
@endsection



