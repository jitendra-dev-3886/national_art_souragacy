<?php $__env->startSection('content'); ?>
    <style nonce="<?php echo e($cspNonce); ?>">
        .csp-admin-message-div {
            background-color: #141481;
            border-color: #0b5ed7;
            color: white;
        }

        .csp-admin-table {
            min-width: 845px;
        }

        .csp-admin-form {
            display: flex;
            align-items: center;
        }

        .csp-admin-form-input {
            width: 300px;
            margin-bottom: 10px;
            margin-right: 10px;
            display: inline-block;
        }

        .csp-admin-form-button {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
            color: white;
            display: inline-block;
        }

        .csp-admin-red-color {
            color: red;
        }

        .csp-admin-div-none {
            display: none;
        }
    </style>
    <script src="<?php echo e(asset('datatable/jquery3.0.js')); ?>" nonce="<?php echo e($cspNonce); ?>"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('datatable/datatable.css')); ?>" nonce="<?php echo e($cspNonce); ?>">

    <!--  DataTables JS -->
    <script src="<?php echo e(asset('datatable/datatablemin.js')); ?>" nonce="<?php echo e($cspNonce); ?>"></script>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php if(session('upd_success')): ?>
                    <div class="col-lg-6 offset-lg-3">
                        <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-div">
                            <strong> <?php echo e(session('upd_success')); ?></strong>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e($clinicTypeValueaname[$clinicTypeValue]); ?></h4>
                    </div>
                    
                    <div class="card-body">
                        <form id="searchForm" method="GET"
                            action="<?php echo e(route('renewal.ssa_search_application', ['clinicType' => $clinicTypeValue])); ?>"
                            class="csp-admin-form">
                            <input type="text" id="searchApplicationNo" name="application_no"
                                placeholder="Enter Application No." class="form-control csp-admin-form-input">
                            <button type="submit" class="btn btn csp-admin-form-button">Search</button>
                        </form>

                        <!-- Error message container -->
                        <p id="errorMessage" class="csp-admin-red-color"></p>

                        <!-- Search result container -->
                        <div id="result" class="csp-admin-div-none">
                            <table class="table table-bordered table-striped table-hover nowrap w-100" id="surrogacy_list">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Application Status</th>
                                        <th>Clinic Name</th>
                                        <th>Nature</th>
                                        <th>Email ID</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>Date of online<br> form submission<br>(By the user Clinic)</th>
                                        <th>Date of payment fee</th>
                                        <th>Date on which<br> application recived<br> by authority</th>
                                        <th>Certificate Issued</th>   
                                        <th>View</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="patientList">
                                    <!-- Results will be injected here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/jquery-3.6.0.min.js')); ?>"></script>
<script nonce="<?php echo e($cspNonce); ?>">
let clinicType = <?php echo json_encode($clinicTypeValue, 15, 512) ?>;

let ajaxUrlTemplate = "<?php echo e(route('change_address.ssa.search_application', ['clinicType' => '__CLINIC__'])); ?>";
let ajaxUrl = ajaxUrlTemplate.replace('__CLINIC__', encodeURIComponent(clinicType));

let encryptedClinicType = <?php echo json_encode(Crypt::encryptString($clinicTypeValue), 15, 512) ?>;

let actionUrlBase = "<?php echo e(route('change_address.ssa_application_reg', ['encryptedClinicType' => 'CLINIC_PLACEHOLDER', 'encryptedId' => 'ID_PLACEHOLDER'])); ?>";
let viewUrlBase = "<?php echo e(route('change_address.application.view', ['encryptedId' => 'ID_PLACEHOLDER'])); ?>";

$(document).on('submit', '#searchForm', function(e) {
    e.preventDefault();

    let query = $('#searchApplicationNo').val().trim();

    if (!query) {
        $('#errorMessage').text('Please enter an application number.');
        return;
    }

    $.ajax({
        url: ajaxUrl,
        type: "GET",
        data: { application_no: query },

        success: function(response) {

            // Destroy existing DataTable safely
            if ($.fn.DataTable.isDataTable('#surrogacy_list')) {
                $('#surrogacy_list').DataTable().destroy();
            }

            // Handle empty response
            if (!response || response.length === 0) {
                $('#patientList').html('');
                $('#result').addClass('csp-admin-div-none');
                $('#errorMessage').text('No records found.');
                return;
            }

            let rows = '';

            $.each(response, function(index, item) {

                // Certificate issued logic
                let cert_issued = item.appstatus === 'Approved' ? 'Yes' : '';

                // Action URL
                let actionUrl = actionUrlBase
                    .replace('CLINIC_PLACEHOLDER', encryptedClinicType)
                    .replace('ID_PLACEHOLDER', item.encrypted_id);

                // View URL
                let viewUrl = viewUrlBase.replace('ID_PLACEHOLDER', item.encrypted_id);


                // Action column
                let actionColumn = '';
                if (['Pending', 'Received'].includes(item.appstatus)) {

                    actionColumn = `<a href="${actionUrl}" class="btn btn-sm btn-primary">Action</a>`;

                } else {

                    actionColumn = item.appstatus;
                }

                // View column
                let viewColumn = `<a href="${viewUrl}" class="btn btn-sm btn-secondary">View</a>`;

                // Build row
                rows += `<tr>
                    <td>${index + 1}</td>
                    <td>${item.applicationno ?? ''}</td>
                    <td>${item.appstatus ?? ''}</td>
                    <td>${item.clinicname ?? ''}</td>
                    <td>${item.nature ?? ''}</td>
                    <td>${item.email ?? ''}</td>
                    <td>${item.contactno ?? ''}</td>
                    <td>${item.address ?? ''}</td>
                    <td>${item.state ?? ''}</td>
                    <td>${item.district ?? ''}</td>
                    <td>${item.created_at ?.split('T')[0].split('-').reverse().join('/') ?? ''}</td>
                    <td>${item.app_date_payment?.split('T')[0].split('-').reverse().join('/') ?? ''}</td>
                    <td>${item.app_date_recieve ?.split('T')[0].split('-').reverse().join('/') ?? '' ?? ''}</td>
                    <td>${cert_issued}</td>
                    <td>${viewColumn}</td>
                    <td>${actionColumn}</td>
                </tr>`;
            });

            // Insert rows (replace old data)
            $('#patientList').html(rows);

            // Reinitialize DataTable
            $('#surrogacy_list').DataTable({
                destroy: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true,
                scrollX: true,

                dom: '<"row"<"col-md-2"l><"col-md-7"B><"col-md-3"f>>rt<"row"<"col-md-6"p>>',

                buttons: [
                    {
                        extend: 'excel',
                        text: 'Export Excel'
                    }
                ],

                columnDefs: [
                    { targets: 0, width: '5%' },
                    { targets: 1, width: '7%' },
                    { targets: 2, width: '8%' },
                    { targets: 3, width: '6%' },
                    { targets: 4, width: '7%' },
                    { targets: 5, width: '6%' },
                    { targets: 6, width: '10%' },
                    { targets: 7, width: '6%' },
                    { targets: 8, width: '6%' },
                    { targets: 9, width: '7%' },
                    { targets: 10, width: '7%' },
                    { targets: 11, width: '7%' },
                    { targets: 12, width: '7%' },
                    { targets: 13, width: '7%' },
                    { targets: 14, width: '7%' },
                    { targets: 15, width: '6%' }
                ],

                createdRow: function(row) {
                    $('td', row).addClass('align-middle text-wrap');
                }
            });

            $('#result').removeClass('csp-admin-div-none');
            $('#errorMessage').text('');
        },

        error: function(xhr) {
            console.error('AJAX error:', xhr.responseText);
            $('#errorMessage').text('Something went wrong. Please try again.');
        }
    });
});
</script>








    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.ssa_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/change_address/clinic_ssa_list_reg.blade.php ENDPATH**/ ?>