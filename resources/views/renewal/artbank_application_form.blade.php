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
            @elseif (session('failure'))
            <div class="alert alert-danger">
               {{ session('failure') }}
            </div>
            @endif

            @if($allowRenewal ?? false)
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
            <form id="form-wizard" method="POST" action="{{ route('renewal.submit_sc_application') }}" enctype="multipart/form-data" autocomplete="off">
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
                          <input id="clinic_id" name="clinic_id"  value="{{ $encryptedClinicId }}"
											type="hidden"> 
											{{-- <input id="clinic_id" name="applicationno"  value="{{ $clinic_data->application_no }}"
											type="hidden">  --}}
                                  <input id="clinic_id" name="clinic_type"  value="{{ $clinic_data->clinic_type }}"
											type="hidden"> 
                           <label class="control-label" for="clinicname"><strong>Name of the Bank</strong><span
                              class="color-red-fourty-three">*</span></label>
                           <div class="input-group">
                              <input id="clinicname" name="clinicname" class="form-control" value="{{ $clinic_data->name ?? $draft_data->name ?? '' }}"
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
                     <div class="col-md-8">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="address"><strong>Address</strong></label>
                              <span class="color-red-fourty-three">*</span>
                           <div class="input-group">
                              <input type="text" name="address" id="address"
                                 value="{{ $clinic_data->address ?? $draft_data->address ?? '' }}"
                                 class="form-control border-left-end" readonly>
                           </div>
                           <div id="erroraddress" class="color-red-fourty-three"></div>
                           @if ($errors->has('address'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('address') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="pincode"><strong>Pincode</strong></label>
                              <span class="color-red-fourty-three">*</span>
                           <div class="input-group">
                              <input type="text" name="pincode" placeholder="" id="pincode"
                                 value="{{ $clinic_data->pincode ?? $draft_data->pincode ?? '' }}"
                                 class="form-control border-left-end" readonly>
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
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="state"><strong>State</strong></label>
                           <div class="input-group">
                              <input type="text" name="state" placeholder="state" id="state"
                                 value="{{ $clinic_data->state ?? $draft_data->state ?? '' }}"
                                 class="form-control border-left-end" readonly>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="district"><strong>District</strong></label>
                           <div class="input-group" id="district-container">
                              <input type="text" name="district" placeholder="district" id="district"
                                 value="{{ $clinic_data->district ?? $draft_data->district ?? '' }}"
                                 class="form-control border-left-end" readonly>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
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
                              <input type="text" name="email_clinic" placeholder="" id = "email_bank"
                                 value="{{ $clinic_data->email ?? $draft_data->email ?? '' }}" class="form-control"
                                 readonly>
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
                              <input type="text" name="contactno" placeholder="Contact number of clinic (11 digit)" id="contactno" pattern="^[0-9]{11}$"
                                 value="{{ $clinic_data->contact_number_clinic ?? $draft_data->contactno ?? '' }}" class="form-control"
                                 required>
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
                              <input type="text" name="personname" placeholder="" id="personname"
                                 value="{{ $clinic_data->contact_person_name ?? $draft_data->contact_person_name ?? '' }}" class="form-control"
                                 >
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
                              <input type="text" name="mobilecontact" placeholder="Mobile number of contact person (10 digit)" id="mobilecontact" pattern="^[0-9]{10}$"
                                 value="{{ $clinic_data->mobile ?? $draft_data->contact_person_mobile ?? '' }}" class="form-control"
                                 >
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
                              <input type="text" name="emailcontact" placeholder="" id ="emailcontact"
                                 value="{{ $clinic_data->contact_person_email ?? $draft_data->contact_person_email ?? '' }}" class="form-control"
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
                              <input type="text" name="fax" id ="fax" placeholder="fax number (11 Digit)" pattern="^[0-9]{11}$"
                                 class="form-control" value="{{ old('fax',$draft_data->fax ?? $clinic_data->fax_number ?? '') }}">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="website"><strong>Website</strong></label>
                           <div class="input-group">
                              <input type="text" name="website" placeholder="" id="website"
                                 class="form-control" value="{{ old('fax',$draft_data->website ?? $clinic_data->website ??'') }}">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="datepicker"><strong>1.
                           Date of establishment of your ART Bank</strong><span
                              class="color-red-fourty-three">*</span></label>
                           <div class="input-group">
                              {{-- <input type="date" name="dateestab"
                                 class="datepicker-default form-control" id="datepicker" value="{{ old('dateestab',$draft_data->dateestab ?? $clinic_data->date_of_establishment ??'') }}"> --}}
                                 <input type="date" name="dateestab"
                                 class="datepicker-default form-control" id="datepicker" value="{{ old('dateestab',$draft_data->dateestab ?? $clinic_data->date_of_establishment ??'') }}" readonly>
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
                            for="datepicker"><strong>Date of Registration</strong><span class="color-red-fourty-three"></span></label>
                        <div class="input-group">
                            <input type="text" class="datepicker-default form-control" value="{{ date('d-m-Y',strtotime($clinic_data->rgistration_date )) }}" disabled>
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
                                 <th width="">Qualification<span class="color-red-fourty-three">*</span>
                                 </th>
                              </tr>
                              @foreach($staffData as $i => $row)
                              <tr class="staff-row">
                                 <td>
                                    <input type="text" id="nameotherstaff" name="name_otherstaff[]" value="{{ $row['name'] ?? '' }}" placeholder="" class="form-control">
                                    <div id="errornameotherstaff" class="color-red-fourty-three"></div>
                                    @error('name_otherstaff.0')
                                    <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                    @enderror
                                 </td>
                                 <td>
                                    <select id="designationotherstaff" name="post[]" class="form-control">
                                       <option value="">Select</option>
                                       <option value="Registered Medical Practioner" {{ ($row['post'] ?? '') == 'Registered Medical Practioner' ? 'selected' : '' }}>Registered Medical Practioner</option>
                                       <option value="Any Other" {{ ($row['post'] ?? '') == 'Any Other' ? 'selected' : '' }}>Any Other</option>
                                    </select>
                                    <div id="errorpost" class="color-red-fourty-three"></div>
                                    @error('post.0')
                                    <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                    @enderror
                                    <input type="text" id="anyotherpost" name="anyotherpost[]" value="{{ $row['post'] ?? '' }}" placeholder=""
                                       class="form-control  {{ ($row['qualification'] ?? '') == 'Any Other' ? '' : 'csp-clinic-displaynone' }}">
                                    <div id="erroranyotherpost" class="color-red-fourty-three"></div>
                                    @error('anyotherpost.0')
                                    <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                    @enderror
                                 </td>
                                 <td>
                                    <select id="qualiotherstaff" name="quali_otherstaff[]" class="form-control">
                                       <option value="">Select</option>
                                       <option value="Doctorate" {{ ($row['qualification'] ?? '') == 'Doctorate' ? 'selected' : '' }}>Doctorate</option>
                                       <option value="Post Graduate" {{ ($row['qualification'] ?? '') == 'Post Graduate' ? 'selected' : '' }}>Post Graduate</option>
                                       <option value="Graduate" {{ ($row['qualification'] ?? '') == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                                       <option value="Diploma" {{ ($row['qualification'] ?? '') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                       <option value="Under Graduate" {{ ($row['qualification'] ?? '') == 'Under Graduate' ? 'selected' : '' }}>Under Graduate</option>
                                       <option value="Any Other" {{ ($row['qualification'] ?? '') == 'Any Other' ? 'selected' : '' }}>Any Other</option>
                                    </select>
                                    <div id="errorqualiotherstaff" class="color-red-fourty-three"></div>
                                    @error('quali_otherstaff.0')
                                    <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                    @enderror
                                    <input type="text" id="anyotherdegree" name="anyotherdegree[]" value="{{ $row['qualification'] ?? '' }}" placeholder="" class="form-control  {{ ($row['qualification'] ?? '') == 'Any Other' ? '' : 'csp-clinic-displaynone' }}">
                                    <div id="erroranyotherdegree" class="color-red-fourty-three"></div>
                                    @error('anyotherdegree.0')
                                    <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                    @enderror
                                 </td>
                                 <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
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
                                             <div class="color-csp-clinic-two"><strong>{{ $message }}</strong></div>
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
                              <textarea class="form-control" id="otherdetails" name="otherdetails"
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

	
@else
<div class="card-header">
   <p class='text-danger'>Renewal is permitted only from 60 days before the expiry.</p>
</div>
@endif
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
            //alert("test0");
               if (!validatesdraft_data()) {
                   event.preventDefault();
               }
               //alert("test0");
               return true;
           });
       }
   });
</script>
<style nonce="{{$cspNonce}}">
   .step-indicator {
   display: flex;
   justify-content: center;
   gap: 10px;
   margin-bottom: 20px;
   }
   .indicator {
   width: 20px;
   height: 20px;
   border-radius: 50%;
   background-color: #e9ecef;
   }
   .indicator.active {
   background-color: #0d6efd;
   }
   .progress-bar {
   background-color: #0d6efd;;
   }
</style>
<script nonce="{{ $cspNonce }}">
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
               data: {
                   pincode: pincode,
                   _token: "{{ csrf_token() }}"
               },
               success: function (data) {
                   if (data.success) {
                       $('#state').val(data.state);
                       $('#pincodeavailability').html('');
   
                       if (data.districts.length > 1) {
   
                           // If multiple districts, show dropdown
                           let districtDropdown = '<select name="district" id="district" class="form-control">';
                           //    console.log(districtDropdown);
                           districtDropdown += '<option value="">Select District</option>';
                           data.districts.forEach(district => {
                               districtDropdown += `<option value="${district}">${district}</option>`;
                           });
                           districtDropdown += '</select>';
                           $('#district-container').html(districtDropdown);
                       } else if (data.districts.length === 1) {
                           // If only one district, show input field
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
               error: function (xhr, status, error) {
                   console.error('Error:', error);
                   console.log('Response Text:', xhr.responseText);
               }
           });
       }
   });
</script>
<script nonce="{{ $cspNonce }}">
   $('#crud_table_otherstaff').on('change', 'select', function() {
       if ($(this).val() == 'Any Other') {
         //   alert("called");
           $(this).parent().find('input').show();
           //$(this).parent().find('input').attr('required', '');
   
       } else {
           $(this).parent().find('input').hide();
           $(this).parent().find('input').removeAttr('required');
       }
   });
</script>
<script nonce="{{ $cspNonce }}">
   $(document).ready(function () {
       // Add new row
       $('#addotherstaff').click(function () {
           let newRow = $('#crud_table_otherstaff .staff-row:first').clone();
           newRow.find('input, select').val(''); // Clear input values
           $('#crud_table_otherstaff').append(newRow);
       });
   
       // Remove a row
       $(document).on('click', '.remove-row', function () {
           if ($('#crud_table_otherstaff .staff-row').length > 1) {
               $(this).closest('tr').remove();
           } else {
               alert("At least one row must be present.");
           }
       });
       $('.equipmentname').on('input', function() {
			var value = $(this).val();

			if (value.length > 100) {
				$(this).val(value.substring(0, 100));
					alert('Maximum 100 characters allowed for each equipment entry. If you need to add more equipment, please click on the "+" button.');
				
			}
		});
   });
</script>
<script nonce="{{ $cspNonce }}">
   $(document).ready(function() {
       var i = 1;
       $('#addequipment').click(function() {
           i++;
           $('#crud_table_equipments').append('<tr id="row1' + i +
               '"><td><input type="text" id="equipmentname" name="equipmentname[]"placeholder="" class="form-control equipmentname"></td><td><button type="button" name="btn_remove_addEQ" id="' +
               i +
               '" class="btn btn-danger btn_remove_addEQ"><i class="fa fa fa-trash"></i></button></td></tr>'
           );
       });
       $(document).on('click', '.btn_remove_addEQ', function() {
           var button_id = $(this).attr("id");
           $('#row1' + button_id + '').remove();
       });
   });
</script>
<script nonce="{{ $cspNonce }}">
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
   
   // document.getElementById('form-wizard').addEventListener('submit', (e) => {
   //   e.preventDefault();
   //   alert('Form submitted successfully!');
   // });
</script>
<script nonce="{{ $cspNonce }}" type="text/javascript">
   function validateAadhar(input) {
       // Allow only numeric input
       input.value = input.value.replace(/\D/g, '');
   
       // Ensure the input is not more than 4 digits
       if (input.value.length > 4) {
           input.value = input.value.slice(0, 4);
       }
   }
</script>
{{-- <script nonce="{{ $cspNonce }}">
   $('#transfer').on('change', function() {
       if (this.value == 'outside_india') {
           $("#copy_passport_spouse1").show();
       } else {
           $("#copy_passport_spouse1").hide();
       }
   });
   
   var refreshButton = document.querySelector(".refresh-captcha");
   refreshButton.onclick = function() {
       document.querySelector(".captcha-image").src = 'captcha.php?' + Date.now();
   }
</script> --}}
{{-- <script nonce="{{ $cspNonce }}">
   //var _validFilepdf = [".pdf", ".jpeg", ".jpg", ".bmp", ".gif", ".png"];
   var _validFilepdf = [".pdf"];
   function validateForSizepdf(oInput, minSize, maxSizepdf) {
       //if there is a need of specifying any other type, just add that particular type in var  _validFilejpeg
       if (oInput.type == "file") {
           var sFileName = oInput.value;
           if (sFileName.length > 0) {
               var blnValid = false;
               for (var j = 0; j < _validFilepdf.length; j++) {
                   var sCurExtension = _validFilepdf[j];
                   if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length)
                       .toLowerCase() == sCurExtension.toLowerCase()) {
                       blnValid = true;
                       break;
                   }
               }
   
               if (!blnValid) {
                   alert("Sorry, this file is invalid, allowed extension is: " + _validFilepdf.join(", "));
                   oInput.value = "";
                   return false;
               }
           }
       }
   
       fileSizeValidatepdf(oInput, minSize, maxSizepdf);
   }
   
   function fileSizeValidatepdf(fdata, minSize, maxSizepdf) {
       if (fdata.files && fdata.files[0]) {
           var fsize = fdata.files[0].size /
               1024; //The files property of an input element returns a FileList. fdata is an input element,fdata.files[0] returns a File object at the index 0.
           //alert(fsize)
           if (fsize > maxSizepdf || fsize < minSize) {
               alert('This file size is: ' + fsize.toFixed(2) +
                   "KB. Files should be in " + (minSize) + " to " + (maxSizepdf) + " KB ");
               fdata.value = ""; //so that the file name is not displayed on the side of the choose file button
               return false;
           } else {
               console.log("");
           }
       }
   }
</script>
<script nonce="{{ $cspNonce }}">
   var _validFilejpeg = [".pdf", ".jpeg", ".jpg", ".bmp", ".gif", ".png"];
   
   function validateForSize(oInput, minSize, maxSizejpeg) {
       //if there is a need of specifying any other type, just add that particular type in var  _validFilejpeg
       if (oInput.type == "file") {
           var sFileName = oInput.value;
           if (sFileName.length > 0) {
               var blnValid = false;
               for (var j = 0; j < _validFilejpeg.length; j++) {
                   var sCurExtension = _validFilejpeg[j];
                   if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length)
                       .toLowerCase() == sCurExtension.toLowerCase()) {
                       blnValid = true;
                       break;
                   }
               }
   
               if (!blnValid) {
                   alert("Sorry, this file is invalid, allowed extension is: " + _validFilejpeg.join(", "));
                   oInput.value = "";
                   return false;
               }
           }
       }
   
       fileSizeValidatejpeg(oInput, minSize, maxSizejpeg);
   }
   
   function fileSizeValidatejpeg(fdata, minSize, maxSizejpeg) {
       if (fdata.files && fdata.files[0]) {
           var fsize = fdata.files[0].size /
               1024; //The files property of an input element returns a FileList. fdata is an input element,fdata.files[0] returns a File object at the index 0.
           //alert(fsize)
           if (fsize > maxSizejpeg || fsize < minSize) {
               alert('This file size is: ' + fsize.toFixed(2) +
                   "KB. Files should be in " + (minSize) + " to " + (maxSizejpeg) + " KB ");
               fdata.value = ""; //so that the file name is not displayed on the side of the choose file button
               return false;
           } else {
               console.log("");
           }
       }
   }
</script> --}}
<script nonce="{{ $cspNonce }}">

function validatesdraft_data(e) {
   //  alert(
   //   Array.from(allInputs, input => `ID: ${input.id || "(no id)"} | Value: ${input.value}`).join("\n")
   // );
   
   const allInputs = document.querySelectorAll("input[type='text'], textarea");
   // const forbiddenPattern = /[<>$%#{};'"`]/; // block < > $ % # {} [] ; ' " `
   console.log(requiredInputs);
   for (let el of allInputs) {
      let forbiddenPattern;
            if (el.name === "address" || el.id === "address") {
                // Address ke liye sirf dangerous characters block
                forbiddenPattern = /[<>$%{};'"`]/;
            }else{
                forbiddenPattern = /[<>$%#{};'"`]/;
            }
       if (el.value && forbiddenPattern.test(el.value)) {
           alert(`Invalid characters detected in "${el.name || el.id}". Special characters are not allowed.`);
           el.focus();
           return false;
       }
   }
   return true;
}

function validatesubmit(e) {
   const allInputs = document.querySelectorAll("input[type='text'], textarea");
   // const forbiddenPattern = /[<>$%#{};'"`]/; // block < > $ % # {} [] ; ' " `
    for (let el of allInputs) {
      let forbiddenPattern;
            if (el.name === "address" || el.id === "address") {
                // Address ke liye sirf dangerous characters block
                forbiddenPattern = /[<>$%{};'"`]/;
            }else{
                forbiddenPattern = /[<>$%#{};'"`]/;
            }
        if (el.value && forbiddenPattern.test(el.value)) {
            alert(`Invalid characters detected in "${el.name || el.id}". Special characters are not allowed.`);
            el.focus();
            return false;
         }
      }

    e = e || window.event;

    // ---------- helpers ----------
    const byId = (id) => document.getElementById(id);

    const setErrorForId = (id, msg) => { const el = byId(id); if (el) el.innerHTML = msg; };
    const clearErrorForId = (id) => { const el = byId(id); if (el) el.innerHTML = ""; };

    const setRowError = (row, fallbackId, inputEl, msg) => {
        let holder = fallbackId ? row.querySelector('#' + fallbackId) : null;
        if (!holder) {
            holder = row.querySelector('.inline-error');
            if (!holder) {
                holder = document.createElement('div');
                holder.className = 'inline-error';
                holder.style.color = '#d33';
                holder.style.fontSize = '12px';
                holder.style.marginTop = '4px';
                (inputEl && inputEl.parentElement ? inputEl.parentElement : row).appendChild(holder);
            }
        }
        holder.textContent = msg;
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
        if (el && el.focus) el.focus();
        if (el && el.scrollIntoView) el.scrollIntoView({behavior: 'smooth', block: 'center'});
        return false;
    };

    // ---------- 1) basic fields ----------
    const bank_form_elements = ['clinicname','address','pincode','nature','email_bank','contactno','personname','mobilecontact','emailcontact'];

    for (let id of bank_form_elements) {
        const el = byId(id);
        if (!el) continue;

        const errId = "error" + el.id;

        if (el.tagName === 'SELECT') {
            if (!el.value) {
                setErrorForId(errId, "please select the above");
                alert(`${el.name || el.id} is not selected`);
                return focusAndStop(el);
            } else clearErrorForId(errId);
        } else if (['TEXTAREA'].includes(el.tagName) || ['text','date','email','number'].includes(el.type)) {
            if (el.value.trim() === '') {
                setErrorForId(errId, "please fill the above");
                alert(`${el.name || el.id} is empty`);
                return focusAndStop(el);
            } else clearErrorForId(errId);
        }

        // phone check (8–14 digits)
        if (id === 'contactno' || id === 'mobilecontact') {
            const phone = el.value.trim();
            const phoneRegex = /^[0-9]{8,14}$/;
            if (phone && !phoneRegex.test(phone)) {
                setErrorForId(errId, "Please enter a valid 8–14 digit phone number");
                alert("Please enter a valid 8–14 digit phone number");
                return focusAndStop(el);
            } else clearErrorForId(errId);
        }
    }

    // ---------- 2) Date ----------
    {
        const el = byId("datepicker");
        if (el && !el.value) {
            setErrorForId("errordatepicker", "Date of establishment of your ART Bank cannot be blank");
            alert("Date of establishment of your ART Bank cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errordatepicker");
    }

    // ---------- 3) Other Staff ----------
    {
        const rows = document.querySelectorAll("#crud_table_otherstaff .staff-row");
        for (const row of rows) {
            const nameInput   = row.querySelector('input[name="name_otherstaff[]"]');
            const postSelect  = row.querySelector('select[name="post[]"]');
            const qualiSelect = row.querySelector('select[name="quali_otherstaff[]"]');
            const anyPost     = row.querySelector('input[name="anyotherpost[]"]');
            const anyDegree   = row.querySelector('input[name="anyotherdegree[]"]');

            clearRowError(row, "errorpostotherstaff");
            clearRowError(row, "errornameotherstaff");
            clearRowError(row, "errorqualiotherstaff");
            clearRowError(row, "erroranyotherpost");
            clearRowError(row, "erroranyotherdegree");

            if (postSelect && !postSelect.value.trim()) {
                setRowError(row, "errorpostotherstaff", postSelect, "Post of staff cannot be blank");
                alert("Post of staff cannot be blank");
                return focusAndStop(postSelect);
            }

            if (nameInput && !nameInput.value.trim()) {
                setRowError(row, "errornameotherstaff", nameInput, "Name of staff cannot be blank");
                alert("Name of staff cannot be blank");
                return focusAndStop(nameInput);
            }

            if (qualiSelect && !qualiSelect.value.trim()) {
                setRowError(row, "errorqualiotherstaff", qualiSelect, "Qualification of staff cannot be blank");
                alert("Qualification of staff cannot be blank");
                return focusAndStop(qualiSelect);
            }

            if (postSelect && postSelect.value === "Any Other") {
                if (!anyPost || !anyPost.value.trim()) {
                    setRowError(row, "erroranyotherpost", anyPost || postSelect, "Name of the other Post cannot be blank");
                    alert("Name of the other Post cannot be blank");
                    return focusAndStop(anyPost || postSelect);
                }
            }

            if (qualiSelect && qualiSelect.value === "Any Other") {
                if (!anyDegree || !anyDegree.value.trim()) {
                    setRowError(row, "erroranyotherdegree", anyDegree || qualiSelect, "Other Qualification cannot be blank");
                    alert("Other Qualification cannot be blank");
                    return focusAndStop(anyDegree || qualiSelect);
                }
            }
        }
    }

    // ---------- 4) Equipment ----------
    {
        const eqInputs = document.querySelectorAll('input[name="equipmentname[]"]');
        if (eqInputs.length === 0) {
            setErrorForId("errorequipmentname", "Please add at least one equipment");
            alert("Please add at least one equipment");
            return false;
        }
        for (const input of eqInputs) {
            const row = input.closest("tr") || input.parentElement;
            if (row) clearRowError(row, "errorequipmentname");
            if (!input.value.trim()) {
                if (row) setRowError(row, "errorequipmentname", input, "Name of equipment cannot be blank");
                else setErrorForId("errorequipmentname", "Name of equipment cannot be blank");
                alert("Name of equipment cannot be blank");
                return focusAndStop(input);
            }
        }
    }

    // ---------- 5) Procedures (ART Bank specific) ----------
    const bankProcedures = [
        {id:"ejaculation", msg:"ejaculation cannot be blank"},
        {id:"electrojaculation", msg:"electrojaculation (in case of retrograde ejaculation) cannot be blank"},
        {id:"processing_sperm", msg:"Processing of Sperm cannot be blank"},
        {id:"storage_sperm", msg:"Storage of Sperm cannot be blank"},
        {id:"oocyte_doner", msg:"Provision/sourcing of Oocyte Donor cannot be blank"},
        {id:"cryopreservation_of_sperm", msg:"cryopreservation of Sperm cannot be blank"},
        {id:"methode_of_freezing_of_sperm", msg:"Sperm Slow Freezing cannot be blank"},
        {id:"sperm_vitrification", msg:"Sperm Vitrification cannot be blank"},
        {id:"freezing_of_testicular_tissue", msg:"Whether Freezing of Testicular Tissue cannot be blank"}
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
    {
        const decl = byId("declaration");
        if (decl && !decl.checked) {
            alert("Declaration cannot be blank");
            return focusAndStop(decl);
        }
    }

    // Final confirm
    const agree = confirm("Kindly check and confirm all details before final submission. There is no provision for editing/correction once application form submitted.");
    return !!agree;
}
</script>

@endsection