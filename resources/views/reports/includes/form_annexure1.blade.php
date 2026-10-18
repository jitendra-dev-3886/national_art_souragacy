 <h5 class="mb-4 text-primary">Annexure-I (For  Point 9 of the Format)</h5>
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
        @php $i=1; @endphp
    @if(isset($firstAnnexureResultQ9)) 
        @foreach ($firstAnnexureResultQ9 as $rowQ9 )
          @php
 // echo  $os=isset($rowQ9['operating_since']) and ($rowQ9['operating_since'])!='null'  ? str_replace("00:00:00","", $rowQ9['operating_since']);
 
   @endphp
        <tr class="row-template @if($i==1) q9-row @endif">
            <td><input type="text" class="form-control sno" value="{{$i}}" readonly></td>
            <td><input type="text" name="clinic_name_q9[]"   value="{{isset($rowQ9['clinic_name'])? $rowQ9['clinic_name']:'' }}" class="form-control clinic-name" ></td>
            <td><input type="date" name="operating_since_q9[]"  value="{{isset($rowQ9['operating_since'])? Carbon\Carbon::parse($rowQ9['operating_since'] )->toDateString():'' }}" class="form-control" > </td>
            <td><input type="text" name="action_taken_q9[]"  value="{{isset($rowQ9['action_taken'])? $rowQ9['action_taken']:'' }}" class="form-control action-taken" ></td>  
            <td class="aligns">
            <span class="btn btn-danger btn-sm removeRow">X</span>
            </td>
        </tr>      
          @php $i++; @endphp 
        @endforeach
    @endif
        <tr class="row-template @if($i==1) q9-row @endif">
            <td><input type="text" class="form-control sno" value="{{$i}}" readonly></td>
            <td><input type="text" name="clinic_name_q9[]"   value="" class="form-control clinic-name" ></td>
            <td><input type="date" name="operating_since_q9[]"  value="" class="form-control" ></td>
            <td><input type="text" name="action_taken_q9[]"  value="" class="form-control action-taken" ></td>  
            <td class="aligns">
            <span class="btn btn-danger btn-sm removeRow">X</span>
            </td>
        </tr>
    </tbody>
</table>

