@forelse($datas as $show)
<?php
// dd($show->sr_req_by);
?>
<tr>
    <td>{{$show->sr_number}}</td>
    <td>{{$show->sr_asset}}</td>
    <td>{{$show->asset_desc}}</td>
    <!-- <td>{{$show->asset_loc}}</td> -->
    <!-- <td>{{$show->sr_status}}</td> -->
    <!-- <td>{{is_null($show->wo_status) ? $show->sr_status : $show->wo_status}}</td> -->
    <td>{{$show->sr_status}}</td>
    <!-- <td>{{$show->sr_priority}}</td> -->
    <!-- <td>{{$show->dept_desc}}</td> -->
    <td>{{$show->username}}</td>

    <td>{{date('d-m-Y', strtotime($show->sr_req_date))}}</td>
    <td>{{date('H:i', strtotime($show->sr_req_time))}}</td>

    
    <td style="text-align: center;">
    <a href="javascript:void(0)" class="view" type="button" data-toggle="tooltip" title="View Service Request" 
    data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}"
    data-reqby="{{$show->name}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}"
    data-reqbyname="{{$show->sr_req_by}}" data-dept="{{$show->dept_desc}}" data-assetloc="{{$show->asset_loc}}" 
    data-astypedesc="{{$show->astype_desc}}" data-wotypedesc="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}"
    data-srdate="{{date('d-m-Y', strtotime($show->sr_req_date))}}" data-srtime="{{date('H:i', strtotime($show->sr_req_time))}}" data-wonumber="{{$show->wo_number}}" 
    data-startwo="{{date('d-m-Y', strtotime($show->wo_job_startdate))}}" 
    data-endwo="{{date('d-m-Y', strtotime($show->wo_job_finishdate))}}" data-engineer="{{$show->wo_list_engineer}}"
    data-approver="{{$show->eng_dept}} -- {{$show->u11}}" data-reason="{{is_null($show->srta_eng_reason) ? $show->srta_reason : $show->srta_eng_reason}}"
    data-wostatus="{{$show->sr_status}}" data-srcancelnote="{{$show->sr_cancel_note}}" 
    data-statusapproval="{{is_null($show->srta_eng_status) ? $show->srta_status : $show->srta_eng_status}}"
    data-failtype="{{$show->sr_fail_type}}" data-failcode="{{$show->sr_fail_code}}">
    <i class="icon-table far fa-eye fa-lg"></i></a>
   
    {{--  Jika tidak ada file upload, icon tidak muncul  --}}
    @php($cfile = $ceksrfile->where('sr_number','=',$show->sr_number)->count())
    @if($cfile > 0)
      <a id="srdownload" target="_blank" href="{{url('srdownloadfile/'.$show->sr_number)}}" data-toggle="tooltip"  title="Download SR document" ><i class="icon-table fas fa-download fa-lg"></i></a>  
    @endif
   
    <!-- &nbsp; -->
    <a href="{{url('srprint/'.$show->sr_number)}}" data-toggle="tooltip"  title="Print SR" target="_blank" ><i class="icon-table fa fa-print fa-lg"></i></a>

    {{--  Edit SR  --}}
    @php($session = session('username'))
    @php($cfile = $ceksrfile->where('sr_number','=',$show->sr_number)->count())
    @if($show->sr_req_by == $session && $show->sr_status != 'Canceled' && $show->sr_status != 'Inprocess' && $show->sr_status != 'Closed' && $show->sr_status != 'Acceptance' &&
    ($show->srta_status != 'Approved' && $show->srta_status != 'Canceled by user' || $show->srta_eng_status != 'Approved' && $show->srta_eng_status != 'Canceled by user'))
    <a href="javascript:void(0)" class="editsr" data-toggle="tooltip"  title="Edit SR"  data-target="#editModal" 
    data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}"
    data-reqby="{{$show->name}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" data-impact="{{$show->sr_impact}}"
    data-reqbyname="{{$show->sr_req_by}}" data-dept="{{$show->dept_desc}}" data-assetloc="{{$show->asset_loc}}" 
    data-astypedesc="{{$show->astype_desc}}" data-wotypedesc="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}"
    data-srdate="{{$show->sr_req_date}}" data-srtime="{{$show->sr_req_time}}" data-wonumber="{{$show->wo_number}}" 
    data-startwo="{{date('d-m-Y', strtotime($show->wo_job_startdate))}}" 
    data-endwo="{{date('d-m-Y', strtotime($show->wo_job_finishdate))}}" 
    data-approver="{{$show->sr_eng_approver}}" data-reason="{{is_null($show->srta_eng_reason) ? $show->srta_reason : $show->srta_eng_reason}}"
    data-wostatus="{{$show->sr_status}}" data-statusapproval="{{is_null($show->srta_eng_status) ? $show->srta_status : $show->srta_eng_status}}"
    data-failtype="{{$show->sr_fail_type}}" data-failcode="{{$show->sr_fail_code}}" data-cfile="{{$cfile}}">
    <i class="icon-table fa fa-edit fa-lg"></i></a>
    @endif

    {{--  Cancel SR  --}}
    @if($show->sr_req_by == $session && $show->sr_status != 'Canceled' && $show->sr_status != 'Inprocess')
    <a href="javascript:void(0)" class="cancelsr" data-toggle="tooltip"  title="Cancel SR"  data-target="#cancelModal" 
    data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}"
    data-reqby="{{$show->name}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" data-impact="{{$show->sr_impact}}"
    data-reqbyname="{{$show->sr_req_by}}" data-dept="{{$show->dept_desc}}" data-assetloc="{{$show->asset_loc}}" 
    data-astypedesc="{{$show->astype_desc}}" data-wotypedesc="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}"
    data-srdate="{{$show->sr_req_date}}" data-srtime="{{$show->sr_req_time}}" data-wonumber="{{$show->wo_number}}" 
    data-startwo="{{date('d-m-Y', strtotime($show->wo_job_startdate))}}" 
    data-endwo="{{date('d-m-Y', strtotime($show->wo_job_finishdate))}}" 
    data-approver="{{$show->sr_eng_approver}}"
    data-wostatus="{{is_null($show->wo_status) ? $show->sr_status : $show->wo_status}}" data-statusapproval="{{is_null($show->srta_eng_status) ? $show->srta_status : $show->srta_eng_status}}"
    data-failtype="{{$show->sr_fail_type}}" data-failcode="{{$show->sr_fail_code}}">
    <i class="icon-table fas fa-window-close fa-lg"></i></a>
    @endif
    </td>
    <td style="text-align: center;">
    <a href="javascript:void(0)" class="route" type="button" data-toggle="tooltip" title="Route SR Approval" data-target="#routeModal" data-id="{{$show->id}}" 
    data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}" data-srdate="{{$show->sr_req_date}}" data-reqby="{{$show->name}}" 
    data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" data-deptdesc="{{$show->dept_desc}}" data-reqbyname="{{$show->sr_req_by}}" 
    data-assetloc="{{$show->loc_desc}}" data-hassetloc="{{$show->asset_loc}}" data-astypedesc="{{$show->astype_desc}}" data-failcode="{{$show->sr_fail_code}}" 
    data-wotypedescx="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}">
    <i class="icon-table fa fa-info-circle fa-lg"></i>
    </td>
    <!-- <td style="text-align: center;">
    
    @php($session = session('username'))
    
    </td> -->
</tr>
@empty
<tr>
    <td colspan="20" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td colspan="11" style="border: none !important;" colspan="5">
    {{ $datas->links() }}
  </td>
</tr>