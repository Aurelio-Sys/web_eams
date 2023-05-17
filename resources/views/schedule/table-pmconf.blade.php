@forelse($data as $show)

@if($show->pmo_source == "WO")
   @php($qtemppm = $datalog->where('pml_wo_number','=',$show->pmo_number)->first())
   @php($dtemppm = $qtemppm->pml_pm_number)
   @php($dtempdate = $qtemppm->pml_pm_date)
@else
   @php($dtemppm = "tese")
   @php($dtempdate = "tese")
@endif

<tr>
    <td>{{$show->pmo_asset}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->pmo_pmcode}}</td>
    <td> @if($show->pmo_source == "TEMP-PM") PM{{$show->pmo_number}} @else PM{{$dtemppm}} @endif </td>
    <td> @if($show->pmo_source == "TEMP-PM") {{$show->pmo_sch_date}} @else {{$dtempdate}} @endif</td>
    <td> @if($show->pmo_source == "WO") {{$show->pmo_number}} @endif</td>
    <td> @if($show->pmo_source == "WO") {{$show->pmo_sch_date}} @endif</td>
    <td>
         <input type="checkbox" name="te_conf" id="te_conf" >

         @if($show->pmo_source == "WO")
         <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
         data-code="{{$show->pmo_number}}"  >
         <i class="icon-table fa fa-edit fa-lg"></i></a>
         @endif
         
    </td>
</tr>
@empty
<tr>
    <td colspan="7" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td colspan="7" style="border: none !important;">
    {{ $data->appends($_GET)->links() }}
  </td>
</tr>