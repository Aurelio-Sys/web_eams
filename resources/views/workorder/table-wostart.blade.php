@forelse ($data as $show)
<tr class="foottr">
  <td class="foot1" data-label="WO Number">{{ $show->wo_number }}</td>
  <td class="foot1" data-label="Asset">{{ $show->asset_code }} -- {{ $show->asset_desc }}</td>
  @if($show->wo_type == 'auto')
  <td class="foot1" data-label="WO Type">Preventive</td>
  @elseif($show->wo_type == 'direct')
  <td class="foot1" data-label="WO Type">Direct</td>
  @elseif($show->wo_type == 'other')
    @if($show->wo_sr_nbr != null)
    <td class="foot1" data-label="WO Type">WO from SR</td>
    @else
    <td class="foot1" data-label="WO Type">Work Order</td>
    @endif
  @endif

  <td class="foot1" data-label="Status">{{ $show->wo_status }}</td>
  <td class="foot1" data-label="Priority">{{ $show->wo_priority }}</td>
  <td class="foot1" >
  <input type="hidden" name='wonbrr' value="{{$show->wo_number}}"> 
  <input type="hidden" name='srnbrr' value="{{$show->wo_sr_number}}"> 
  @if($show->wo_status == 'released')
    <button type="button"  class="btn btn-success btn-action jobview" style="width: 50%;">View</button>
    @php
      $cekviewsparepart = $wodet_sp->where('wd_sp_wonumber','=', $show->wo_number)->first();
    @endphp

      @if ($cekviewsparepart != null)
        <a class="btn btn-info" href="{{route('viewSP', $show->wo_number)}}" title="View Spare Part"><i class="fas fa-list-ol"></i></a>
      @endif
    
    @else
    <button type="button"  class="btn btn-warning btn-action jobview" style="width: 50%;">View</button>
      @php
        $cekviewsparepart = $wodet_sp->where('wd_sp_wonumber','=', $show->wo_number)->first();
      @endphp
      @if ($cekviewsparepart != null)
        <a class="btn btn-info" href="{{route('viewSP', $show->wo_number)}}" title="View Spare Part"><i class="fas fa-list-ol"></i></a>
      @endif
  @endif
    
  </td>
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