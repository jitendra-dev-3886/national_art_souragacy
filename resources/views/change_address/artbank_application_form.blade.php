@extends('layouts.clinic.clinic_master')
@section('content')
<style nonce="{{$cspNonce}}">
   .border-color-csp-noc-fortytwo{
   border-color: #0b5ed7; color: #0b5ed7;
   }
   .color-red-fourty-three{
   color: #ff0000;
   }
   .btn-color-border-color-csp-noc-fourty-five{
   background-color: #0b5ed7; border-color: #0b5ed7; color: white;
   }
   .csp-clinic-height{
   height: 20px;
   }
   .csp-clinic-width{
   width:50%;
   }
   .csp-clinic-displaynone{
   display:none;
   }
   input.form-control[readonly], input.form-control:disabled {
    background-color: #f8f8f8;
    border: 1px solid #f3f1f1;
    cursor: not-allowed;
}
</style>
<div class="container-fluid">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
           @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('failure'))
                <div class="alert alert-danger">
                    {{ session('failure') }}
                </div>
            @endif

            <h3>Application Form for ART Bank</h3>
            <!-- Progress Bar -->
            <div class="progress mb-4 csp-clinic-height">
               <div 
                  id="progress-bar"
                  class="progress-bar progress-bar-striped progress-bar-animated csp-clinic-width"
                  role="progressbar"
                  aria-valuenow="50"
                  aria-valuemin="0"
                  aria-valuemax="100">
                  Step 1 of 2
               </div>
            </div>
            <!-- Form -->
            <form id="form-wizard" method="POST" action="{{ route('change_address.submit_application') }}" enctype="multipart/form-data" autocomplete="off">
               <!-- Step 1 -->
               @csrf
               <div id="step-1" class="step">
                  <div class="row">
                     <div class="col-md-6">
								<h3 class=" bc-color-csp-clinic-four" >General Information and Staff Details</h3>
							</div>
							<div class="col-md-6">
							@if(($reject ?? null) === 'Rejected')
								<h3 class="text-success text-center">Resubmission Against Previously Rejected Application</h3>
								<input id="r_id" name="r_id"  value="{{ $encryptedAppId }}" type="hidden">
							@endif
							</div>
                     
                     <div class="col-md-4">
                        <div class="mb-3">
                          <input id="clinic_id" name="clinic_id"  value="{{ $clinic_data->clinic_id }}"
											type="hidden"> 
											<input id="clinic_id" name="applicationno"  value="{{ $clinic_data->application_no }}"
											type="hidden"> 
                                  <input id="clinic_id" name="clinic_type"  value="{{ $clinic_data->clinic_type }}"
											type="hidden"> 
                           <label class="control-label" for="clinicname"><strong>Name of the Bank</strong><span
                              class="color-red-fourty-three">*</span></label>
                           <div class="input-group">
                              <input id="clinicname" name="clinicname" class="form-control" value="{{ $clinic_data->name ?? $draft_data->clinicname ?? $existing_data->clinicname }}"
                                 type="text" readonly/>
                           </div>
                           <div id="errorclinicname" class="color-red-fourty-three"></div>
                           @if ($errors->has('clinicname'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('clinicname') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="address"><strong>Old Address</strong></label>
                              <span class="color-red-fourty-three">*</span>
                           <div class="input-group">
                             <input
                                 type="text"
                                 name="old_address"
                                 class="form-control border-left-end"
                                 value="{{ implode(', ', array_filter([
                                       $clinic_data->address ?? $draft_data->address ?? null,
                                       $clinic_data->district ?? $draft_data->district ?? null,
                                       $clinic_data->state ?? $draft_data->state ?? null,
                                       $clinic_data->pincode ?? $draft_data->pincode ?? null,
                                    ])) }}"
                                 readonly>
                           </div>
                           <div id="" class="color-red-fourty-three"></div>
                        </div>
                     </div>

                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="address"><strong>New Address</strong></label>
                              <span class="color-red-fourty-three">*</span>
                           <div class="input-group">
                              <input type="text" name="address" id="address" placeholder="New Address"
                                 value="{{ $draft_data->address ?? null }}"
                                 class="form-control border-left-end"
                                 maxlength="100">
                           </div>
                           <div id="erroraddress" class="color-red-fourty-three"></div>
                           @if ($errors->has('address'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('address') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>

                     <div class="col-md-3">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="pincode"><strong>New Pincode</strong></label>
                              <span class="color-red-fourty-three">*</span>
                           <div class="input-group">
                              <input type="text" name="pincode" placeholder="New Pincode" id="pincode"
                                 value="{{ $draft_data->pincode ?? null }}"
                                 class="form-control border-left-end"
                                 maxlength="6">
                           </div>
                           <span id="pincodeavailability"></span>
                           <div id="errorpincode" class="color-red-fourty-three"></div>
                           @if ($errors->has('pincode'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('pincode') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>

                      <div class="col-md-3">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="district"><strong>New District</strong></label>
                           <span class="color-red-fourty-three">*</span>
                           <div class="input-group" id="district-container">
                              <input type="text" name="district" placeholder="New District" id="district"
                                 value="{{ $draft_data->district ?? null }}"
                                 class="form-control border-left-end" readonly>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-3">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="state"><strong>New State</strong></label>
                              <span class="color-red-fourty-three">*</span>
                           <div class="input-group">
                              <input type="text" name="state" placeholder="New State" id="state"
                                 value="{{ $draft_data->state ?? null }}"
                                 class="form-control border-left-end" readonly>
                           </div>
                        </div>
                     </div>
                    
                     <div class="col-md-3">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="nature"><strong>Nature
                           of the
                           Organization</strong></label>
                           <span class="color-red-fourty-three">*</span>
                           <div class="input-group">
                              {{-- <select name="nature" id="nature2" class="form-control" >
                                 <option value="">Select</option>
                                 <option value="Government" {{ ($clinic_data->nature ?? $draft_data->nature ?? '') == 'Government' ? 'selected' : '' }}>Government</option>
                                 <option value="Private" {{ ($clinic_data->nature ?? $draft_data->nature ?? '') == 'Private' ? 'selected' : '' }}>Private</option>
                              </select> --}}
                              <input type="text" class="form-control" name="nature" id="nature" value="{{($clinic_data->nature ?? $draft_data->nature ?? '')}}" readonly>
                           </div>
                           <div id="errornature" class="color-red-fourty-three"></div>
                           @if ($errors->has('nature'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('nature') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="email_bank"><strong>E-mail
                           Address of the Organization</strong></label>
                           <span class="color-red-fourty-three">*</span>
                           <div class="input-group">
                              <input type="text" name="email_clinic" placeholder="Enter E-mail Address" id = "email_bank"
                                 value="{{ old('email_clinic', $draft_data ? $draft_data->email : ($clinic_data->email ?? '')) }}" class="form-control">
                           </div>
                           <div id="erroremail_bank" class="color-red-fourty-three"></div>
                           @if ($errors->has('email_clinic'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('email_clinic') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="contactno"><strong>Contact
                           Number</strong></label>
                           <span class="color-red-fourty-three">*</span>
                           <div class="input-group">
                              <input type="text" name="contactno" placeholder="Contact number of clinic" id="contactno"
                                 value="{{ old('contactno', $draft_data ? $draft_data->contactno : ($clinic_data->contact_number_clinic ?? '')) }}" class="form-control"
                                 maxlength="11">
                           </div>
                           <div id="errorcontactno" class="color-red-fourty-three"></div>
                           @if ($errors->has('contactno'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('contactno') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="personname"><strong>Name
                           of the Contact Person</strong><span
                               class="color-red-fourty-three">*</span></label>
                           <div class="input-group">
                              <input type="text" name="personname" placeholder="Name of the Contact Person" id="personname"
                                 value="{{ old('personname', $draft_data ? ($draft_data->contact_person_name ?? '') : ($clinic_data?->contact_person_name ?? '')) }}" class="form-control"
                                 maxlength="100">
                           </div>
                           <div id="errorpersonname" class="color-red-fourty-three"></div>
                           @if ($errors->has('personname'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('personname') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="mobilecontact"><strong>Mobile
                           Number</strong><span
                               class="color-red-fourty-three">*</span></label>
                           <div class="input-group">
                              <input type="text" name="mobilecontact" placeholder="Mobile number of contact person" id="mobilecontact"
                                 value="{{ old('mobilecontact', $draft_data ? ($draft_data->contact_person_mobile ?? '') : ($clinic_data?->mobile ?? '')) }}" class="form-control"
                                 maxlength="10">
                           </div>
                           <div id="errormobilecontact" class="color-red-fourty-three"></div>
                           @if ($errors->has('mobilecontact'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('mobilecontact') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="emailcontact"><strong>E-mail
                           Address</strong><span
                               class="color-red-fourty-three">*</span></label>
                           <div class="input-group">
                              <input type="text" name="emailcontact" placeholder="Enter email address" id ="emailcontact"
                                 value="{{ old('emailcontact', $draft_data ? ($draft_data->contact_person_email ?? '') : ($clinic_data?->contact_person_email ?? '')) }}" class="form-control"
                                 >
                           </div>
                           <div id="erroremailcontact" class="color-red-fourty-three"></div>
                           @if ($errors->has('emailcontact'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('emailcontact') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="fax"><strong>Fax
                           Number</strong></label>
                           <div class="input-group">
                              <input type="text" name="fax" id ="fax" placeholder="Enter Fax number"
                                 class="form-control" value="{{ old('fax', $draft_data ? $draft_data->fax : ($clinic_data->fax_number ?? '')) }}" maxlength="11">
                           </div>
                           <div id="errorfax" class="color-red-fourtyseven"></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="website"><strong>Website</strong></label>
                           <div class="input-group">
                              <input type="text" name="website" placeholder="Enter website URL" id="website"
                                 class="form-control" value="{{ old('website', $draft_data ? ($draft_data->website ?? '') : ($clinic_data?->website ?? '')) }}">
                           </div>
                           <div id="errorwebsite" class="color-red-fourtyseven"></div>

                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="datepicker"><strong>
                           Date of establishment of your ART Bank</strong><span
                              class="color-red-fourty-three">*</span></label>
                           <div class="input-group">
                              <input type="text" name="dateestab"
                                 class="datepicker-default form-control" id="datepicker" 
                                 value="{{ $clinic_data->date_of_establishment ? \Carbon\Carbon::parse($clinic_data->date_of_establishment)->format('d-m-Y'): ''}}" 
                                 readonly>

                              <input type="hidden" name="dateestab"
                                 class="datepicker-default form-control" id="datepicker" 
                                 value="{{ $clinic_data->date_of_establishment ?? ''}}">
                           </div>

                           <div id="errordatepicker" class="color-red-fourty-three"></div>
                           @if ($errors->has('dateestab'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('dateestab') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="datepicker"><strong>1. Date of Registration</strong><span class="color-red-fourty-three"></span></label>
                        <div class="input-group">
                            <input type="text" name="rgistration_date" class="datepicker-default form-control" value="{{ date('d-m-Y',strtotime($clinic_data->rgistration_date )) }}" readonly>

                            <!-- <input type="date" name="registration_date" class="datepicker-default form-control" value="{{ $clinic_data->registration_date }}"> -->
                            <input type="hidden" name="current_registration_date" value="{{ $clinic_data->rgistration_date ?? '' }}">
                            <input type="hidden" name="original_rgistration_date" value="{{ $clinic_data->first_registration_date ?? '' }}">
                        </div>
                        <div id="errordatepicker" class="color-red-fourty-three"></div>
                        @if ($errors->has('original_rgistration_date'))
                                <div class="color-red-fourty-three">
                                    <strong>{{ $errors->first('original_rgistration_date') }}</strong>
                                </div>
                            @endif
                    </div>
                </div>
                  @php
                     $staffData = old('post')
                        ? collect(old('post'))->map(function ($post, $i) {
                           return [
                                 'post'             => $post,
                                 'anyotherpost'     => old('anyotherpost.' . $i),
                                 'name'             => old('name_otherstaff.' . $i),
                                 'quali_otherstaff' => old('quali_otherstaff.' . $i),
                                 'anyotherdegree'   => old('anyotherdegree.' . $i),
                           ];
                        })
                        : ($staff ?? collect([[]])); // ensures at least one row
                     @endphp
                     <div id="otherstaff" class="col-xs-12 form-group">
                        <label class="control-label" for=""><strong>5. Provide details of the staff.</strong></label>
                        <div class="table-responsive">
                           <table class="table table-bordered" id="crud_table_otherstaff">
                              <tr>
                                 <th width="">Name<span class="color-red-fourty-three">*</span></th>
                                 <th width="">Designation<span class="color-red-fourty-three">*</span>
                                 </th>
                                 <th width="">Reg No</th>
                                 <th width="">Qualification<span class="color-red-fourty-three">*</span>
                                 </th>
                                 <th width="">Action</th>
                              </tr>
                              @foreach($staffData as $i => $row)
                              <tr class="staff-row">
                                 <td>
                                    <input type="text" name="name_otherstaff[]" value="{{ $row['name'] ?? '' }}" placeholder="Staff Name" class="form-control" >
                                    @error('name_otherstaff.'.$i)
                                    <div class="color-red-fourty-three"><small>{{ $message }}</small></div>
                                    @enderror
                                 </td>
                                 @php
                                     $post = trim($row['post'] ?? '');
                                     $otherPost = trim($row['anyotherpost'] ?? '');

                                     $isOtherPost = $post !== '' &&
                                         $post !== 'Registered Medical Practioner';
                                 @endphp

                                 <td>
                                     <select name="post[]" class="form-control post-select">
                                         <option value="">Select</option>

                                         <option value="Registered Medical Practioner"
                                             {{ $post === 'Registered Medical Practioner' ? 'selected' : '' }}>
                                             Registered Medical Practioner
                                         </option>

                                         <option value="Any Other"
                                             {{ ($post === 'Any Other' || $isOtherPost) ? 'selected' : '' }}>
                                             Any Other
                                         </option>
                                     </select>

                                     @error('post.'.$i)
                                         <div class="color-red-fourty-three">
                                             <small>{{ $message }}</small>
                                         </div>
                                     @enderror

                                     <input
                                         type="text"
                                         name="anyotherpost[]"
                                         value="{{ $isOtherPost ? $post : $otherPost }}"
                                         placeholder="Specify other post"
                                         class="form-control mt-2 anyotherpost-input
                                             {{ ($post === 'Any Other' || $isOtherPost) ? '' : 'csp-clinic-displaynone' }}"
                                     >

                                     @error('anyotherpost.'.$i)
                                         <div class="color-red-fourty-three">
                                             <small>{{ $message }}</small>
                                         </div>
                                     @enderror
                                 </td>
                                 <td>
                                    <input type="text" name="regno[]" value="{{ $row['regno'] ?? '' }}" placeholder="Reg Number" class="form-control">
                                    @error('regno.'.$i)
                                    <div class="color-red-fourty-three"><small>{{ $message }}</small></div>
                                    @enderror
                                 </td>
                                @php
                                    $qualification = trim($row['qualification'] ?? '');

                                    $standardQualifications = [
                                         'Doctorate',
                                         'Post Graduate',
                                         'Graduate',
                                         'Diploma',
                                         'Under Graduate'
                                     ];

                                    $isOtherQualification = $qualification !== '' && !in_array($qualification, $standardQualifications);
                                 @endphp

                                 <td>
                                     <select name="quali_otherstaff[]" class="form-control quali-select">
                                         <option value="">Select</option>

                                         @foreach($standardQualifications as $item)
                                             <option value="{{ $item }}"
                                                 {{ $qualification === $item ? 'selected' : '' }}>
                                                 {{ $item }}
                                             </option>
                                         @endforeach

                                         <option value="Any Other"
                                             {{ $isOtherQualification ? 'selected' : '' }}>
                                             Any Other
                                         </option>
                                     </select>

                                     @error('quali_otherstaff.'.$i)
                                         <div class="color-red-fourty-three">
                                             <small>{{ $message }}</small>
                                         </div>
                                     @enderror

                                     <input
                                         type="text"
                                         name="anyotherdegree[]"
                                         value="{{ $isOtherQualification ? $qualification : ($row['anyotherdegree'] ?? '') }}"
                                         placeholder="Specify other qualification"
                                         class="form-control mt-2 anyotherdegree-input"
                                         {{ $isOtherQualification ? '' : 'hidden' }}
                                     >

                                     @error('anyotherdegree.'.$i)
                                         <div class="color-red-fourty-three">
                                             <small>{{ $message }}</small>
                                         </div>
                                     @enderror
                                 </td>
                                 <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                                 </td>
                              </tr>
                              @endforeach
                           </table>
                           <div align="right">
                              <button type="button" name="addotherstaff" id="addotherstaff"
                                 class="btn-xs btn-color-border-color-csp-noc-fourty-five">+</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <button type="button" class="btn btn-primary btn-color-border-color-csp-noc-fourty-five" id="next-step">Next</button>
               </div>

               <!-- Step 2 -->
               <div id="step-2" class="step d-none">
                  <div class="row">
                     <h3 class="border-color-csp-noc-fortytwo">Procedures</h3>

                     @php
                        $equipmentsData = old('equipmentname')
                              ? collect(old('equipmentname'))->map(fn($eq) => (object)['equipmentname' => $eq])
                              : ($equipment ?? collect([(object)['equipmentname' => '']]));
                     @endphp

                     <div id="equipment" class="col-xs-12 form-group">
                        <label class="control-label" for="">6. Provide list of Equipment's</label>
                        <div class="table-responsive">
                           <table class="table table-bordered" id="crud_table_equipments">
                              <tr>
                                 <th width="">Name of Equipments<span class="color-red-fourty-three">*</span>
                                 </th>
                              </tr>

                              @foreach($equipmentsData as $i => $row)
                                 <tr class="equipment-row" id="row1{{ $i+1 }}">
                                       <td>
                                          <input type="text" id="equipmentname" name="equipmentname[]"
                                             value="{{ $row->equipmentname ?? '' }}"
                                             placeholder="" class="form-control equipmentname">
                                          <div id="errorequipmentname" class="color-csp-clinic-two"></div>
                                          @error('equipmentname.' . $i)
                                             <div class="color-csp-clinic-two text-danger"><strong>{{ $message }}</strong></div>
                                          @enderror
                                       </td>
                                       <td>
                                          @if($i > 0) 
                                             <button type="button" id="{{ $i+1 }}" class="btn btn-danger btn_remove_addEQ">
                                                   <i class="fa fa-trash"></i>
                                             </button>
                                          @endif
                                       </td>
                                 </tr>
                              @endforeach
                           </table>
                           <div align="right">
                              <button type="button" name="addequipment" id="addequipment"
                                 class="btn-xs btn-color-border-color-csp-noc-fourty-five">+</button>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="mb-3">
                           <label class="control-label" for=""><strong>7. Indicate which of the
                           following ART
                           procedures are being routinely carried out at
                           your ART Bank
                           </strong></label>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="mb-3">
                           <label class="control-label" for=""><strong>i). Collection of Semen
                           </strong></label>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="text-label form-label"
                                 for="validationCustomUsername"><strong>a).
                              ejaculation<span
                                 class="color-red-fourty-three">*</span></strong></label>
                              <div class="input-group">
                                 <select name="ejaculation" id="ejaculation"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('ejaculation', $draft_data->ejaculation ?? $clinic_data->ejaculation ??  '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('ejaculation', $draft_data->ejaculation ?? $clinic_data->ejaculation ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorejaculation" class="color-red-fourty-three"></div>
                              @if ($errors->has('ejaculation'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('ejaculation') }}</strong>
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="text-label form-label"
                                 for="validationCustomUsername"><strong>
                              b). electrojaculation (in
                              case of retrograde ejaculation)<span
                                 class="color-red-fourty-three">*</span></strong></label>
                              <div class="input-group">
                                 <select name="electrojaculation" id="electrojaculation"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('electrojaculation', $draft_data->electrojaculation ?? $clinic_data->electrojaculation ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('electrojaculation', $draft_data->electrojaculation ?? $clinic_data->electrojaculation ??'') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorelectrojaculation" class="color-red-fourty-three"></div>
                              @if ($errors->has('electrojaculation'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('electrojaculation') }}</strong>
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="text-label form-label"
                                 for="validationCustomUsername"><strong>ii). Processing of Sperm<span
                                 class="color-red-fourty-three">*</span></strong></label>
                              <div class="input-group">
                                 <select name="processing_sperm" id="processing_sperm"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('processing_sperm', $draft_data->processing_sperm ?? $clinic_data->processing_sperm ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('processing_sperm', $draft_data->processing_sperm ?? $clinic_data->processing_sperm ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorprocessing_sperm" class="color-red-fourty-three"></div>
                              @if ($errors->has('processing_sperm'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('processing_sperm') }}</strong>
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="text-label form-label"
                                 for="validationCustomUsername"><strong>iii). Storage of Sperm<span
                                 class="color-red-fourty-three">*</span></strong></label>
                              <div class="input-group">
                                 <select name="storage_sperm" id="storage_sperm"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('storage_sperm', $draft_data->storage_sperm ?? $clinic_data->storage_sperm ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('storage_sperm', $draft_data->storage_sperm ??  $clinic_data->storage_sperm ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorstorage_sperm" class="color-red-fourty-three"></div>
                              @if ($errors->has('storage_sperm'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('storage_sperm') }}</strong>
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="text-label form-label"
                                 for="validationCustomUsername"><strong>iv). Provision/sourcing of
                              Oocyte Donor<span
                                 class="color-red-fourty-three">*</span></strong></label>
                              <div class="input-group">
                                 <select name="oocyte_doner" id="oocyte_doner"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('oocyte_doner', $draft_data->oocyte_doner ?? $clinic_data->oocyte_doner ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('oocyte_doner', $draft_data->oocyte_doner ?? $clinic_data->oocyte_doner ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="erroroocyte_doner" class="color-red-fourty-three"></div>
                              @if ($errors->has('oocyte_doner'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('oocyte_doner') }}</strong>
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="text-label form-label"
                                 for="validationCustomUsername"><strong>5. Cryopreservation of
                              Sperm<span
                                 class="color-red-fourty-three">*</span></strong></label>
                              <div class="input-group">
                                 <select name="cryopreservation_of_sperm" id="cryopreservation_of_sperm"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('cryopreservation_of_sperm', $draft_data->cryopreservation_of_sperm ?? $clinic_data->cryopreservation_of_sperm ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('cryopreservation_of_sperm', $draft_data->cryopreservation_of_sperm ?? $clinic_data->cryopreservation_of_sperm ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorcryopreservation_of_sperm" class="color-red-fourty-three"></div>
                              @if ($errors->has('cryopreservation_of_sperm'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('cryopreservation_of_sperm') }}</strong>
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="mb-3">
                              <label class="control-label" for=""><strong>6. Method of Freezing of
                              Sperm
                              </strong></label>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="text-label form-label"
                                 for="validationCustomUsername"><strong>i). Sperm Slow Freezing<span
                                 class="color-red-fourty-three">*</span></strong></label>
                              <div class="input-group">
                                 <select name="methode_of_freezing_of_sperm" id="methode_of_freezing_of_sperm"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('methode_of_freezing_of_sperm', $draft_data->methode_of_freezing_of_sperm ?? $clinic_data->methode_of_freezing_of_sperm ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('methode_of_freezing_of_sperm', $draft_data->methode_of_freezing_of_sperm ?? $clinic_data->methode_of_freezing_of_sperm ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errormethode_of_freezing_of_sperm" class="color-red-fourty-three"></div>
                              @if ($errors->has('methode_of_freezing_of_sperm'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('methode_of_freezing_of_sperm') }}</strong>
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="text-label form-label"
                                 for="validationCustomUsername"><strong>ii). Sperm Vitrification<span
                                 class="color-red-fourty-three">*</span></strong></label>
                              <div class="input-group">
                                 <select name="sperm_vitrification" id="sperm_vitrification"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>	
                                    <option value="Yes" {{ old('sperm_vitrification', $draft_data->sperm_vitrification ?? $clinic_data->sperm_vitrification ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('sperm_vitrification', $draft_data->sperm_vitrification ?? $clinic_data->sperm_vitrification ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorsperm_vitrification" class="color-red-fourty-three"></div>
                              @if ($errors->has('sperm_vitrification'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('sperm_vitrification') }}</strong>
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                              <label class="text-label form-label"
                                 for="validationCustomUsername"><strong>7. Whether Freezing of
                              Testicular Tissue<span class="color-red-fourty-three">*</span></strong></label>
                              <div class="input-group">
                                 <select name="freezing_of_testicular_tissue" id='freezing_of_testicular_tissue'
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('freezing_of_testicular_tissue', $draft_data->freezing_of_testicular_tissue ?? $clinic_data->freezing_of_testicular_tissue ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('freezing_of_testicular_tissue', $draft_data->freezing_of_testicular_tissue ?? $clinic_data->freezing_of_testicular_tissue ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorfreezing_of_testicular_tissue" class="color-red-fourty-three"></div>
                              @if ($errors->has('freezing_of_testicular_tissue'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('freezing_of_testicular_tissue') }}</strong>
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="mb-3">
                              <label for="field2" class="form-label"><strong>8. Any other
                              details</strong></label>
                              <textarea class="form-control" id="otherdetails" name="otherdetails" maxlength="500" 
                                 rows="4" cols="163">{{ old('otherdetails', $draft_data->otherdetails ?? $clinic_data->any_other_detail ??'') }}</textarea>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-9 mb-4">
                           <input type="checkbox" id="declaration" name="declaration">
                           <b> I hereby declare that the entries in this form and the additional
                           particulars , if any,furnished herewith are true to the best of my
                           knowledge and belief.<span
                              class="color-red-fourty-three">*</span> </b>
                              @if(($reject ?? null) === 'Rejected')
									<hr>
										<span>✓✓ <b>Fees already paid {{$fees ?? '-'}}/-</b> </span>
									@endif
                           <small class="text-danger">
                              @error('declaration') <strong> {{ $message }} </strong> @enderror 
                           </small>
                        </div>
                     </div>
                  </div>

                  <button type="button" class="btn btn-secondary btn-color-border-color-csp-noc-fourty-five" id="prev-step">Back</button>
                 <button type="submit" id="draftButton" name="submit_type" value="draft" class="btn btn-success bc-bc-color-csp-clinic-three">Save As draft</button>
						<button  type="submit" id="submitButton" name="submit_type" value="final" class="btn btn-success bc-bc-color-csp-clinic-three">Submit</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
</div>

<script nonce="{{$cspNonce}}">
   document.addEventListener('DOMContentLoaded', function() {
       const submitButton = document.getElementById('submitButton');
       const draft_dataButton = document.getElementById('draftButton');
       
       if (submitButton) {
           submitButton.addEventListener('click', function(event) {
               if (!validatesubmit()) {
                   event.preventDefault();
               }
           });
       }
       
       if (draft_dataButton) {
           draft_dataButton.addEventListener('click', function(event) {
               if (!validatesdraft_data()) {
                   event.preventDefault();
               }
           });
       }
   });
</script>

<style nonce="{{$cspNonce}}">
   .step-indicator { display: flex; justify-content: center; gap: 10px; margin-bottom: 20px; }
   .indicator { width: 20px; height: 20px; border-radius: 50%; background-color: #e9ecef; }
   .indicator.active { background-color: #0d6efd; }
   .progress-bar { background-color: #0d6efd; }
</style>

<script nonce="{{ $cspNonce }}">
$(document).ready(function () {
    
    // 1. PINCODE AJAX
    $('#pincode').blur(function () {
        var pincode = $(this).val();
        if (pincode === "") {
            $('#state').val('');
            $('#district-container').html('<input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />');
            $('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
        } else {
            $.ajax({
                url: "{{ route('pincode.signup') }}",
                method: "POST",
                data: { pincode: pincode, _token: "{{ csrf_token() }}" },
                success: function (data) {
                    if (data.success) {
                        $('#state').val(data.state);
                        $('#pincodeavailability').html('');
   
                        if (data.districts.length > 1) {
                            let districtDropdown = '<select name="district" id="district" class="form-control">';
                            districtDropdown += '<option value="">Select District</option>';
                            data.districts.forEach(district => {
                                districtDropdown += `<option value="${district}">${district}</option>`;
                            });
                            districtDropdown += '</select>';
                            $('#district-container').html(districtDropdown);
                        } else if (data.districts.length === 1) {
                            $('#district-container').html(`<input type="text" name="district" id="district" value="${data.districts[0]}" class="form-control" readonly />`);
                        } else {
                            $('#district-container').html('<input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />');
                            $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                        }
                    } else {
                        $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                        $('#state').val('');
                        $('#district-container').html('<input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />');
                    }
                },
                error: function (xhr, status, error) { console.error('Error:', error); }
            });
        }
    });

    // 2. OTHER STAFF - "Any Other" Visibility
   $('#crud_table_otherstaff').on('change', '.post-select', function () {
       const $row = $(this).closest('tr');
       const $anyotherInput = $row.find('.anyotherpost-input');

       if ($(this).val() === 'Any Other') {
           $anyotherInput
               .removeAttr('hidden')
               .removeClass('csp-clinic-displaynone')
               .show();
       } else {
           $anyotherInput
               .attr('hidden', true)
               .addClass('csp-clinic-displaynone')
               .hide()
               .val('');
       }
   });


   $('#crud_table_otherstaff').on('change', '.quali-select', function () {
       const $row = $(this).closest('tr');
       const $anyotherInput = $row.find('.anyotherdegree-input');

       if ($(this).val() === 'Any Other') {
           $anyotherInput
               .removeAttr('hidden')
               .removeClass('csp-clinic-displaynone')
               .show();
       } else {
           $anyotherInput
               .attr('hidden', true)
               .addClass('csp-clinic-displaynone')
               .hide()
               .val('');
       }
   });

   // Initialize visibility for existing rows
   $('#crud_table_otherstaff .post-select, #crud_table_otherstaff .quali-select').trigger('change');

    // 3. OTHER STAFF - Add/Remove Rows
    $('#addotherstaff').click(function () {
        let newRow = $('#crud_table_otherstaff .staff-row:first').clone();
        
        // Clear inputs, avoid duplicate IDs
        newRow.find('input, select').val('').removeAttr('id');
        
        // FIX: Removed .attr('required') entirely for cloned rows
        newRow.find('.anyotherpost-input, .anyotherdegree-input').addClass('csp-clinic-displaynone').hide();
        
        // Remove error messages from clone
        newRow.find('.inline-error, .color-red-fourtyseven').html(''); 
        
        $('#crud_table_otherstaff').append(newRow);
    });
   
    $(document).on('click', '.remove-row', function () {
        if ($('#crud_table_otherstaff .staff-row').length > 1) {
            $(this).closest('tr').remove();
        } else {
            alert("At least one staff member must be present.");
        }
    });

    // 4. EQUIPMENT - Add/Remove Rows & Limits
    $('#addequipment').click(function() {
        $('#crud_table_equipments').append(
            '<tr class="equipment-row">' +
                '<td><input type="text" name="equipmentname[]" placeholder="" class="form-control" maxlength="100"></td>' +
                '<td><button type="button" class="btn btn-danger btn_remove_addEQ"><i class="fa fa-trash"></i></button></td>' +
            '</tr>'
        );
    });

    $(document).on('click', '.btn_remove_addEQ', function() {
        if ($('#crud_table_equipments .equipment-row').length > 1) {
            $(this).closest('tr').remove();
        } else {
            alert("At least one equipment row is required.");
        }
    });

    // Equipment 100 character limit enforcement
    $(document).on('input', 'input[name="equipmentname[]"]', function () {
        var value = $(this).val();
        if (value.length > 100) {
            $(this).val(value.substring(0, 100));
            alert('Maximum 100 characters allowed for each equipment entry. If you need to add more equipment, please click on the "+" button.');
        }
    });

    // 5. STEP NAVIGATION
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const progressBar = document.getElementById('progress-bar');
   
    document.getElementById('next-step').addEventListener('click', () => {
        step1.classList.add('d-none');
        step2.classList.remove('d-none');
        progressBar.style.width = '100%';
        progressBar.setAttribute('aria-valuenow', '100');
        progressBar.innerText = 'Step 2 of 2';
    });
   
    document.getElementById('prev-step').addEventListener('click', () => {
        step2.classList.add('d-none');
        step1.classList.remove('d-none');
        progressBar.style.width = '50%';
        progressBar.setAttribute('aria-valuenow', '50');
        progressBar.innerText = 'Step 1 of 2';
    });
});
</script>

<script nonce="{{ $cspNonce }}" type="text/javascript">
   function validateAadhar(input) {
       input.value = input.value.replace(/\D/g, '');
       if (input.value.length > 4) {
           input.value = input.value.slice(0, 4);
       }
   }
</script>

<script nonce="{{ $cspNonce }}">
   // VALIDATION HELPER FUNCTIONS
   const byId = (id) => document.getElementById(id);

   const setErrorForId = (id, msg) => { const el = byId(id); if (el) el.innerHTML = `<span class="text-danger">${msg}</span>`; };
   const clearErrorForId = (id) => { const el = byId(id); if (el) el.innerHTML = ""; };

   const setRowError = (row, fallbackId, inputEl, msg) => {
       let holder = fallbackId ? row.querySelector('#' + fallbackId) : null;
       if (!holder) {
           holder = row.querySelector('.inline-error');
           if (!holder) {
               holder = document.createElement('div');
               holder.className = 'inline-error text-danger mt-1';
               holder.style.fontSize = '12px';
               (inputEl && inputEl.parentElement ? inputEl.parentElement : row).appendChild(holder);
           }
       }
       holder.innerHTML = `<span class="text-danger">${msg}</span>`;
   };

   const clearRowError = (row, fallbackId) => {
       if (fallbackId) {
           const holder = row.querySelector('#' + fallbackId);
           if (holder) holder.textContent = "";
       }
       const inline = row.querySelector('.inline-error');
       if (inline) inline.textContent = "";
   };

   const focusAndStop = (el) => {
      if (!el) return false;
       
       // Switch step tabs if the error is hidden
      const step1 = document.getElementById('step-1');
      const step2 = document.getElementById('step-2');
       
      if (step1 && el.closest('#step-1') && step1.classList.contains('d-none')) {
           document.getElementById('prev-step').click();
      } else if (step2 && el.closest('#step-2') && step2.classList.contains('d-none')) {
           document.getElementById('next-step').click();
      }

       // Safety fallback: Strip native required right before focusing
      el.removeAttribute('required');

      if (el.focus) el.focus({ preventScroll: true });
      if (el.scrollIntoView) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
       
      return false;
   };

   // FORM SUBMISSION FUNCTIONS
   // function validatesdraft_data() {
   //     const allInputs = document.querySelectorAll("input[type='text'], textarea");
   //     const forbiddenPattern = /[<>$%#{}[\];'"`]/; 
       
   //     for (let el of allInputs) {
   //         if (el.value && forbiddenPattern.test(el.value)) {
   //             alert(`Invalid characters detected in "${el.name || el.id}". Special characters are not allowed.`);
   //             return focusAndStop(el);
   //         }
   //     }
   //     return true;
   // }

   function validatesubmit() {
      
      const allInputs = document.querySelectorAll("input[type='text'], textarea");
        
        const forbiddenPattern = /[<>$%{}[\];'"`]/;
        const addressPattern = /[<>$%{}[\];'"`]/;

        for (let el of allInputs) {
            const fieldName = (el.name || el.id || "").toLowerCase();
            const pattern = fieldName === "address" || fieldName === "old_address"
                ? addressPattern
                : forbiddenPattern;

            if (el.value && pattern.test(el.value)) {
                alert(`Invalid characters detected in "${el.name || el.id}". Special characters are not allowed.`);
                el.focus();
                return false;
            }
        }

    // ---------- 1) Basic Fields ----------
    const formLabels = {
       clinicname:'Clinic Name', address:'Address', pincode:'Pincode',
       district:'District', nature:'Nature of the Organization',
       email_bank:'Bank Email Address', contactno:'Contact Number',
       personname:'Name of the Contact Person', mobilecontact:'Mobile Number',
       emailcontact:'Contact Person Email', fax:'Fax Number', website:'Website'
   };

   const bank_form_elements = [
       'clinicname','address','pincode','district','nature',
       'email_bank','contactno','personname','mobilecontact','emailcontact'
   ];

   const rules = {
       email_bank: [/^[^\s@]+@[^\s@]+\.[^\s@]+$/, 'valid email address'],
       emailcontact: [/^[^\s@]+@[^\s@]+\.[^\s@]+$/, 'valid email address'],
       contactno:  [/^[0-9]{11}$/, 'valid 11-digit mobile number'],
       personname: [/^[A-Za-z ]+$/, 'only alphabets and spaces'],
       mobilecontact: [/^[6-9][0-9]{9}$/, 'valid 10-digit mobile number'],
       pincode: [/^[1-9][0-9]{5}$/, 'valid 6-digit Pincode'],
       fax: [/^\d{11}$/, 'valid Fax Number'],
       website: [/^(https?:\/\/)?([\w-]+\.)+[\w-]{2,}(\/.*)?$/i, 'valid Website']
   };

   for (const id of bank_form_elements) {
       const el = byId(id);
       if (!el) continue;

       const value = (el.value || '').trim();
       const err = `error${id}`;
       const label = formLabels[id];

       if (!value) {
           const msg = el.tagName === 'SELECT'
               ? `Please select ${label}`
               : `${label} cannot be blank`;

           setErrorForId(err, msg);
           alert(msg);
           return focusAndStop(el);
       }

       const rule = rules[id];

       if (rule && !rule[0].test(value)) {
           const msg = `Please enter a ${rule[1]}`;
           setErrorForId(err, msg);
           alert(msg);
           return focusAndStop(el);
       }

       clearErrorForId(err);
   }

   for (const id of ['fax', 'website']) {
       const el = byId(id);
       if (!el) continue;

       const value = (el.value || '').trim();
       if (!value) continue;

       const rule = rules[id];

       if (rule && !rule[0].test(value)) {
           const msg = `Please enter a ${rule[1]}`;
           setErrorForId(`error${id}`, msg);
           alert(msg);
           return focusAndStop(el);
       }

       clearErrorForId(`error${id}`);
   }

    // ---------- 2) Date ----------
    const datepicker = byId("datepicker");
    if (datepicker && !datepicker.value) {
        setErrorForId("errordatepicker", "Date of establishment of your ART Bank cannot be blank");
        alert("Date of establishment of your ART Bank cannot be blank");
        return focusAndStop(datepicker);
    } else clearErrorForId("errordatepicker");

   // ---------- 3) Other Staff ----------
   const rows = document.querySelectorAll("#crud_table_otherstaff .staff-row");

      for (const row of rows) {

        const postSelect  = row.querySelector('select[name="post[]"]');
        const nameInput   = row.querySelector('input[name="name_otherstaff[]"]');
        const qualiSelect = row.querySelector('select[name="quali_otherstaff[]"]');
        const anyPost     = row.querySelector('input[name="anyotherpost[]"]');
        const anyDegree   = row.querySelector('input[name="anyotherdegree[]"]');

        // Remove previous errors
        row.querySelectorAll('.staff-validation-error').forEach(el => el.remove());

        // Post
        if (postSelect && !postSelect.value.trim()) {

            postSelect.insertAdjacentHTML(
                'afterend',
                '<span class="text-danger staff-validation-error">Designation of staff cannot be blank</span>'
            );

            alert("Designation of staff cannot be blank");
            return focusAndStop(postSelect);
        }

        // Name
        if (nameInput && !nameInput.value.trim()) {

            nameInput.insertAdjacentHTML(
                'afterend',
                '<span class="text-danger staff-validation-error">Name of staff cannot be blank</span>'
            );

            alert("Name of staff cannot be blank");
            return focusAndStop(nameInput);
        }

        if (nameInput && !/^[A-Za-z ]+$/.test(nameInput.value.trim())) {

            nameInput.insertAdjacentHTML(
                'afterend',
                '<span class="text-danger staff-validation-error d-block">Name of staff must contain only alphabets and spaces</span>'
            );

            alert('Name of staff must contain only alphabets and spaces');
            nameInput.focus();
            return false;
        }

        // Qualification
        if (qualiSelect && !qualiSelect.value.trim()) {

            qualiSelect.insertAdjacentHTML(
                'afterend',
                '<span class="text-danger staff-validation-error">Qualification of staff cannot be blank</span>'
            );

            alert("Qualification of staff cannot be blank");
            return focusAndStop(qualiSelect);
        }

        // Any Other Post
        if (postSelect && postSelect.value === "Any Other") {

            if (!anyPost || !anyPost.value.trim()) {

                (anyPost || postSelect).insertAdjacentHTML(
                    'afterend',
                    '<span class="text-danger staff-validation-error">Name of the other Designation cannot be blank</span>'
                );

                alert("Name of the other Designation cannot be blank");
                return focusAndStop(anyPost || postSelect);
            }
        }

        // Any Other Qualification
        if (qualiSelect && qualiSelect.value === "Any Other") {

            if (!anyDegree || !anyDegree.value.trim()) {

                (anyDegree || qualiSelect).insertAdjacentHTML(
                    'afterend',
                    '<span class="text-danger staff-validation-error">Other Qualification cannot be blank</span>'
                );

                alert("Other Qualification cannot be blank");
                return focusAndStop(anyDegree || qualiSelect);
            }
        }
    }


    // ---------- 4) Equipment ----------
    const eqInputs = document.querySelectorAll('#crud_table_equipments input[name="equipmentname[]"]');
    if (eqInputs.length === 0) {
        alert("Please add at least one equipment");
        return false;
    }
    for (const input of eqInputs) {
        const row = input.closest("tr");
        if (row) clearRowError(row, "errorequipmentname");
        if (!input.value.trim()) {
            if (row) setRowError(row, "errorequipmentname", input, "Name of equipment cannot be blank");
            alert("Name of equipment cannot be blank");
            return focusAndStop(input);
        }
    }

    // ---------- 5) Procedures (ART Bank specific) ----------
    const bankProcedures = [
        {id:"ejaculation", msg:"Ejaculation cannot be blank"},
        {id:"electrojaculation", msg:"Electrojaculation cannot be blank"},
        {id:"processing_sperm", msg:"Processing of Sperm cannot be blank"},
        {id:"storage_sperm", msg:"Storage of Sperm cannot be blank"},
        {id:"oocyte_doner", msg:"Provision/sourcing of Oocyte Donor cannot be blank"},
        {id:"cryopreservation_of_sperm", msg:"Cryopreservation of Sperm cannot be blank"},
        {id:"methode_of_freezing_of_sperm", msg:"Sperm Slow Freezing cannot be blank"},
        {id:"sperm_vitrification", msg:"Sperm Vitrification cannot be blank"},
        {id:"freezing_of_testicular_tissue", msg:"Freezing of Testicular Tissue cannot be blank"}
    ];

    for (const proc of bankProcedures) {
        const el = byId(proc.id);
        if (el && !el.value) {
            setErrorForId("error" + proc.id, proc.msg);
            alert(proc.msg);
            return focusAndStop(el);
        } else clearErrorForId("error" + proc.id);
    }

    // ---------- 6) Declaration ----------
    const decl = byId("declaration");
    if (decl && !decl.checked) {
        alert("Please accept the declaration before submitting.");
        return focusAndStop(decl);
    }

    // Final confirm
    const agree = confirm("Kindly check and confirm all details before final submission. There is no provision for editing/correction once application form submitted.");
    return !!agree;
}
</script>
@endsection