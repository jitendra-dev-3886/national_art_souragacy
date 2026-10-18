@php

$cards = [

[
'title'=>'Registered Clinics',
'id'=>'registered_clinics',
'icon'=>'hospital',
'color'=>'primary'
],

[
'title'=>'Submitted Reports',
'id'=>'submitted_reports',
'icon'=>'clipboard-check',
'color'=>'success'
],

[
'title'=>'Pending Reports',
'id'=>'pending_reports',
'icon'=>'clock',
'color'=>'warning'
],

[
'title'=>'Patient Records',
'id'=>'patient_records',
'icon'=>'users',
'color'=>'info'
],

[
'title'=>'Donor Records',
'id'=>'donor_records',
'icon'=>'user-friends',
'color'=>'secondary'
],

[
'title'=>'ART Clinics',
'id'=>'art_clinics',
'icon'=>'clinic-medical',
'color'=>'primary'
],

[
'title'=>'ART Banks',
'id'=>'art_banks',
'icon'=>'database',
'color'=>'success'
],

[
'title'=>'Surrogacy Clinics',
'id'=>'surrogacy',
'icon'=>'heartbeat',
'color'=>'danger'
],

[
'title'=>'Married Couples',
'id'=>'married',
'icon'=>'ring',
'color'=>'info'
],

[
'title'=>'Single Women',
'id'=>'single_women',
'icon'=>'female',
'color'=>'warning'
],

[
'title'=>'Pregnant',
'id'=>'pregnant',
'icon'=>'baby',
'color'=>'success'
],

[
'title'=>'Live Birth',
'id'=>'live_birth',
'icon'=>'child',
'color'=>'primary'
],

[
'title'=>'Male Babies',
'id'=>'male_babies',
'icon'=>'male',
'color'=>'info'
],

[
'title'=>'Female Babies',
'id'=>'female_babies',
'icon'=>'female',
'color'=>'danger'
],

[
'title'=>'Pregnancy Rate',
'id'=>'pregnancy_rate',
'icon'=>'chart-pie',
'color'=>'success',
'value'=>'0%'
]

];

@endphp

<div class="row">

@foreach($cards as $card)

<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4">

<div class="card shadow-sm border-0 h-100">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center">

<div>

<h6 class="text-muted mb-2">

{{ $card['title'] }}

</h6>

<h2
id="{{ $card['id'] }}"
class="font-weight-bold text-{{ $card['color'] }} mb-0">

{{ $card['value'] ?? '0' }}

</h2>

</div>

<div>

<div
class="rounded-circle bg-{{ $card['color'] }}"
style="width:55px;height:55px;display:flex;align-items:center;justify-content:center;">

<i
class="fa fa-{{ $card['icon'] }}"
style="color:#fff;font-size:22px;"></i>

</div>

</div>

</div>

</div>

</div>

</div>

@endforeach

</div>