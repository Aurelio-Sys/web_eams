@forelse($dataua as $show)
<tr>
    <td>{{$show->sr_number}}</td>
    @if($show->wo_number == "")
    <td>-</td>
    @else
    <td>{{$show->wo_number}}</td>
    @endif
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->dept_desc}}</td>
    <td>{{$show->sr_priority}}</td>
    <td>{{date('d-m-Y', strtotime($show->created_at))}}</td>
    
    <td style="text-align: center;">
    <a href="javascript:void(0)" class="view" type="button" data-toggle="tooltip" title="User Acceptance" 
    data-srnumber="{{$show->sr_number}}" data-wonumber="{{$show->wo_number}}" 
    data-srdate="{{date('d-m-Y', strtotime($show->created_at))}}"
    data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}"
    data-reqby="{{$show->sr_req_by}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" 
    data-wostatus="{{$show->wo_status}}" data-dept="{{$show->dept_desc}}" 
    data-impactcode="{{$show->sr_impact}}" >
    <i class="icon-table fas fa-check-double fa-lg"></i></a>
    </td>
</tr>
@empty
<tr>
    <td colspan="12" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;">
    {{ $dataua->links() }}
  </td>
</tr>