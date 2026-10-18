<?php $__env->startSection('content'); ?>
<style nonce="<?php echo e($cspNonce); ?>">
    .document-table{
    table-layout: fixed;
    width:100%;
    }

    .document-table col:nth-child(1){
        width:10%;
    }

    .document-table col:nth-child(2){
        width:50%;
    }

    .document-table col:nth-child(3){
        width:40%;
    }

    .document-table th,
    .document-table td{
        vertical-align:middle;
    }

    .document-table thead th{
    text-align: center !important;
    vertical-align: middle;
    }
    .document-table td:first-child{
        text-align:center;
    }

    .document-table td:last-child{
        text-align:center;
    }
  .document-action{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    min-height:42px;
    }

    .document-action .fileInput{
        flex:1;
    }

    .document-action .btn{
        white-space:nowrap;
    }

    .document-action .form-control{
        flex:1;
        min-width:180px;
    }
    .document-action .fileInput{
    flex:1;
    }

    .document-action .btn{
        flex-shrink:0;
    }
   input.form-control[readonly], input.form-control:disabled {
    background-color: #f8f8f8;
    border: 1px solid #f3f1f1;
    cursor: not-allowed;
}
</style>
    <div class="container mt-4">
        <div class="card shadow">

            <div class="card-header bg-white text-white text-center">

                <h4 class="mb-2">Application Form for Change of <?php echo e(match ($application->clinic_type) {
'ARTCLINIC' => 'ART Clinic',
'ARTBANK' => 'ART Bank',
'ARTSURROGACY' => 'Surrogacy Clinic',
default => 'Clinic',
}); ?> </h4>

                <hr class="bg-white">

                <small class="mb-2" bg-black text-white text-center>
                    Note: Fields marked with * are mandatory.
                </small>

            </div>

            <div class="card-body">

                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                <?php endif; ?>

                <?php
                    $isSubmitted = false;
                    if ($isSubmitted) {
                        $application->proposed_clinic_name = '';
                        $application->name_change_effective_date = '';
                        $application->reason_for_name_change = '';
                    }
                ?>

                <form id="form-wizard" action="<?php echo e(route('clinic.change.name.submit')); ?>" method="POST"
                    enctype="multipart/form-data" autocomplete="off">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="application_id" value="<?php echo e($application->id ?? ''); ?>">
                    <input type="hidden" name="clinic_id" value="<?php echo e($application->clinic_id ?? ''); ?>">
                    <input type="hidden" name="userid" value="<?php echo e($application->userid_applicant ?? ''); ?>">
                    <input type="hidden" name="submit_type" id="submit_type">
                    <h4>1. Clinic Details (As Registered) </h4>

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Registration Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="registration_no" class="form-control"
                                value="<?php echo e($application->registration_no ?? ''); ?>" readonly>
                        </div>



                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Name of the Clinic <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control" value="<?php echo e($application->name ?? ''); ?>"
                                readonly>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Type of Clinic <span class="text-danger">*</span>
                            </label>

                            
                            <input type="hidden"
                                name="clinic_type"
                                value="<?php echo e($application->clinic_type ?? ''); ?>">

                            
                            <input type="text"
                                class="form-control"
                                value="<?php switch($application->clinic_type):
                                            case ('ARTCLINIC'): ?> ART Clinic <?php break; ?>
                                            <?php case ('ARTBANK'): ?> ART Bank <?php break; ?>
                                            <?php case ('ARTSURROGACY'): ?> Surrogacy Clinic <?php break; ?>
                                            <?php default: ?> <?php echo e($application->clinic_type); ?>

                                        <?php endswitch; ?>"
                                readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Nature of the Organization <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nature" class="form-control"
                                value="<?php echo e($application->nature ?? ''); ?>" readonly>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                E-mail Address of the clinic <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="email" class="form-control"
                                value="<?php echo e($application->email ?? ''); ?>" readonly>

                        </div>


                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Mobile Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="contact_number_clinic" class="form-control"
                                value="<?php echo e($application->contact_number_clinic ?? ''); ?>" readonly>

                        </div>
                        <?php if(!empty($application->level)): ?>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Level <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="level" class="form-control"
                                value="<?php echo e($application->level ?? ''); ?>" readonly>

                        </div>
                        <?php endif; ?>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Date of Registration <span class="text-danger">*</span>
                            </label>
                            <input type="hidden" name="rgistration_date" class="form-control"
                                value="<?php echo e($application->rgistration_date ?? ''); ?>" readonly>
                                <input type="text"  class="form-control"
                                value="<?php echo e($application->rgistration_date ? \Carbon\Carbon::parse($application->rgistration_date)->format('d-m-Y') : ''); ?>"  readonly>
                        </div>


                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">
                                Address <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="address" class="form-control"
                                value="<?php echo e($application->address ?? ''); ?>" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">
                                Pincode <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="pincode" class="form-control"
                                value="<?php echo e($application->pincode ?? ''); ?>" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">
                                State <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="state" class="form-control"
                                value="<?php echo e($application->state ?? ''); ?>" readonly>

                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">
                                District <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="district" class="form-control"
                                value="<?php echo e($application->district ?? ''); ?>" readonly>
                        </div>

                    </div>

                    <h4>2. Proposed New Name Details</h4>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label fw-bold">
                                Proposed New Name Of the Clinic(Current) <span class="text-danger">*</span>
                            </label>
                            
                            <input type="text"
                            id="proposed_name"
                            name="proposed_name"
                            class="form-control"
                            maxlength="255"
                            autocomplete="off"
                            value="<?php echo e($isSubmitted ? '' : old('proposed_name', $application->proposed_clinic_name ?? '')); ?>">
                            <?php $__errorArgs = ['proposed_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>


                        <div class="col-md-6 mb-2">
                            <label class="form-label fw-bold">
                                Effective Date of Name change <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="effective_date" class="form-control"
                                value="<?php echo e(old('effective_date', $application->name_change_effective_date ?? '')); ?>">
                            <?php $__errorArgs = ['effective_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-12 mb-2">
                            <label class="form-label fw-bold">
                                Reason for Change of Name <span class="text-danger">*</span>
                            </label>

                            <textarea id="reason"
                                    name="reason"
                                    class="form-control"
                                    maxlength="500"><?php echo e(old('reason', $application->reason_for_name_change ?? '')); ?></textarea>

                            <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <h4>3. Supporting Documents(Upload Self-Attested Copies)</h4>
                    <table class="table table-bordered document-table">
                        <colgroup>
                            <col>
                            <col>
                            <col>
                        </colgroup>

                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                <th>Document Name   <span class="text-danger">*</span></th>
                                <th>Upload / Action <span class="text-danger">*</span></th>
                            </tr>
                        </thead>

                        <tbody id="documentTable">

                            
                            <tr>
                                <td>1</td>

                                <td>
                                    <input type="hidden"
                                        name="document_type[]"
                                        value="mandatory_resolution">

                                    <input type="text"
                                        name="document_name[]"
                                        class="form-control document-name"
                                        maxlength="150"
                                        placeholder="Enter document name"
                                        value="<?php echo e(old('document_name.0',$resolution->document_title ?? '')); ?>"
                                        required>  

                                        
                                </td>

                                <td>
                                <div class="document-action">
                                <input type="file"
                                    name="documents[]"
                                    class="form-control fileInput <?php echo e(isset($resolution) ? 'd-none' : ''); ?>"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                    <input type="hidden" name="document_path[]" value="<?php echo e($resolution->file_path ?? ''); ?>"> 
                                    
                                <?php if(isset($resolution)): ?>

                                    <div class="document-action">

                                        <a href="<?php echo e(asset('webprodfiles/clinic_application/'.str_replace('/','_',$application->application_no).'/'.$resolution->file_path)); ?>"
                                        target="_blank"
                                        class="btn btn-primary btn-sm">
                                            View
                                        </a>

                                        <button type="button"
                                                class="btn btn-danger btn-sm delete-document"
                                                data-id="<?php echo e($resolution->id); ?>">
                                            Delete
                                        </button>

                                    </div>

                                <?php endif; ?>
                                </div>

                            </td>

                            </tr>


                            
                            <tr>

                                <td>2</td>

                                <td>

                                    <input type="hidden"
                                        name="document_type[]"
                                        value="mandatory_gazette">

                                    <input type="text"
                                        name="document_name[]"
                                        class="form-control document-name"
                                        maxlength="150"
                                        placeholder="Enter document name"
                                        value="<?php echo e(old('document_name.1',$gazette->document_title ?? '')); ?>"
                                        required>

                                </td>

                                <td>
                                <div class="document-action">
                                <input type="file"
                                    name="documents[]"
                                    class="form-control fileInput <?php echo e(isset($gazette) ? 'd-none' : ''); ?>"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                    <input type="hidden" name="document_path[]" value="<?php echo e($gazette->file_path ?? ''); ?>">

                                <?php if(isset($gazette)): ?>

                                    <div class="document-action">

                                        <a href="<?php echo e(asset('webprodfiles/clinic_application/'.str_replace('/','_',$application->application_no).'/'.$gazette->file_path)); ?>"
                                        target="_blank"
                                        class="btn btn-primary btn-sm">
                                            View
                                        </a>

                                        <button type="button"
                                                class="btn btn-danger btn-sm delete-document"
                                                data-id="<?php echo e($gazette->id); ?>">
                                            Delete
                                        </button>

                                    </div>

                                <?php endif; ?>
                                </div>
                            </td>

                            </tr>


                            
                            <?php $__currentLoopData = $otherDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr class="other-document-row">

                                <td></td>

                                <td>

                                    <input type="hidden"
                                        name="document_type[]"
                                        value="Other">

                                    <input type="text"
                                        name="document_name[] document-name"
                                        class="form-control"
                                        maxlength="150"
                                        value="<?php echo e($doc->document_title); ?>"
                                        placeholder="Enter document name">

                                </td>

                                <td>
                                    <div class="document-action">

                                        <input type="file"
                                            name="documents[]"
                                            class="form-control fileInput d-none"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                            <input type="hidden" name="document_path[]" value="<?php echo e($doc->file_path ?? ''); ?>">

                                        <a href="<?php echo e(asset('webprodfiles/clinic_application/'.str_replace('/','_',$application->application_no).'/'.$doc->file_path)); ?>"
                                        target="_blank"
                                        class="btn btn-primary btn-sm">
                                            View
                                        </a>

                                        <button type="button"
                                                class="btn btn-danger btn-sm delete-document"
                                                data-id="<?php echo e($doc->id); ?>">
                                            Delete
                                        </button>

                                    </div>
                                </td>

                            </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <tr id="addDocumentRow">
                                <td colspan="3" class="text-center">

                                    <button type="button"
                                            id="addDocument"
                                            class="btn btn-success btn-sm">
                                        <i class="fa fa-plus"></i> Add Another Document
                                    </button>

                                </td>
                            </tr>

                        </tbody>

                    </table>



                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                Name of Authorized Signatory<span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                id="authorized_signatory_name"
                                name="authorized_signatory_name"
                                class="form-control"
                                maxlength="150"
                                autocomplete="off"
                                value="<?php echo e(old('authorized_signatory_name', $application->authorized_signatory_name ?? '')); ?>">
                            <?php $__errorArgs = ['authorized_signatory_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                Designation<span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                id="designation"
                                name="designation"
                                class="form-control"
                                maxlength="150"
                                autocomplete="off"
                                value="<?php echo e(old('designation', $application->designation ?? '')); ?>">
                            <?php $__errorArgs = ['designation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                Contact Number <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                name="contact_number"
                                id="contact_number"
                                class="form-control"
                                maxlength="10"
                                inputmode="numeric"
                                autocomplete="off"
                                value="<?php echo e(old('contact_number', $application->contact_number ?? '')); ?>">

                            <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="declaration_date" class="form-control"
                                value="<?php echo e(old('declaration_date', now()->format('Y-m-d'))); ?>" readonly>
                            <?php $__errorArgs = ['declaration_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                    </div>

                    <h4>4. Declaration</h4>

                    <div class="col-md-12">
                        <div class="mb-3" id="declaration_both">



                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox"
                                    class="form-check-input"
                                    name="declaration"
                                    id="declaration"
                                    value="1"
                                    <?php echo e(old('declaration', $application->declaration_accepted ?? 0) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="gridCheck">
                                        I/We hereby declare that the information provide above is true and correct to the
                                        best of
                                        my/our knowledge and belief.I/We undertake that all the attached documents are
                                        genuine and self
                                        attested.I/We also understand that if any information is found to be false,the
                                        application may be rejected and
                                        action may be taken as per law. *
                                </div>
                                <?php $__errorArgs = ['declaration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <br><small class="text-danger"><?php echo e($message); ?></small>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                        </div>
                    </div>



                    <div class="text-center mt-3">

                        <button type="submit" id="draftButton" class="btn btn-success bc-bc-color-csp-clinic-three">
                            Save As Draft
                        </button>

                        <button type="submit" id="submitButton" class="btn btn-primary">
                            Submit Application
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
    <script nonce="<?php echo e($cspNonce); ?>">
        document.querySelectorAll('.fileInput').forEach(input => {
            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.size > 250 * 1024) {
                    alert('File must be less than 250 KB');
                    this.value = '';
                }
            });
        });
        let count = $("#documentTable tr").length + 1;
        $("#addDocument").click(function () {

        $("#addDocumentRow").before(`
            <tr>

                <td></td>

                <td>

                    <input type="hidden"
                        name="document_type[]"
                        value="Other">

                    <input type="text"
                        name="document_name[]"
                        class="form-control document-name"
                        maxlength="150"
                        placeholder="Enter document name" required>

                </td>

                <td>

                    <div class="document-action">

                        <input type="file"
                            name="documents[]"
                            class="form-control fileInput"
                            accept=".pdf,.jpg,.jpeg,.png">

                        <button type="button"
                                class="btn btn-danger btn-sm removeRow">
                            Delete
                        </button>

                    </div>

                </td>

            </tr>
            `);

            updateSerialNumbers();

            count++;
        });
        $(document).on('click','.removeRow',function(){
        $(this).closest('tr').remove();
        updateSerialNumbers();
        });
        function updateSerialNumbers() {

            let serial = 1;

            $("#documentTable tr").not("#addDocumentRow").each(function () {

                $(this).find("td:first").text(serial++);

            });

        }

        $(document).on('click', '.delete-document', function () {
            let btn = $(this);
            let row = btn.closest('tr');
            let documentName = row.find('input[name="document_name[]"]').val() || 'this document';
            if (!confirm('Delete the document "' + documentName + '"?')) {
                return;
            }
            row.find('input[name="document_name[]"]').val('');

            

            $.ajax({
                url: "<?php echo e(route('clinic.change-name.document.delete')); ?>",
                type: "POST",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    document_id: btn.data('id'),
                    application_id: "<?php echo e($application->id ?? ''); ?>"
                },
                success: function (res) {

                    if (res.success) {

                        if (row.hasClass('other-document-row')) {

                            row.remove();
                            updateSerialNumbers();

                        } else {

                            row.find('a').remove();
                            row.find('.delete-document').remove();

                            row.find('.fileInput')
                                .removeClass('d-none')
                                .val('');
                        }
                    }

                }
            });

        });

        const contactNumber = document.getElementById('contact_number');
        const proposedName = document.getElementById('proposed_name');
        const reason = document.getElementById('reason');
        const authorizedSignatory = document.getElementById('authorized_signatory_name');
        const designation = document.getElementById('designation');
        if (contactNumber) {
            contactNumber.addEventListener('input', function () {
                this.value = this.value
                    .replace(/\D/g, '')
                    .slice(0, 10);
            });
        }
        if (proposedName) {
            proposedName.addEventListener('input', function () {
                this.value = this.value.replace(/[^A-Za-z0-9\s'",.$()[\]&-]/g, '');
            });
        }
        if (reason) {
            reason.addEventListener('input', function () {
                this.value = this.value.replace(
                    /[^A-Za-z0-9\s'",.$()[\]&\-\/:\n\r]/g,
                    ''
                );
            });
        }
        document.addEventListener('input', function (e) {
        if (e.target.classList.contains('document-name')) {
                e.target.value = e.target.value.replace(
                    /[^A-Za-z0-9\s'",.$()[\]&\-\/]/g,
                    ''
                );
            }
        });
        if (authorizedSignatory) {
            authorizedSignatory.addEventListener('input', function () {
                this.value = this.value.replace(
                    /[^A-Za-z\s'",.$()[\]&-]/g,
                    ''
                );
            });
        }
        if (designation) {

            designation.addEventListener('input', function () {

                this.value = this.value.replace(
                    /[^A-Za-z0-9\s'",.$()[\]&-]/g,
                    ''
                );
            });
        }
        $(document).ready(function () {
            updateSerialNumbers();
        });
    </script>

    <script nonce="<?php echo e($cspNonce); ?>">
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('form-wizard');
            const submitButton = document.getElementById('submitButton');
            const draftButton = document.getElementById('draftButton');


            function setError(id, message, element = null) {

                alert(message);

                const el = document.getElementById(id);
                if (el) {
                    el.innerText = message;
                    el.style.color = "red";
                    el.style.fontSize = "13px";
                }

                if (element) {
                    element.focus();
                }

                return false;
            }

            function clearError(id) {
                const el = document.getElementById(id);
                if (el) {
                    el.innerText = "";
                }
            }

            function hasInvalidCharacters(value) {
                const forbiddenPattern = /[<>$%#{}[\];'"`]/;
            return forbiddenPattern.test(value);
        }

        function validateFile(fileInput) {

            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                return false;
            }

            const file = fileInput.files[0];


            if (file.size > 250 * 1024) {
                fileInput.value = '';
                return false;
            }


            const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
            const extension = file.name.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes(extension)) {
                fileInput.value = '';
                return false;
            }

            return true;
        }


        function validateDraft() {

            const textInputs = document.querySelectorAll("input[type='text'], textarea");

            for (let input of textInputs) {
                if (input.value.trim() !== '' && hasInvalidCharacters(input.value)) {
                    return setError("errorreason", "Invalid characters detected", input);
                }
            }

            const fileInputs = document.querySelectorAll('.fileInput');

            for (let fileInput of fileInputs) {
                if (fileInput.files.length > 0 && !validateFile(fileInput)) {
                    return setError("errorfile", "Invalid file selected", fileInput);
                }
            }

            return true;
        }


        function validateSubmit() {

            clearError("errorreason");
            clearError("errorfile");
            clearError("errorcontact");
            clearError("errordeclaration");

            const requiredFields = [
                'proposed_name',
                'effective_date',
                'reason',
                'authorized_signatory_name',
                'designation',
                'contact_number',
                'declaration_date'
            ];

            for (let name of requiredFields) {

                const field = document.querySelector(`[name="${name}"]`);

                if (!field || !field.value.trim()) {
                    return setError("errorreason", `${name.replaceAll('_', ' ')} is required`, field);
                    }
                }


                const contact = document.querySelector('[name="contact_number"]');

                if (!/^[0-9]{10}$/.test(contact.value)) {
                    return setError("errorcontact", "Enter valid 10 digit mobile number", contact);
                }


                const declaration = document.getElementById('declaration');

                if (!declaration.checked) {
                    return setError("errordeclaration", "Please accept declaration", declaration);
                }


                const textInputs = document.querySelectorAll("input[type='text'], textarea");

                for (let input of textInputs) {
                    if (input.value.trim() !== '' && hasInvalidCharacters(input.value)) {
                        return setError("errorreason", "Invalid characters detected", input);
                    }
                }

                const reason = document.querySelector('[name="reason"]');

                if (!reason.value.trim()) {
                    return setError(
                        "errorreason",
                        "Please enter reason for change of name",
                        reason
                    );
                }


                const fileInputs = document.querySelectorAll('.fileInput');

                for (let fileInput of fileInputs) {

                    if(fileInput.classList.contains('d-none')) {
                       
                        continue; // Skip hidden file inputs
                    }

                    if (fileInput.files.length === 0) {
                        return setError(
                            "errorfile",
                            "Please upload the required documents",
                            fileInput
                        );
                    }

                    if (!validateFile(fileInput)) {
                        return setError(
                            "errorfile",
                            "Invalid file type or size (max 250KB, pdf/jpg/jpeg/png only)",
                            fileInput
                        );
                    }
                }


                const documentNames = document.querySelectorAll('[name="document_name[]"]');

                for (let input of documentNames) {

                    if (input.value.trim() === '') {
                        alert('Please enter document name.');
                        input.focus();
                        return false;
                    }

                    if (input.value.length > 150) {
                        alert('Document name cannot exceed 150 characters.');
                        input.focus();
                        return false;
                    }

                    if (!/^[A-Za-z0-9()\/&,\-.\s]+$/.test(input.value)) {
                        alert('Invalid characters in document name.');
                        input.focus();
                        return false;
                    }
                }


                return confirm('Kindly check and confirm all details before final submission.');
            }


            if (submitButton) {
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (validateSubmit()) {
                        form.submit();
                    }
                });
            }

            if (draftButton) {
                draftButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (validateDraft()) {
                        form.submit();
                    }
                });
            }

        });

       
$('#draftButton').on('click', function () {
$('#submit_type').val('draft');
});

$('#submitButton').on('click', function () {
$('#submit_type').val('submit');
});
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.clinic.clinic_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/clinic/change_name_form_artclinic.blade.php ENDPATH**/ ?>