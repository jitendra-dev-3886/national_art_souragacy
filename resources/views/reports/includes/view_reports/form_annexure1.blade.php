 <h5 class="mb-4 text-primary">Annexure-I (For Point 9 of the Format)</h5>
 <table class="table table-bordered main-tables" id="datafiels1">
    <thead class="table-light">
        <tr>
            <th>S.No</th>
            <th>Name of the Clinic/Bank</th>
            <th>Operating since</th>
            <th colspan="2">Action taken</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1;  @endphp

    @if(isset($annexureResult['firstAnnexureResultQ9'])) 
        @foreach ($annexureResult['firstAnnexureResultQ9'] as $rowQ9 )     
        <tr class="row-template @if($i==1) q9-row @endif">
            <td>{{$i}}</td>
            <td>{{isset($rowQ9['clinic_name'])? $rowQ9['clinic_name']:'' }}</td>
            <td>{{isset($rowQ9['operating_since'])? date("d-m-Y",strtotime($rowQ9['operating_since'])):'' }}</td>
            <td>{{isset($rowQ9['action_taken'])? $rowQ9['action_taken']:'' }}</td>
        </tr>      
          @php $i++; @endphp 
        @endforeach
    @endif        
    </tbody>
</table>

