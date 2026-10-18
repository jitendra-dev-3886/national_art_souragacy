
@extends('layouts.noc.noc_master') 
    @section('content')
    <style nonce="{{$cspNonce}}">
    .csp-clinic-bg-darkblue {
        background-color: #141481;
    }

    .csp-clinic-flex-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .csp-clinic-text-white {
        color: white;
    }

    .csp-clinic-m-0 {
        margin: 0;
    }

    .csp-clinic-text-darkblue {
        color: #141481;
    }

    .csp-clinic-text-left {
        text-align: left;
    }
</style>


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

              
                <div class="alert alert-success col-xs-12 csp-clinic-bg-darkblue">
                    <div class="csp-clinic-flex-between">
                        <h4 class="csp-clinic-text-white csp-clinic-m-0">
                            Application Number: {{ $view_data->application_no }}   </h4>
                    


                    </div>
                </div>
                    <form class="" action="" method="POST" enctype="">
                        <div class="card">
                            <div class="col-lg-12">

                                <div class="card-header">
                               
                                    <h4 class="card-title csp-clinic-text-darkblue">Personal Details</h4>


                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Particulars</th>
                                                   
                                                    <th class="csp-clinic-text-left">Details</th>

                                                </tr>
                                            </thead>
                                            <tbody>				
				
                @php
                $count ='';
                $count = '1';
                @endphp
            
            <tr>
                <td>{{ $count++ }}</td>
                <td>Name of the Applicant</td>
             
                <td class="csp-clinic-text-left">{{ $view_data->name_applicant }}</td>
            </tr>
            
            @if($view_data->m_status == 'Married')
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Name of the Spouse</td>
                   <td class="csp-clinic-text-left">{{ $view_data->name_spouse }}</td>
                </tr>
            @endif
            
            <tr>
                <td>{{ $count++ }}</td>
                <td>Marital Status</td>
                 <td class="csp-clinic-text-left">{{ $view_data->m_status }}</td>
            </tr>
            <tr>
                <td>{{ $count++ }}</td>
                <td>Address</td>
                <td class="csp-clinic-text-left">{{ $view_data->address }}</td>
            </tr>
            <tr>
                <td>{{ $count++ }}</td>
                <td>Pincode</td>
               <td class="csp-clinic-text-left">{{ $view_data->pincode }}</td>
            </tr>
            <tr>
                <td>{{ $count++ }}</td>
                <td>State</td>
                 <td class="csp-clinic-text-left">{{ $view_data->state }}</td>
            </tr>
            <tr>
                <td>{{ $count++ }}</td>
                <td>District</td>
                 <td class="csp-clinic-text-left">{{ $view_data->district }}</td>
            </tr>
            
            @if(!empty($view_data->contactno))
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Contact Number</td>
                   <td class="csp-clinic-text-left">{{ $view_data->contactno }}</td>
                </tr>
            @endif
            
            <tr>
                <td>{{ $count++ }}</td>
                <td>Email Address</td>
                <td class="csp-clinic-text-left">{{ $view_data->email }}</td>
            </tr>
            
            <tr>
                <td>{{ $count++ }}</td>
                <td>Aadhar Number of the Applicant</td>
                @php
                    $AdhharApp = $view_data->aadhar_applicant;
                    $mask_adhaar_app = substr($AdhharApp, -4);
                @endphp
                 <td class="csp-clinic-text-left">XXXXXXXX{{ $mask_adhaar_app }}</td>
            </tr>
            
            <tr>
                <td>{{ $count++ }}</td>
                <td>Passport Number of the Applicant</td>
                @php
                    $PassApp = $view_data->passport_applicant;
                    $mask_Pass_app = substr($PassApp, -4);
                @endphp
                 <td class="csp-clinic-text-left">XXXXX{{ $mask_Pass_app }}</td>
            </tr>
            
            <tr>
                <td>{{ $count++ }}</td>
                <td>PAN Number of the Applicant</td>
                @php
                    $Pan_num_App = $view_data->pan_applicant;
                    $mask_Pan_num_app = substr($Pan_num_App, -4);
                @endphp
                <td class="csp-clinic-text-left">XXXXXX{{ $mask_Pan_num_app }}</td>
            </tr>
            
            <tr>
                <td>{{ $count++ }}</td>
                <td>Voter ID Card Number of the Applicant</td>
                @php
                    $voter_num_App = $view_data->voterid_applicant;
                    $mask_voter_num_app = substr($voter_num_App, -4);
                @endphp
                <td class="csp-clinic-text-left">XXXXXX{{ $mask_voter_num_app }}</td>
            </tr>
            
            <tr>
                <td>{{ $count++ }}</td>
                <td>Date of Birth of Applicant</td>
                @php
                    $formatted_dob = \Carbon\Carbon::parse($view_data->dob_applicant)->format('d-m-Y');
                @endphp
                 <td class="csp-clinic-text-left">{{ $formatted_dob }}</td>
            </tr>
            
            @if($view_data->m_status == 'Married')
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Aadhar Number of the Spouse</td>
                    @php
                        $Adhhar_spouse = $view_data->aadhar_spouse;
                        $mask_adhaar_spouse = substr($Adhhar_spouse, -4);
                    @endphp
                    <td class="csp-clinic-text-left">XXXXXXXX{{ $mask_adhaar_spouse }}</td>
                </tr>
            
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Passport Number of the Spouse</td>
                    @php
                        $Pass_spouse = $view_data->passport_spouse;
                        $mask_Pass_spouse = substr($Pass_spouse, -4);
                    @endphp
                     <td class="csp-clinic-text-left">XXXXX{{ $mask_Pass_spouse }}</td>
                </tr>
            
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>PAN Number of the Spouse</td>
                    @php
                        $Pan_num_spouse = $view_data->pan_spouse;
                        $mask_Pan_num_spouse = substr($Pan_num_spouse, -4);
                    @endphp
                    <td class="csp-clinic-text-left">XXXXXX{{ $mask_Pan_num_spouse }}</td>
                </tr>
            
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Voter ID card Number of the Spouse</td>
                    @php
                        $voter_num_spouse = $view_data->voterid_spouse;
                        $mask_voter_num_spouse = substr($voter_num_spouse, -2);
                    @endphp
                     <td class="csp-clinic-text-left">XXXXXX{{ $mask_voter_num_spouse }}</td>
                </tr>
            
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Date of Birth of Spouse</td>
                    <td class="csp-clinic-text-left">{{ $view_data->dob_spouse }}</td>
                </tr>
            @endif
            
								
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">

                                <div class="card-header">
                                  
                                    <h4 class="card-title csp-clinic-text-darkblue">Purpose Details</h4>


                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                            <thead>
                                                <tr>

                                                    <th>ID</th>
                                                    <th>Particulars</th>
                                                    
                                                    <th class="csp-clinic-text-left">Details</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                            @php
                                        $count = 1;
                                        $data = [
                                            ['label' => 'Transfer', 'value' => $view_data->transfer],
                                            ['label' => 'Transfer of', 'value' => $view_data->transfer_of],
                                            ['label' => 'Number of Embryos', 'value' => $view_data->embryos_number],
                                            ['label' => 'Number of Sperms', 'value' => $view_data->sperm_vials],
                                            ['label' => 'Number of Oocyte', 'value' => $view_data->oocytes_number],
                                            ['label' => 'Purpose of Transfer', 'value' => $view_data->purpose_of_transfer],
                                        ];
                                    @endphp

                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $item['label'] }}</td>
                                          
                                            <td class="csp-clinic-text-left">{{ $item['value'] }}</td>
                                        </tr>
                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">

                                <div class="card-header">
                                    
                                    <h4 class="card-title csp-clinic-text-darkblue">From Clinic</h4>


                                </div>
                                <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Particulars</th>
                    <td class="csp-clinic-text-left">Details</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Clinic Type</td>
                     <td class="csp-clinic-text-left">{{ $view_data->status_clinic }}</td>
                </tr>

                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Status</td>
                    <td class="csp-clinic-text-left">{{ $view_data->status_from_clinic }}</td>
                </tr>

                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Name of the Clinic</td>
                    <td class="csp-clinic-text-left">{{ $view_data->clinic_name ?? 'N/A' }}</td> <!-- Assuming the clinic name is dynamic -->
                </tr>

                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Address</td>
                   <td class="csp-clinic-text-left">{{ $view_data->from_address }}</td>
                </tr>

                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Pincode</td>
                     <td class="csp-clinic-text-left">{{ $view_data->f_pincode }}</td>
                </tr>

                <tr>
                    <td>{{ $count++ }}</td>
                    <td>State</td>
              <td class="csp-clinic-text-left">{{ $view_data->f_state }}</td>
                </tr>

                <tr>
                    <td>{{ $count++ }}</td>
                    <td>District</td>
                     <td class="csp-clinic-text-left">{{ $view_data->f_district }}</td>
                </tr>

                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Contact Number</td>
                    <td class="csp-clinic-text-left">{{ $view_data->f_contact }}</td>
                </tr>

                <tr>
                    <td>{{ $count++ }}</td>
                    <td>Email</td>
                    <td class="csp-clinic-text-left">{{ $view_data->f_email }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

                            </div>
						
                            <div class="col-lg-12">

                                <div class="card-header">
                                  
                                    <h4 class="card-title csp-clinic-text-darkblue">To Clinic</h4>


                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                            <thead>
                                                <tr>

                                                    <th>ID</th>
                                                    <th>Particulars</th>
                                                   <td class="csp-clinic-text-left">Details</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                        @php $count = 1; @endphp
                                        @if (is_null($view_data->country))
                                        <!-- When country is empty -->
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Clinic Type</td>
                                             <td class="csp-clinic-text-left">{{ $view_data->to_status_clinic }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Status</td>
                                            <td class="csp-clinic-text-left">{{ $view_data->to_status_from_clinic }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Name of the Clinic</td>
                                            <td class="csp-clinic-text-left">{{ $view_data->to_name_clinic }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Address</td>
                                            <td class="csp-clinic-text-left">{{ $view_data->to_address }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Pincode</td>
                                             <td class="csp-clinic-text-left">{{ $view_data->t_pincode }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>State</td>
                                           <td class="csp-clinic-text-left">{{ $view_data->t_state }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>District</td>
                                             <td class="csp-clinic-text-left">{{ $view_data->t_district }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Contact Number</td>
                                           <td class="csp-clinic-text-left">{{ $view_data->t_contact }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Email</td>
                                             <td class="csp-clinic-text-left">{{ $view_data->t_email }}</td>
                                        </tr>
                                    @else
                                        
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Clinic Type</td>
                                            <td class="csp-clinic-text-left">{{ $view_data->to_status_clinic }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Country</td>
                                            <td class="csp-clinic-text-left">{{ $country->country_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Name of the Clinic</td>
                                            <td class="csp-clinic-text-left">{{ $view_data->to_name_clinic2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Address</td>
                                            <td class="csp-clinic-text-left">{{ $view_data->to_address }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Contact Number</td>
                                           <td class="csp-clinic-text-left">{{ $view_data->t_contact }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>Email</td>
                                            <td class="csp-clinic-text-left">{{ $view_data->t_email }}</td>
                                        </tr>
                                    @endif
							  </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel-body">
</div>
@endsection();
</div>
