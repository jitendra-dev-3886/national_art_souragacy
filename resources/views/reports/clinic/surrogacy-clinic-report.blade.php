
                @php $sn = 1; @endphp
                @if($patient_list)
                    @foreach($patient_list as $p)
                        <tr>
                            <td>{{ $sn++ }}</td>
                            <td>{{ $p->clinic_name ?? 'N/A' }}</td>
                            <td>{{ $p->registration_no ?? 'N/A' }}</td>
                            <td>{{ $p->state ?? 'N/A' }}</td>
                            <td>{{ $p->married_couple_count ?? 0 }}</td>
                            <td>{{ $p->single_women_count ?? 0 }}</td>
                            <td>{{ $p->indian ?? 0 }}</td>
                            <td>{{ $p->oci_card ?? 0 }}</td>
                            <td>{{ $p->male_factor ?? 0 }}</td>
                            <td>{{ $p->ultra_ab ?? 0 }}</td>
                            <td>{{ $p->ivf_failure ?? 0 }}</td>
                            <td>{{ $p->preg_loss ?? 0 }}</td>
                            <td>{{ $p->life_threate ?? 0 }}</td>
                            <td>{{ $p->sur_yes ?? 0 }}</td>
                            <td>{{ $p->sur_no ?? 0 }}</td>
                            <td>{{ $p->self_gametes ?? 0 }}</td>
                            <td>{{ $p->self_oocyte ?? 0 }}</td>
                            <td>{{ $p->donor_oocyte ?? 0 }}</td>
                            <td>{{ $p->ivfet ?? 0 }}</td>
                            <td>{{ $p->icsi ?? 0 }}</td>
                            <td>{{ $p->other ?? 0 }}</td>                                 
                            {{-- <td>{{ $p->cyc_canc_failure_reason ?? 0 }}</td> --}}
                            <td>{{ $p->cyc_canc_failure_reason ?? 0 }}</td>
                            <td>{{ $p->success_pregnant ?? 0 }}</td>
                            <td>{{ $p->failed_pregnant ?? 0 }}</td>
                            <td>{{ $p->live_birth ?? 0 }}</td>
                            <td>{{ $p->still_birth ?? 0 }}</td>
                            <td>{{ $p->therapeutic_aboration ?? 0 }}</td>    
                            <td>{{ $p->spontaneous_aboration ?? 0 }}</td> 
                            <td>{{ $p->elective_termination ?? 0 }}</td>  
                            <td>{{ $p->singleton ?? 0 }}</td> 
                            <td>{{ $p->twin ?? 0 }}</td> 
                            <td>{{ $p->higher_order ?? 0 }}</td> 
                            <td>{{ $p->male ?? 0 }}</td> 
                            <td>{{ $p->female ?? 0 }}</td>
                        </tr>
                    @endforeach
                @else
                @endif

