@forelse ($data as $show)
<tr class="foottr">
  <td class="foot1" data-label="WO Number">{{ $show->wo_number }}</td>
  <td class="foot1" data-label="Asset">{{ $show->asset_code }} -- {{ $show->asset_desc }}</td>
  <?php 
  // @if($show->wo_sr_nbr != null)
  // <td class="foot1" data-label="WO Type">WO from SR</td>
  // @elseif($show->wo_type == 'direct')
  // <td class="foot1" data-label="WO Type">Direct</td>
  // @elseif($show->wo_type == 'other')
  // @if($show->wo_sr_nbr != null)
  // <td class="foot1" data-label="WO Type">WO from SR</td>
  // @else
  // <td class="foot1" data-label="WO Type">Work Order</td>
  // @endif
  // @endif 
  ?>

  <td class="foot1" data-label="Status">{{ $show->retr_status }}</td>
  <td class="foot1" data-label="Priority">{{ $show->wo_priority }}</td>
  <td class="foot1" data-label="ReleasedDate">{{date('d-m-Y', strtotime($show->wo_released_date))}}</td>
  <td class="foot1" data-label="ReleasedTime">{{date('H:i', strtotime($show->wo_released_time))}}</td>
  <td class="foot1" data-label="ReleasedBy">{{ $show->wo_releasedby }}</td>
  <td class="foot1" style="text-align: center;">
    <input type="hidden" name='wonbrr' value="{{$show->wo_number}}">
    @if($show->getCurrentApproverRelease != null)
    <!-- <button type="button"  class="btn btn-success btn-action jobview" style="width: 100%;">View</button> -->
    @if($show->getCurrentApproverRelease->retr_role_approval == session('role') || session('role') == 'ADMIN')
    <a href="{{route('approvalRelease', $show->wo_number)}}"><i class="icon-table fas fa-thumbs-up fa-lg">
      </i></a>
    @else
    <a href="{{route('approvalReleaseInfo', $show->wo_number)}}"><i class="icon-table fas fa-eye fa-lg">
      </i></a>
    @endif
    @else
    <!-- <button type="button"  class="btn btn-success btn-action jobview" style="width: 100%;">View</button> -->
    <a href="{{route('approvalReleaseInfo', $show->wo_number)}}"><i class="icon-table fas fa-eye fa-lg">
      </i></a>
    @endif
    <a href="javascript:void(0)" class="route">
      <i class="icon-table fa fa-info-circle fa-lg"></i></a>
  </td>
  @empty
<tr>
  <td colspan="12" style="color:red;">
    <center>No Task Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>