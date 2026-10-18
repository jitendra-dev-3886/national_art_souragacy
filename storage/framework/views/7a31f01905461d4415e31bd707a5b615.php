<?php $__env->startSection('content'); ?>
	<style nonce="<?php echo e($cspNonce); ?>">
        .csp-admin-hr-border{
            min-width: 845px;
        }
    </style>
<div class="container-fluid">
	<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

	<div class="row">		
		<div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-danger">
				<div class="card-body  p-4">
					<div class="media">
						<span class="me-3">
							<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
							
							<h3 class="text-white"><?php echo e($totalartSubmittedData); ?></h3><br>
							<p class="mb-1">ART Clinic</p>
							  <p id="countdown"></p>
							<p class="mb-1">Total Application RECEIVED</p>
							
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="<?php echo e(route('admin.ssaForm_list')); ?>" class="small-box-footer text-decoration-none text-white">More info <i class="fa fa-arrow-circle-right"></i></a>
					</p>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-success">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
							<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
							<h3 class="text-white"><?php echo e($totalbankSubmittedData); ?></h3><br>
							<p class="mb-1">ART Bank</p>
							<p class="mb-1">Total Application RECEIVED</p>
							
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="<?php echo e(route('admin.bank_ssaForm_list')); ?>" class="small-box-footer text-decoration-none text-white">More
							info <i class="fa fa-arrow-circle-right"></i></a>
					</p>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-info">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
							<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
							<h3 class="text-white"><?php echo e($totalsurrogacySubmittedData); ?></h3><br>
							<p class="mb-1">Surrogacy Clinic</p>
							<p class="mb-1">Total Application RECEIVED</p>
							
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="<?php echo e(route('admin.surrogacy_ssaForm_list')); ?>" class="small-box-footer text-decoration-none text-white">More
							info <i class="fa fa-arrow-circle-right"></i></a>
					</p>
				</div>
			</div>
		</div>



		

		
		
		 <div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-light">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
						<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
						<h3 class="text-white"><?php echo e($totalrenewalclinicData->total_submitted); ?></h3>
						<br>
						<p class="mb-1">Total Application RECEIVED</p>
						<p class="mb-1">ART Clinic Renewal</p>
						<p class="mb-0 fw-bold">
							<span class="text-danger">Pending: <?php echo e($totalrenewalclinicData->total_pending); ?></span> |
							<span class="text-info">Received: <?php echo e($totalrenewalclinicData->total_received); ?></span> |
							<span class="text-primary">Approved: <?php echo e($totalrenewalclinicData->total_approved); ?></span> |
							<span class="text-danger">Rejected: <?php echo e($totalrenewalclinicData->total_rejected); ?></span>
						</p>
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="<?php echo e(route('renewal.clinic_ssarenewal_list', ['clinicType' => 'artclinic'])); ?>" 
						class="small-box-footer text-decoration-none text-white">
						More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</p>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-warning">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
						<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
						<h3 class="text-white"><?php echo e($totalrenewalbankData->total_submitted); ?></h3>
						<br>
						<p class="mb-1">Total Application RECEIVED</p>
						<p class="mb-1">ART Bank Renewal</p>
						<p class="mb-0 fw-bold">
							<span class="text-danger">Pending: <?php echo e($totalrenewalbankData->total_pending); ?></span> |
							<span class="text-info">Received: <?php echo e($totalrenewalbankData->total_received); ?></span> |
							<span class="text-primary">Approved: <?php echo e($totalrenewalbankData->total_approved); ?></span> |
							<span class="text-danger">Rejected: <?php echo e($totalrenewalbankData->total_rejected); ?></span>
						</p>
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="<?php echo e(route('renewal.clinic_ssarenewal_list', ['clinicType' => 'artbank'])); ?>" 
						class="small-box-footer text-decoration-none text-white">
						More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</p>
				</div>
			</div>
		</div>

		<div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-dark">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
						<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
						<h3 class="text-white"><?php echo e($totalrenewalsurrogacyData->total_submitted); ?></h3>
						<br>
						<p class="mb-1">Total Application RECEIVED</p>
						<p class="mb-1">Surrogacy Renewal</p>
						<p class="mb-0 fw-bold">
							<span class="text-danger">Pending: <?php echo e($totalrenewalsurrogacyData->total_pending); ?></span> |
							<span class="text-info">Received: <?php echo e($totalrenewalsurrogacyData->total_received); ?></span> |
							<span class="text-primary">Approved: <?php echo e($totalrenewalsurrogacyData->total_approved); ?></span> |
							<span class="text-danger">Rejected: <?php echo e($totalrenewalsurrogacyData->total_rejected); ?></span>
						</p>
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="<?php echo e(route('renewal.clinic_ssarenewal_list', ['clinicType' => 'artsurrogacy'])); ?>" 
						class="small-box-footer text-decoration-none text-white">
						More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</p>
				</div>
			</div>
		</div>


		<!-- Changes Addrees -->
		<?php
			$cards = [
			    'ARTCLINIC' => [
			        'title' => 'ART Clinic Change Address',
			        'color' => 'bg-light',
			        'route' => 'artclinic'
			    ],
			    'ARTBANK' => [
			        'title' => 'ART Bank Change Address',
			        'color' => 'bg-warning',
			        'route' => 'artbank'
			    ],
			    'ARTSURROGACY' => [
			        'title' => 'Surrogacy Change Address',
			        'color' => 'bg-dark',
			        'route' => 'artsurrogacy'
			    ],
			];
			?>

			<?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php
			$data = $changeAddressData[$type] ?? (object)[
			    'total_submitted' => 0,
			    'total_received' => 0,
			    'total_approved' => 0,
			    'total_rejected' => 0,
			    'total_pending' => 0,
			];
		?>
		<div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
		    <div class="widget-stat card <?php echo e($item['color']); ?>">
		        <div class="card-body p-4">
		            <div class="media">
		                <span class="me-3">
		                    <i class="flaticon-381-calendar-1"></i>
		                </span>
		                <div class="media-body text-white text-end">
		                    <h3 class="text-white"><?php echo e($data->total_submitted); ?></h3>
		                    <br>
		                    <p class="mb-1">Total Applications Submitted</p>
		                    <p class="mb-1"><?php echo e($item['title']); ?></p>
		                    <p class="mb-0 fw-bold">
		                        <span class="text-danger">Pending: <?php echo e($data->total_pending); ?></span> |
		                        <span class="text-info">Received: <?php echo e($data->total_received); ?></span> |
		                        <span class="text-primary">Approved: <?php echo e($data->total_approved); ?></span> |
		                        <span class="text-danger">Rejected: <?php echo e($data->total_rejected); ?></span>
		                    </p>
		                </div>
		            </div>
		        </div>

		        <hr class="csp-admin-hr-border">

		        <div>
		            <p class="text-dark text-center py-1">
		                <a href="<?php echo e(route('change_address.clinic_list', ['clinicType' => $item['route']])); ?>" 
		                   class="small-box-footer text-decoration-none text-white">
		                   More info <i class="fa fa-arrow-circle-right"></i>
		                </a>
		            </p>
		        </div>
		    </div>
		</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<!-- Changes Addrees @end(06-05-2026)-->

		<!-- <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-warning">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
							<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
							<h3 class="text-white">10</h3><br>
							<p class="mb-1">In Process</p>
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="#" class="small-box-footer text-decoration-none text-white">More
							info <i class="fa fa-arrow-circle-right"></i></a>
					</p>
				</div>
			</div>
		</div> -->
		
		
		
		
	</div>

</div>

<script nonce="<?php echo e($cspNonce); ?>">
    let timeout;
		const inactivityLimit = 1 * 3000 * 1000; 
		function resetTimer() {
			clearTimeout(timeout);
			timeout = setTimeout(() => {
				alert("You have been inactive for 2 minutes. You will be logged out.");
				if(<?php echo e(session('user_type')); ?>==5){
						document.getElementById('logout-form').submit();
				}
				
			}, inactivityLimit);
		}
		
		window.onload = resetTimer;
		document.onmousemove = resetTimer;
		document.onkeypress = resetTimer;
		document.onscroll = resetTimer;
		
</script>

<?php $__env->stopSection(); ?>;
<?php echo $__env->make('layouts.admin.ssa_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/admin/SSA_dashboard.blade.php ENDPATH**/ ?>