
            @php $sn = 1; @endphp
            @if (!empty($patient_list) && $patient_list->count() > 0)
                @foreach ($patient_list as $p)
                    <tr>
                        <td>{{ $sn++ }}</td>
                        <td>{{ $p->clinic_name ?? 'N/A' }}</td>
                        <td>{{ $p->registration_no ?? 'N/A' }}</td>
                        <td>{{ $p->state ?? 'N/A' }}</td>
                        <td>{{ $p->married_couple_count ?? 0 }}</td>
                        <td>{{ $p->single_women_count ?? 0 }}</td>
                        <td>{{ $p->male_factor ?? 0 }}</td>
                        <td>{{ $p->female_factor ?? 0 }}</td>
                        <td>{{ $p->unexplained ?? 0 }}</td>
                        <td>{{ $p->iui_h_count ?? 0 }}</td>
                        <td>{{ $p->iui_d_count ?? 0 }}</td>
                        <td>{{ $p->total_num_of_cyc_undertaking ?? 0 }}</td>
                        <td>{{ $p->cyc_canc_failure_reason ?? 0 }}</td>
                        <td>{{ $p->success_pregnant ?? 0 }}</td>
                        <td>{{ $p->failed_pregnant ?? 0 }}</td>
                        <td>{{ $p->live_birth ?? 0 }}</td>
                        <td>{{ $p->still_birth ?? 0 }}</td>
                        <td>{{ $p->therapeutic_aboration ?? 0 }}</td>
                        <td>{{ $p->spontaneous_aboration ?? 0 }}</td>
                        <td>{{ $p->elective_termination ?? 0 }}</td> {{-- this is not right  --}}
                        <td>{{ $p->singleton ?? 0 }}</td>
                        <td>{{ $p->twin ?? 0 }}</td>
                        <td>{{ $p->higher_order ?? 0 }}</td>
                        <td>{{ $p->male ?? 0 }}</td>
                        <td>{{ $p->female ?? 0 }}</td>
                    </tr>
                @endforeach
            @else
            @endif

