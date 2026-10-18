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
            <form id="form-wizard" method="POST" action="{{ route('clinic.save_bank_application_form') }}" enctype="multipart/form-data" autocomplete="off">
               <!-- Step 1 -->
               @csrf
               <div id="step-1" class="step">
                  <div class="row">
                     <h3 class="border-color-csp-noc-fortytwo">General Information and Staff Details</h3>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="control-label" for="clinicname"><strong>Name of the Bank</strong><span
                              class="color-red-fourty-three">*</span></label>
                           <div class="input-group">
                              <input id="clinicname" name="clinicname" class="form-control" value="{{ $signup->clinicname ?? $draft->clinicname ?? '' }}"
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
                           <div class="input-group">
                              <input type="text" name="address" id="address"
                                 value="{{ $signup->address ?? $draft->address ?? '' }}"
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
                           <div class="input-group">
                              <input type="text" name="pincode" placeholder="" id="pincode"
                                 value="{{ $signup->pincode ?? $draft->pincode ?? '' }}"
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
                                 value="{{ $signup->state ?? $draft->state ?? '' }}"
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
                                 value="{{ $signup->district ?? $draft->district ?? '' }}"
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
                           <div class="input-group">
                              {{-- <select name="nature" id="nature2" class="form-control" >
                                 <option value="">Select</option>
                                 <option value="Government" {{ ($signup->nature ?? $draft->nature ?? '') == 'Government' ? 'selected' : '' }}>Government</option>
                                 <option value="Private" {{ ($signup->nature ?? $draft->nature ?? '') == 'Private' ? 'selected' : '' }}>Private</option>
                              </select> --}}
                              <input type="text" class="form-control" name="nature" id="nature" value="{{($signup->nature ?? $draft->nature ?? '')}}" readonly>
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
                           <div class="input-group">
                              <input type="text" name="email_bank" placeholder="" id = "email_bank"
                                 value="{{ $signup->email ?? $draft->email ?? '' }}" class="form-control"
                                 readonly>
                           </div>
                           <div id="erroremail_bank" class="color-red-fourty-three"></div>
                           @if ($errors->has('email_bank'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('email_bank') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="contactno"><strong>Contact
                           Number</strong></label>
                           <div class="input-group">
                              <input type="text" name="contactno" placeholder="" id="contactno"
                                 value="{{ $signup->contactno ?? $draft->contactno ?? '' }}" class="form-control"
                                 readonly>
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
                           of the Contact Person</strong></label>
                           <div class="input-group">
                              <input type="text" name="personname" placeholder="" id="personname"
                                 value="{{ $signup->personname ?? $draft->contact_person_name ?? '' }}" class="form-control"
                                 pattern="[A-Za-z0-9 .]+" title="Only alphabetic characters are allowed">
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
                           Number</strong></label>
                           <div class="input-group">
                              <input type="text" name="mobilecontact" placeholder="" id="mobilecontact"
                                 value="{{ $signup->mobile ?? $draft->contact_person_mobile ?? '' }}" class="form-control"
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
                           Address</strong></label>
                           <div class="input-group">
                              <input type="text" name="emailcontact" placeholder="" id ="emailcontact"
                                 value="{{ $signup->email_contact_person ?? $draft->contact_person_email ?? '' }}" class="form-control"
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
                              <input type="text" name="fax" placeholder="" id ="fax"
                                 class="form-control" value="{{ old('fax',$draft->fax ?? '') }}">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="website"><strong>Website</strong></label>
                           <div class="input-group">
                              <input type="text" name="website" placeholder="" id="website"
                                 class="form-control" value="{{ old('fax',$draft->website ?? '') }}">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="datepicker"><strong>1.
                           Date of establishment of your ART Bank</strong><span
                              class="color-red-fourty-three"></span></label>
                           <div class="input-group">
                              <input type="date" name="dateestab"
                                 class="datepicker-default form-control" id="datepicker" value="{{ old('dateestab',$draft->dateestab ?? '') }}">
                           </div>
                           <div id="errordatepicker" class="color-red-fourty-three"></div>
                           @if ($errors->has('dateestab'))
                           <div class="color-red-fourty-three">
                              <strong>{{ $errors->first('dateestab') }}</strong>
                           </div>
                           @endif
                        </div>
                     </div>
                     @php
                     $staffData = old('name_otherstaff')
                     ? collect(old('name_otherstaff'))->map(function ($name, $i) {
                     return [
                     'name_otherstaff'     => $name,
                     'designation_otherstaff' => old('designation_otherstaff.' . $i),
                     'quali_otherstaff'   => old('quali_otherstaff.' . $i),
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
                                    <input type="text" id="nameotherstaff" name="name_otherstaff[]" value="{{ $row['name_otherstaff'] ?? '' }}" placeholder="" class="form-control">
                                    <div id="errornameotherstaff" class="color-red-fourty-three"></div>
                                    @error('name_otherstaff.0')
                                    <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                    @enderror
                                 </td>
                                 <td>
                                    <select id="designationotherstaff" name="designation_otherstaff[]" class="form-control">
                                       <option value="">Select</option>
                                       <option value="Registered Medical Practioner" {{ ($row['designation_otherstaff'] ?? '') == 'Registered Medical Practioner' ? 'selected' : '' }}>Registered Medical Practioner</option>
                                       <option value="Any Other" {{ ($row['designation_otherstaff'] ?? '') == 'Any Other' ? 'selected' : '' }}>Any Other</option>
                                    </select>
                                    <div id="errordesignation_otherstaff" class="color-red-fourty-three"></div>
                                    @error('designation_otherstaff.0')
                                    <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                    @enderror
                                    <input type="text" id="anyotherpost" name="anyotherpost[]" value="{{ $row['designation_otherstaff'] ?? '' }}" placeholder=""
                                       class="form-control  {{ ($row['quali_otherstaff'] ?? '') == 'Any Other' ? '' : 'csp-clinic-displaynone' }}">
                                    <div id="erroranyotherpost" class="color-red-fourty-three"></div>
                                    @error('anyotherpost.0')
                                    <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                    @enderror
                                 </td>
                                 <td>
                                    <select id="qualiotherstaff" name="quali_otherstaff[]" class="form-control">
                                       <option value="">Select</option>
                                       <option value="Doctorate" {{ ($row['quali_otherstaff'] ?? '') == 'Doctorate' ? 'selected' : '' }}>Doctorate</option>
                                       <option value="Post Graduate" {{ ($row['quali_otherstaff'] ?? '') == 'Post Graduate' ? 'selected' : '' }}>Post Graduate</option>
                                       <option value="Graduate" {{ ($row['quali_otherstaff'] ?? '') == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                                       <option value="Diploma" {{ ($row['quali_otherstaff'] ?? '') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                       <option value="Under Graduate" {{ ($row['quali_otherstaff'] ?? '') == 'Under Graduate' ? 'selected' : '' }}>Under Graduate</option>
                                       <option value="Any Other" {{ ($row['quali_otherstaff'] ?? '') == 'Any Other' ? 'selected' : '' }}>Any Other</option>
                                    </select>
                                    <div id="errorqualiotherstaff" class="color-red-fourty-three"></div>
                                    @error('quali_otherstaff.0')
                                    <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                    @enderror
                                    <input type="text" id="anyotherdegree" name="anyotherdegree[]" value="{{ $row['quali_otherstaff'] ?? '' }}" placeholder="" class="form-control  {{ ($row['quali_otherstaff'] ?? '') == 'Any Other' ? '' : 'csp-clinic-displaynone' }}">
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
                                             placeholder="" class="form-control">
                                          <div id="errorequipmentname" class="color-csp-clinic-two"></div>
                                          @error('equipmentname.' . $i)
                                             <div class="color-csp-clinic-two"><strong>{{ $message }}</strong></div>
                                          @enderror
                                       </td>
                                       <td>
                                          @if($i > 0) {{-- पहली row पर delete button नहीं दिखेगा --}}
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
                              Ejaculation<span
                                 class="color-red-fourty-three">*</span></strong></label>
                              <div class="input-group">
                                 <select name="ejaculation" id="ejaculation"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('ejaculation', $draft->ejaculation ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('ejaculation', $draft->ejaculation ?? '') == 'No' ? 'selected' : '' }}>No</option>
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
                              b). Electroejaculation (in
                              case of retrograde ejaculation)<span
                                 class="color-red-fourty-three">*</span></strong></label>
                              <div class="input-group">
                                 <select name="electroejaculation" id="electroejaculation"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('electroejaculation', $draft->electroejaculation ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('electroejaculation', $draft->electroejaculation ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorelectroejaculation" class="color-red-fourty-three"></div>
                              @if ($errors->has('electroejaculation'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('electroejaculation') }}</strong>
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
                                 <select name="processingsperm" id="processingsperm"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('processingsperm', $draft->processingsperm ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('processingsperm', $draft->processingsperm ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorprocessingsperm" class="color-red-fourty-three"></div>
                              @if ($errors->has('processingsperm'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('processingsperm') }}</strong>
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
                                 <select name="storagesperm" id="storagesperm"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('storagesperm', $draft->storagesperm ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('storagesperm', $draft->storagesperm ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorstoragesperm" class="color-red-fourty-three"></div>
                              @if ($errors->has('storagesperm'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('storagesperm') }}</strong>
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
                                 <select name="oocytedonor" id="oocytedonor"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('oocytedonor', $draft->oocytedonor ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('oocytedonor', $draft->oocytedonor ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="erroroocytedonor" class="color-red-fourty-three"></div>
                              @if ($errors->has('oocytedonor'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('oocytedonor') }}</strong>
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
                                 <select name="cryopreservation" id="cryopreservation"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('cryopreservation', $draft->cryopreservation ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('cryopreservation', $draft->cryopreservation ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorcryopreservation" class="color-red-fourty-three"></div>
                              @if ($errors->has('cryopreservation'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('cryopreservation') }}</strong>
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
                                 <select name="spermslow" id="spermslow"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('spermslow', $draft->spermslow ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('spermslow', $draft->spermslow ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorspermslow" class="color-red-fourty-three"></div>
                              @if ($errors->has('spermslow'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('spermslow') }}</strong>
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
                                 <select name="spermvitrification" id="spermvitrification"
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('spermvitrification', $draft->spermvitrification ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('spermvitrification', $draft->spermvitrification ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errorspermvitrification" class="color-red-fourty-three"></div>
                              @if ($errors->has('spermvitrification'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('spermvitrification') }}</strong>
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
                                 <select name="tisticulartissue" id='tisticulartissue'
                                    class="nice-select default-select wide form-control solid">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('tisticulartissue', $draft->tisticulartissue ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('tisticulartissue', $draft->tisticulartissue ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                 </select>
                              </div>
                              <div id="errortisticulartissue" class="color-red-fourty-three"></div>
                              @if ($errors->has('tisticulartissue'))
                              <div class="color-red-fourty-three">
                                 <strong>{{ $errors->first('tisticulartissue') }}</strong>
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="mb-3">
                              <label for="field2" class="form-label"><strong>8. Any other
                              details</strong></label>
                              <textarea class="form-control" id="otherdetails" name="otherdetails"
                                 rows="4" cols="163">{{ old('otherdetails', $draft->otherdetails ?? '') }}</textarea>
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
                        </div>
                     </div>
                  </div>

                  <button type="button" class="btn btn-secondary btn-color-border-color-csp-noc-fourty-five" id="prev-step">Back</button>
                  <button type="submit" name="common" value="submit" id="submitButton" class="btn btn-success btn-color-border-color-csp-noc-fourty-five">Submit</button>
                  <button type="submit" name="common" value="draft" id="draftButton" class="btn btn-success bc-br-color-info">Save as Draft</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
</div>
<script nonce="{{$cspNonce}}">
   alert(
	"After submission, the PDF printout of the filled-in application form duly signed by the authorized signatory/ competent authority (with name & contact details) on behalf of the clinic/bank, shall be submitted electronically or by registered post or in-person to the Appropriate Authority under the Assisted Reproductive Technology (Regulation) Act, 2021 and The Surrogacy (Regulation) Act, 2021 through the office of Additional Chief Secretary (Health)/ Additional Secretary (Health)/ Principal Secretary (Health)/ Secretary (Health)/ Joint Secretary (Health) of the respective State/UT Government, " +
	"⚠ within 07 days of online submission of the form alongwith the prescribed fees ⚠"
	);
   document.addEventListener('DOMContentLoaded', function() {
       const submitButton = document.getElementById('submitButton');
       const draftButton = document.getElementById('draftButton');
       if (submitButton) {
           submitButton.addEventListener('click', function(event) {
               if (!validatesubmit()) {
                   event.preventDefault();
               }
           });
       }
       if (draftButton) {
           draftButton.addEventListener('click', function(event) {
            //alert("test0");
               if (!validatesdraft()) {
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
   });
</script>
<script nonce="{{ $cspNonce }}">
   $(document).ready(function() {
       var i = 1;
       $('#addequipment').click(function() {
           i++;
           $('#crud_table_equipments').append('<tr id="row1' + i +
               '"><td><input type="text" id="equipmentname" name="equipmentname[]"placeholder="" class="form-control"></td><td><button type="button" name="btn_remove_addEQ" id="' +
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

function validatesdraft(e) {
   //  alert(
   //   Array.from(allInputs, input => `ID: ${input.id || "(no id)"} | Value: ${input.value}`).join("\n")
   // );
   
   const allInputs = document.querySelectorAll("input[type='text'], textarea");
   const forbiddenPattern = /[<>;\`%{}\[\]\\]/; // block < > $ % # {} [] ; ' " `
   console.log(requiredInputs);
   for (let el of allInputs) {
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
   const forbiddenPattern = /[<>;\`%{}\[\]\\]/; // block < > $ % # {} [] ; ' " `
    for (let el of allInputs) {
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
            const postSelect  = row.querySelector('select[name="designation_otherstaff[]"]');
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
        {id:"ejaculation", msg:"Ejaculation cannot be blank"},
        {id:"electroejaculation", msg:"Electroejaculation (in case of retrograde ejaculation) cannot be blank"},
        {id:"processingsperm", msg:"Processing of Sperm cannot be blank"},
        {id:"storagesperm", msg:"Storage of Sperm cannot be blank"},
        {id:"oocytedonor", msg:"Provision/sourcing of Oocyte Donor cannot be blank"},
        {id:"cryopreservation", msg:"Cryopreservation of Sperm cannot be blank"},
        {id:"spermslow", msg:"Sperm Slow Freezing cannot be blank"},
        {id:"spermvitrification", msg:"Sperm Vitrification cannot be blank"},
        {id:"tisticulartissue", msg:"Whether Freezing of Testicular Tissue cannot be blank"}
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

{{-- <script nonce="{{ $cspNonce }}">
   $('#pincode').blur(function() {
       var pincode = $(this).val();
       if (pincode === "") {
           $('#state').val('');
           $('#district').val('');
           $('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
       } else {
           $.ajax({
               url: "{{ route('pincode.check') }}", // Laravel route
               method: "POST",
               data: {
                   pincode: pincode,
                   _token: "{{ csrf_token() }}" // CSRF token for security
               },
               success: function(data) {
                   if (data.success) {
                       $('#state').val(data.state);
                       $('#district').val(data.district);
                       $('#pincodeavailability').html('');
                   } else {
                       $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                       $('#state').val('');
                       $('#district').val('');
                   }
               }
           });
       }
   });
</script> --}}
{{-- <script nonce="{{ $cspNonce }}">
   $(document).ready(function() {
       $('#to_status_clinic, #to_status_from_clinic').on('change', function() {
           var clinicType = $('#to_status_clinic').val();
           var statusType = $('#to_status_from_clinic').val();
   
           if (clinicType && statusType) {
               $.ajax({
                   type: 'POST',
                   url: '{{ route('noc.fetchClinicData') }}',
                   data: {
                       clinic_type: clinicType,
                       status_type: statusType,
                       _token: '{{ csrf_token() }}'
                   },
                   success: function(data) {
                       $('.abc').empty().append(data);
                       $('.xyz').empty().append(data);
                   },
                   error: function(xhr, status, error) {
                       console.log("AJAX Error: ", error);
                   }
               });
           } else {
               $('.abc, .xyz').html('<option value="">Select</option>');
           }
       });
   
       $('#status_clinic, #status_from_clinic').on('change', function() {
           var clinicType = $('#status_clinic').val();
           var statusType = $('#status_from_clinic').val();
   
           if (clinicType && statusType) {
               $.ajax({
                   type: 'POST',
                   url: '{{ route('noc.fetchClinicDataFrom') }}',
                   data: {
                       clinic_type: clinicType,
                       status_type: statusType,
                       _token: '{{ csrf_token() }}'
                   },
                   success: function(data) {
                       $('.def').empty().append(data);
                       $('.ghi').empty().append(data);
                   },
                   error: function(xhr, status, error) {
                       console.log("AJAX Error: ", error);
                   }
               });
           } else {
               $('.def, .ghi').html('<option value="">Select</option>');
           }
       });
   });
</script>
<script nonce="{{ $cspNonce }}">
   $(document).ready(function () {
       $('#to_name_clinic').change(function () {
           //console.log('hello');
           //alert('check 1');
           var clinicType = $('#to_status_clinic').val();
           var statusType = $('#to_status_from_clinic').val();
           var to_name_clinic_fetch_reg = $('#to_name_clinic').val();
   
           console.log(to_name_clinic_fetch_reg);
           if (to_name_clinic_fetch_reg === '') {
               $('#to_clinic_hide_show').hide();
               $('#to_address, #t_pincode, #t_state, #t_district, #t_email, #t_contact, #to_regno, #to_applicationno').val('');
           } else {
               $('#to_clinic_hide_show').show();
   
               $.ajax({
                   url: '{{ route('noc.fetchClinicDetails') }}',
                   method: 'POST',
                   data: {
                       to_name_clinic_fetch_reg: to_name_clinic_fetch_reg,
                       clinicType: clinicType,
                       statusType: statusType,
                        _token: '{{ csrf_token() }}'
                   },
                   success: function (data) {
                       $('#to_address').val(data.address || '');
                       $('#t_pincode').val(data.pincode || '');
                       $('#t_state').val(data.state || '');
                       $('#t_district').val(data.district || '');
                       $('#t_email').val(data.email || '');
                       $('#t_contact').val(data.contactno || '');
                       $('#to_regno').val(data.registration_no || '');
                       $('#to_applicationno').val(data.application_no || '');
                       console.log(data);
                   },
                   error: function (xhr, status, error) {
                       console.error('AJAX Error:', error);
                   }
               });
           }
       });
   
       $('#to_name_clinic1').change(function () {
           var clinicType = $('#to_status_clinic').val();
           var statusType = $('#to_status_from_clinic').val();
           var to_name_clinic_fetch_app = $('#to_name_clinic1').val();
   
           if (to_name_clinic_fetch_app === '') {
               $('#to_clinic_hide_show').hide();
               $('#to_address, #t_pincode, #t_state, #t_district, #t_email, #t_contact, #to_regno, #to_applicationno').val('');
           } else {
               $('#to_clinic_hide_show').show();
   
               $.ajax({
                   url: '{{ route('noc.fetchClinicApplicationDetails') }}',
                   method: 'POST',
                   data: {
                       to_name_clinic_fetch_app: to_name_clinic_fetch_app,
                       clinicType: clinicType,
                       statusType: statusType,
                        _token: '{{ csrf_token() }}'
                   },
                   success: function (data) {
                       $('#to_address').val(data.address || '');
                       $('#t_pincode').val(data.pincode || '');
                       $('#t_state').val(data.state || '');
                       $('#t_district').val(data.district || '');
                       $('#t_email').val(data.email || '');
                       $('#t_contact').val(data.contactno || '');
                       $('#to_regno').val(data.registration_no || '');
                       $('#to_applicationno').val(data.applicationno || '');
                       console.log(data);
                   },
                   error: function (xhr, status, error) {
                       console.error('AJAX Error:', error);
                   }
               });
           }
       });
   });
</script>
<script nonce="{{ $cspNonce }}">
   $(document).ready(function() {
       $('#from_name_clinic').change(function() {
   
           var clinicType = $('#status_clinic').val();
           var statusType = $('#status_from_clinic').val();
           var from_name_clinic_fetch_reg = $('#from_name_clinic').val();
   
           console.log(statusType);
           console.log(from_name_clinic_fetch_reg);
           if (from_name_clinic_fetch_reg === '') {
               $('#from_address').val('');
               $('#f_pincode').val('');
               $('#f_state').val('');
               $('#f_district').val('');
               $('#f_email').val('');
               $('#f_contact').val('');
               $('#from_regno').val('');
               $('#from_applicationno').val('');
           } else {
               $.ajax({
                   url: '{{ route('noc.fetchClinicDataFromm') }}',
                   method: 'POST',
                   data: {
                       from_name_clinic_fetch_reg: from_name_clinic_fetch_reg,
                       clinicType: clinicType,
                       statusType: statusType,
                       _token: $('meta[name="csrf-token"]').attr('content')
                   },
                   success: function(data) {
                       $('#from_address').val(data.address || '');
                       $('#f_pincode').val(data.pincode || '');
                       $('#f_state').val(data.state || '');
                       $('#f_district').val(data.district || '');
                       $('#f_email').val(data.email || '');
                       $('#f_contact').val(data.contactno || '');
                       $('#from_regno').val(data.registration_no || '');
                       $('#from_applicationno').val(data.application_no || '');
                   },
                   error: function(xhr, status, error) {
                       console.error('AJAX Error:', error);
                   }
               });
           }
       });
   
       $('#from_name_clinic1').change(function() {
           var clinicType = $('#status_clinic').val();
           var statusType = $('#status_from_clinic').val();
           var from_name_clinic_fetch_app = $('#from_name_clinic1').val();
   
   
           if (from_name_clinic_fetch_app === '') {
               $('#from_address').val('');
               $('#f_pincode').val('');
               $('#f_state').val('');
               $('#f_district').val('');
               $('#f_email').val('');
               $('#f_contact').val('');
               $('#from_regno').val('');
               $('#from_applicationno').val('');
           } else {
               $.ajax({
                   url: '{{ route('noc.nocClinicFetchAppFrom') }}',
                   method: 'POST',
                   data: {
                       from_name_clinic_fetch_app: from_name_clinic_fetch_app,
                       clinicType: clinicType,
                       statusType: statusType,
                       _token: $('meta[name="csrf-token"]').attr('content')
                   },
                   success: function(data) {
                       $('#from_address').val(data.address || '');
                       $('#f_pincode').val(data.pincode || '');
                       $('#f_state').val(data.state || '');
                       $('#f_district').val(data.district || '');
                       $('#f_email').val(data.email || '');
                       $('#f_contact').val(data.contactno || '');
                       $('#from_regno').val(data.registration_no || '');
                       $('#from_applicationno').val(data.applicationno || '');
                   },
                   error: function(xhr, status, error) {
                       console.error('AJAX Error:', error);
                   }
               });
           }
       });
   });
</script> --}}
@endsection