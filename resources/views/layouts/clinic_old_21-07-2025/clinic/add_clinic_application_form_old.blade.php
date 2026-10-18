@extends('layouts.clinic.clinic_master')
@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
        {{-- <title>Application form for transfer of Gametes (sperms Oocyte)/Embryos (Within
            and Outside India)</title> --}}

        {{-- <div class="container mt-5"> --}}
            <h3>Application Form for ART Clinic</h3>

            <!-- Step Indicators -->
            {{-- <div class="step-indicator">
                <div id="indicator-1" class="indicator active"></div>
                <div id="indicator-2" class="indicator"></div>
              <div id="step-1-indicator" class="active">Step 1</div>
              <div id="step-2-indicator" class="inactive">Step 2</div>
            </div> --}}
            <!-- Progress Bar -->
  <div class="progress mb-4" style="height: 20px;">
    <div
      id="progress-bar"
      class="progress-bar progress-bar-striped progress-bar-animated"
      role="progressbar"
      style="width: 50%;"
      aria-valuenow="50"
      aria-valuemin="0"
      aria-valuemax="100">
      Step 1 of 2
    </div>
  </div>

            <!-- Form -->
            <form id="form-wizard" method="POST" action="{{ route('noc.nocsubmit') }}" enctype="multipart/form-data">
              <!-- Step 1 -->
              @csrf
              <div id="step-1" class="step">
                <div class="row">
                    <h3 class="" style="border-color: #0b5ed7; color: #0b5ed7;">General Information and Staff Details</h3>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="control-label"><strong>Name of the Clinic</strong><span
                                style="color:#ff0000">*</span></label>
                        <div class="input-group">
                            <input id="clinicname" name="clinicname" class="form-control" value="{{ $signup->clinicname ?? '' }}"
                                type="text" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>Address</strong></label>
                        <div class="input-group">
                            <input type="text" name="address" id="address"
                               value="{{ $signup->address ?? '' }}"
                                class="form-control border-left-end" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>State</strong></label>
                        <div class="input-group">
                            <input type="text" name="state" placeholder="" id="state"
                                value="{{ $signup->state ?? '' }}"
                                class="form-control border-left-end" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>District</strong></label>
                        <div class="input-group">
                            <input type="text" name="district" placeholder="" id="district"
                                value="{{ $signup->district ?? '' }}"
                                class="form-control border-left-end" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>Pincode</strong></label>
                        <div class="input-group">
                            <input type="text" name="pincode" placeholder="" id="pincode"
                                value="{{ $signup->pincode ?? '' }}"
                                class="form-control border-left-end" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>Nature
                                of the
                                Organization</strong></label>
                        <div class="input-group">
                            <input type="text" name="nature" placeholder="" id="natureorg"
                            value="{{ $signup->nature ?? '' }}" class="form-control"
                                disabled>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>Name
                                of the Contact Person</strong></label>
                        <div class="input-group">
                            <input type="text" name="personname" placeholder="" id="personname"
                            value="{{ $signup->personname ?? '' }}" class="form-control"
                                disabled>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>Mobile
                                Number</strong></label>
                        <div class="input-group">
                            <input type="text" name="mobile" placeholder=""
                            value="{{ $signup->mobile ?? '' }}" class="form-control"
                                disabled>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>E-mail
                                Address</strong></label>
                        <div class="input-group">
                            <input type="text" name="email" placeholder=""
                            value="{{ $signup->email ?? '' }}" class="form-control"
                                disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>Contact
                                Number</strong></label>
                        <div class="input-group">
                            <input type="text" name="contactno" placeholder=""
                                value="{{ $signup->contactno ?? '' }}" class="form-control"
                                disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>Applying
                                for Registration as</strong><span
                                style="color:red;">*</span></label>
                        <div class="input-group">
                            <select name="cliniclevel" id="cliniclevel"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                <option value="Level-1">Level-1</option>
                                <option value="Level-2">Level-2</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>Fax
                                Number</strong></label>
                        <div class="input-group">
                            <input type="text" name="fax" placeholder=""
                                class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>Website</strong></label>
                        <div class="input-group">
                            <input type="text" name="website" placeholder=""
                                 class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>1.
                                Date of establishment of your ART Clinic</strong><span
                                style="color:red;">*</span></label>
                        <div class="input-group">
                            <input name="dateestab"
                                class="datepicker-default form-control" id="datepicker">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>2.
                                Whether your ART Clinic is registered under MTP
                                Act</strong><span style="color:red;">*</span></label>
                        <div class="input-group">
                            <select name="mtpact" id="mtpact"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>3.
                                Whether your ART Clinic is registered under PCPNDT
                                Act</strong><span style="color:red;">*</span></label>
                        <div class="input-group">
                            <select name="pcpndtact" id="pcpndtact"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>4.Whether your ART Clinic has
                                Director</strong><span style="color:red;">*</span></label>
                        <div class="input-group">
                            <select id="director" name="director"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                </div>








                <div id="directory" class="col-xs-12 form-group" style=''>
                    <div class="table-responsive">

                        <table class="table table-bordered" id="crud_table_director">
                            <tr>
                                <th width="">Name<span style="color:#ff0000">*</span></th>
                                <th width="">Qualification<span style="color:#ff0000">*</span>
                                </th>
                                <th width="">Registration No. (if applicable)</th>
                                <th></th>
                            </tr>
                            <tr class="staff-row">
                                <td>
                                    <input type="text" id="namedirector" name="name_director[]"
                                        placeholder="" class="form-control">
                                </td>
                                <td>
                                    <select id="quali_director" name="quali_director[]"
                                        class="form-control">
                                        <option value="">Select</option>
                                        <option value="PhD">Ph.D</option>
                                        <option value="DM">DM</option>
                                        <option Value="MCh">M.Ch</option>
                                        <option Value="PG">PG</option>
                                        <option Value="MD">MD</option>
                                        <option Value="MS">MS</option>
                                        <option Value="DNB">DNB</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" id="regdirector" name="reg_director[]"
                                        placeholder="" class="form-control">
                                </td>
                                <td>
                                    {{-- <button type="button" class="btn btn-danger btn-sm remove-row">-</button> --}}
                                </td>

                            </tr>
                        </table>
                        <div align="right">
                            <button type="button" name="adddirector" id="adddirector"
                                class="btn-xs" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;"><i class="fa fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div id="otherstaff" class="col-xs-12 form-group" style=''>
                    <label class="control-label" for=""><strong>5. Provide details of the staff.</strong></label>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="crud_table_otherstaff">
                            <tr>
                                <th width="">Name of the Post</th>
                                <th width="">Name of the Staff</th>
                                <th width="">Qualification</th>
                                <th width="">Registration No (if applicable)</th>
                            </tr>
                            <tr class="staff-row">
                                <td>
                                    <select id="postotherstaff" name="post_otherstaff[]"
                                        class="form-control">
                                        <option value="">Select</option>
                                        <option value="Gynecologist">Gynecologist</option>
                                        <option value="Andrologist">Andrologist</option>
                                        <option value="Clinical Embryologist">Clinical
                                            Embryologist</option>
                                        <option value="Counselor">Counselor</option>
                                        <option value="Anesthetist">Anesthetist</option>
                                        <option value="Any Other">Any Other</option>

                                    </select>
                                    <input type="text" id="anyotherpost" name="anyotherpost[]"
                                        style="display:none" value="" placeholder=""
                                        class="form-control">
                                </td>

                                <td>
                                    <input type="text" id="nameotherstaff"
                                        name="name_otherstaff[]" value="" placeholder=""
                                        class="form-control">
                                </td>
                                <td>
                                    <select id="qualiotherstaff" name="quali_otherstaff[]"
                                        class="form-control">
                                        <option value="">Select</option>
                                        <option value="Doctorate">Doctorate</option>
                                        <option value="Post Graduate">Post Graduate</option>
                                        <option value="Graduate">Graduate</option>
                                        <option value="Diploma">Diploma</option>
                                        <option value="Under Graduate">Under Graduate</option>
                                        <option value="Any Other">Any Other</option>
                                    </select>
                                    <input type="text" id="anyotherdegree"
                                        name="anyotherdegree[]" style="display:none" value=""
                                        placeholder="" class="form-control">
                                </td>
                                <td>
                                    <input type="text" id="regno" name="regno[]" placeholder=""
                                        class="form-control">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                                </td>
                            </tr>
                        </table>
                        <div align="right">
                            <button type="button" name="addotherstaff" id="addotherstaff"
                                class="btn-xs" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;">+</button>
                        </div>
                    </div>
                </div>
            </div>











                    <button type="button" class="btn btn-primary" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;" id="next-step">Next</button>






                </div>

                            <!-- Step 2 -->
                            <div id="step-2" class="step d-none">
                                        <div class="row">
                                            <h3 class="" style="border-color: #0b5ed7; color: #0b5ed7;">Procedures</h3>
                                            <div id="equipment" class="col-xs-12 form-group">
                                                <label class="control-label" for="">6. Provide list of Equipment's</label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="crud_table_equipments">
                                                        <tr>
                                                            <th width="">Name of Equipments<span style="color:#ff0000">*</span>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="text" id="equipmentname" name="equipmentname[]"
                                                                    placeholder="" class="form-control">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div align="right">
                                                        <button type="button" name="addequipment" id="addequipment"
                                                            class="btn-xs" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="control-label" for=""><strong>7. Indicate which of the
                                                            following ART
                                                            procedures are being routinely carried out at
                                                            your ART Clinic
                                                        </strong></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>i).
                                                        Intra-uterine Insemination using Husband Semen (IUI-H)<span
                                                            style="color:#ff0000">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="iuih" id="iuih"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>ii).
                                                        Intra-uterine Insemination using
                                                        Donor Semen (IUI-D)<span
                                                            style="color:#ff0000">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="iuid" id="iuid"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>iii). In vitro
                                                        Fertilization-Embryo
                                                        Transfer (IVF-ET)<span
                                                            style="color:#ff0000">*</span></strong></label>
                                                <div class="input-group">

                                                    <select name="ivfet" id="ivfet"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>iv).
                                                        Intra-cytoplasmic Sperm Injection (ICSI)<span
                                                            style="color:#ff0000">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="icsi" id="icsi"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>v).
                                                        Pre-implantation Genetic Testing (PGT)<span
                                                            style="color:#ff0000">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="pgt" id="pgt"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>vi).
                                                        Processing or Storage of Gametes (sperm & oocyte)of the Patient
                                                        and
                                                        or embryos of patient<span
                                                            style="color:#ff0000">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="spermandoocyte" id="spermandoocyte"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>vii). Any Other
                                                        Procedure<span style="color:#ff0000">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="anyotherprocedure" id='anyotherprocedure'
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3" id='anyotherprocedurey' style='display:none;'>
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>If yes, please specify<span
                                                            style="color:#ff0000">*</span></strong></label>
                                                <div class="input-group">
                                                    <input type="text" id="otherprocedure" name="otherprocedure"
                                                        placeholder="" class="form-control" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="field2" class="form-label"><strong>8. Any other
                                                        details</strong></label>
                                                <textarea class="form-control" id="otherdetails" name="otherdetails"
                                                    rows="4" cols="163"></textarea>
                                            </div>
                                        </div>

                                    </div>




                                        {{-- <legend>
                                            <h4 style="color: green;"><strong>Upload Documents<span
                                                        style="color:#ff0000">*</span></h4>
                                            </strong>
                                        </legend> --}}



























                                        <div class="row">
                                            <div class="col-md-9 mb-4">
                                                <input type="checkbox" id="declaration" name="declaration">
                                                <b> I hereby declare that the entries in this form and the additional
                                                    particulars , if any,furnished herewith are true to the best of my
                                                    knowledge and belief.<span
                                                        style="color:#ff0000">*</span> </b>
                                            </div>
                                        </div>

                                    </div>
                    <button type="button" class="btn btn-secondary" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;" id="prev-step">Back</button>
                    <button type="submit" class="btn btn-success" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;" onclick="return validatesubmit()">Submit</button>
              </div>
            </form>



{{-- <div> --}}







</div>







    </div>
</div>
    </div>
</div>
</div>







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
        $('#adddirector').click(function() {
            i++;
            $('#crud_table_director').append('<tr id="row1' + i +
                '"><td><input type="text" id="namedirector" name="name_director[]"  placeholder="" class="form-control" required></td><td><select id= "quali_director" name="quali_director[]" class="form-control" required><option value="">Select</option><option value="PhD">Ph.D</option><option value="DM">DM</option><option Value="MCh">M.Ch</option><option Value="PG">PG</option><option Value="MD">MD</option><option Value="MS">MS</option><option Value="DNB">DNB</option></select></td><td><input type="text" id="regdirector" name="reg_director[]"  placeholder="" class="form-control" ></td><td><button type="button" name="remove1" id="' +
                i +
                '" class="btn btn-danger btn_remove1"><i class="fa fa fa-trash"></i></button></td></tr>'
            );
        });
        $(document).on('click', '.btn_remove1', function() {
            var button_id = $(this).attr("id");
            //  alert(button_id);
            $('#row1' + button_id + '').remove();
        });
    });
    </script>
{{-- <script nonce="{{ $cspNonce }}">
    $(document).ready(function () {
        // Add new row
        $('#adddirector').click(function () {
            let newRow = $('#crud_table_director .staff-row:first').clone();
            newRow.find('input, select').val(''); // Clear input values
            $('#crud_table_director').append(newRow);
        });

        // Remove a row
        $(document).on('click', '.remove-row', function () {
            if ($('#crud_table_director .staff-row').length > 1) {
                $(this).closest('tr').remove();
            } else {
                alert("At least one row must be present.");
            }
        });
    });
</script> --}}


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







                            <script nonce="{{ $cspNonce }}">
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
                            </script>

                                <script nonce="{{ $cspNonce }}">
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
