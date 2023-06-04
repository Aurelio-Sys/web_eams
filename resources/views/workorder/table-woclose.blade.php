@forelse ($data as $show)
<tr class="foottr">
  <td class="foot2" data-label="WO Number">{{ $show->wo_number }}</td>
  <td class="foot2" data-label="Asset">{{ $show->asset_code }} -- {{ $show->asset_desc }}</td>
  <td class="foot2" data-label="WO Type">{{ $show->wo_type }}</td>
  <td class="foot2" data-label="Status">{{ $show->wo_status }}</td>
  <td class="foot2" >
  <div class="text-center">
  <input type="hidden" name='wonbrr' value="{{$show->wo_number}}"> 
  <input type="hidden" name='wotypee' value="{{$show->wo_type}}"> 
  @if($show->wo_status == 'started')
    <!-- <button type="button" class="btn btn-success btn-action jobview" style="width: 80%;">View</button> -->
    <a class="btn btn-success btn-action" href="{{route('reportingWO', $show->wo_number)}}" title="{{$show->wo_editstatus == true ? 'Edit Report WO' : 'Report WO'}}"><i class="{{$show->wo_editstatus == true ? 'fas fa-file-signature' : 'fas fa-check-square'}}"></i></a>
  
  @endif

  
  @if($show->wo_status =='reported')
  <a class="aprint" target="_blank" title="print WO"><button type="button" class="btn btn-warning bt-action"><i class="fas fa-print"></i></button></a>
  <a class="reissued" href="{{route('reissuedWO', $show->wo_number)}}" title="Reissued WO"><button type="button" class="btn btn-danger" style="width: 25%;"><i class="fas fa-file-contract"></i></button></a>
  @endif


  {{-- Print 
  @if($show->wo_status == 'reported' )
    <a class="aprint" target="_blank" style="width: 80%;"><button type="button" class="btn btn-warning bt-action" style="width: 80%;"><b>Print<b></button></a> 
  @endif
  --}}
  </div> 
    
  </td>
</tr>
@empty
<tr>
  <td colspan="5" style="color:red;">
    <center>No Task Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>