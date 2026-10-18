@extends('layouts.noc.noc_master')
@section('content')	

<style nonce="{{$cspNonce}}">
    .csp-clinic-btn-primary {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
        color: white;
    }
</style>

			
			<div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Change Password</h4>
				</div>
				@if (session('status'))
                                            <div class="alert alert-success">
                                                {{ session('status') }}
                                            </div>
                                            @endif                                          
                                            @if ($errors->any())
                                            <div class="alert alert-danger col-sm-12">
                                                @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                            @endif
				<div class="card-body">
					<div class="basic-form">
						<form class="form-valide-with-icon needs-validation" novalidate="" action="{{ route('noc.password.change.post') }}" method="POST" autocomplete="off">
							@csrf
							<div class="mb-3">
								<label class="text-label form-label" for="dlab-password">Current Password *</label>
								<div class="input-group transparent-append">
									<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
									<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Choose a safe one.." required="">
									<span class="input-group-text show-pass border-left-end "> 
										<i class="fa fa-eye-slash"></i>
										<i class="fa fa-eye"></i>
									</span>
									<div class="invalid-feedback">
										Please Enter a Current password.
									</div>
								</div>
							</div>
							<div class="mb-3">
								<label class="text-label form-label" for="dlab-password">Password *</label>
								<div class="input-group transparent-append">
									<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
									<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Choose a safe one.." required="">
									<span class="input-group-text show-pass border-left-end "> 
										<i class="fa fa-eye-slash"></i>
										<i class="fa fa-eye"></i>
									</span>
									<div class="invalid-feedback">
										Please Enter a username.
									</div>
								</div>
							</div>
							<div class="mb-3">
								<label class="text-label form-label" for="dlab-password">Confirm Password *</label>
								<div class="input-group transparent-append">
									<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
									<input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Choose a safe one.." required="">
									<span class="input-group-text show-pass border-left-end "> 
										<i class="fa fa-eye-slash"></i>
										<i class="fa fa-eye"></i>
									</span>
									<div class="invalid-feedback">
										Please Enter a username.
									</div>
								</div>
							</div>
							
				
							<button type="submit" class="btn me-2 csp-clinic-btn-primary">Submit</button>
                           <button type="submit" class="btn csp-clinic-btn-primary">Cancel</button>
						</form>
					</div>	
				</div>
			</div>
		</div>

@endsection();