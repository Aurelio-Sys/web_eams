@forelse($dataua as $show)
<tr>
    <td>{{$show->sr_number}}</td>
    @if($show->wo_number == "")
    <td>-</td>
    @else
    <td>{{$show->wo_number}}</td>
    @endif
    <td>{{$show->asset_desc}}</td>
    <!-- <td>{{$show->dept_desc}}</td> -->
    <td>{{$show->wo_status}}</td>
    <td>{{$show->sr_priority}}</td>
    <td>{{date('d-m-Y', strtotime($show->created_at))}}</td>
    
    <td style="text-align: center;">
    <a href="javascript:void(0)" class="view" type="button" data-toggle="tooltip" title="User Acceptance" 
    data-srnumber="{{$show->sr_number}}" data-wonumber="{{$show->wo_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}"
    data-reqby="{{$show->name}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}"
    data-reqbyname="{{$show->sr_req_by}}" data-dept="{{$show->dept_desc}}" data-assetloc="{{$show->asset_loc}}" 
    data-astypedesc="{{$show->astype_desc}}" data-wotypedesc="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}"
    data-srdate="{{date('d-m-Y', strtotime($show->sr_req_date))}}" data-srtime="{{date('H:i', strtotime($show->sr_req_time))}}" data-wonumber="{{$show->wo_number}}" 
    data-startwo="{{date('d-m-Y', strtotime($show->wo_job_startdate))}}" 
    data-endwo="{{date('d-m-Y', strtotime($show->wo_job_finishdate))}}" data-engineer="{{$show->wo_list_engineer}}"
    data-approver="{{$show->eng_dept}} -- {{$show->u11}}" data-reason="{{is_null($show->srta_eng_reason) ? $show->srta_reason : $show->srta_eng_reason}}"
    data-wostatus="{{$show->sr_status}}" data-srcancelnote="{{$show->sr_cancel_note}}" 
    data-statusapproval="{{is_null($show->srta_eng_status) ? $show->srta_status : $show->srta_eng_status}}"
    data-failtype="{{$show->sr_fail_type}}" data-failcode="{{$show->sr_fail_code}}" data-reportnote="{{$show->wo_report_note}}">
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