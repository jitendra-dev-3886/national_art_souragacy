@php $sn = 1; @endphp
@if ($patient_list)
    @foreach ($patient_list as $p)
        <tr>
            <td>{{ $sn++ }}</td>
            <td>{{ $p->clinic_name ?? 'N/A' }}</td>
            <td>{{ $p->registration_no ?? 'N/A' }}</td>
            <td>{{ $p->state ?? 'N/A' }}</td>

            <td>{{ $p->semen_married ?? 0 }}</td>
            <td>{{ $p->semen_single ?? 0 }}</td>
            <td>{{ $p->oocyte_married ?? 0 }}</td>
            <td>{{ $p->oocyte_single ?? 0 }}</td>

            <td>{{ $p->indian_semen ?? 0 }}</td>
            <td>{{ $p->indian_oocyte ?? 0 }}</td>
            <td>{{ $p->foreign_semen ?? 0 }}</td>
            <td>{{ $p->foreign_oocyte ?? 0 }}</td>

            <td>{{ $p->semen_samples ?? 0 }}</td>
            <td>{{ $p->oocyte_samples ?? 0 }}</td>


        </tr>
    @endforeach
@else
    <tr>
        <td colspan="14">Data not found.</td>
    </tr>
@endif
