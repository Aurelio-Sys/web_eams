@forelse($datas as $show)
<tr>
    <td>{{$show->sr_number}}</td>

    @if($show->wo_number == "")
    <td>-</td>
    @else
    <td>{{$show->wo_number}}</td>
    @endif

    <td>{{$show->sr_asset}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->loc_desc}}</td>
    <!-- <td>{{$show->sr_status}}</td> -->
    <td>{{is_null($show->wo_status) ? $show->sr_status : $show->wo_status}}</td>

    <!-- @if($show->sr_status == 1)
    <td>Open</td>
    @elseif($show->sr_status == 2)
    <td>Assigned</td>
    @elseif($show->sr_status == 3)
    <td>Started</td>
    @elseif($show->sr_status == 4)
    <td>Finish</td>
    @elseif($show->sr_status == 5)
    <td>Closed</td>
    @elseif($show->sr_status == 6)
    <td>Incomplete</td>
    @elseif($show->sr_status == 7)
    <td>Waiting QC</td>
    @elseif($show->sr_status == 8)
    <td>Reprocess</td>
    @elseif($show->sr_status == 9)
    <td>Rejected</td>
    @endif -->
    <td>{{$show->sr_priority}}</td>
    <td>{{$show->dept_desc}}</td>
    <td>{{$show->name}}</td>

    <td>{{date('d-m-Y', strtotime($show->sr_req_date))}}</td>
    <td>{{date('H:i', strtotime($show->sr_req_time))}}</td>

    
    <td style="text-align: center;">
    <a href="javascript:void(0)" class="view" type="button" data-toggle="tooltip" title="View Service Request" 
    data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}"
    data-reqby="{{$show->name}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}"
    data-reqbyname="{{$show->sr_req_by}}" data-dept="{{$show->dept_desc}}" data-assetloc="{{$show->loc_desc}}" 
    data-astypedesc="{{$show->astype_desc}}" data-wotypedesc="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}"
    data-srdate="{{date('d-m-Y', strtotime($show->sr_req_date))}}" data-srtime="{{date('H:i', strtotime($show->sr_req_time))}}" data-wonumber="{{$show->wo_number}}" 
    data-startwo="{{date('d-m-Y', strtotime($show->wo_job_startdate))}}" 
    data-endwo="{{date('d-m-Y', strtotime($show->wo_job_finishdate))}}" 
    data-approver="{{$dataapps->dept_code}} -- {{$dataapps->dept_desc}}" data-reason="{{is_null($show->srta_eng_reason) ? $show->srta_reason : $show->srta_eng_reason}}"
    data-wostatus="{{is_null($show->wo_status) ? $show->sr_status : $show->wo_status}}" data-statusapproval="{{is_null($show->srta_eng_status) ? $show->srta_status : $show->srta_eng_status}}"
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
    @if($show->sr_req_by == $session && $show->sr_status != 'Canceled')
    <a href="javascript:void(0)" class="editsr" data-toggle="tooltip"  title="Edit SR"  data-target="#editModal" 
    data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}"
    data-reqby="{{$show->name}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" data-impact="{{$show->sr_impact}}"
    data-reqbyname="{{$show->sr_req_by}}" data-dept="{{$show->dept_desc}}" data-assetloc="{{$show->loc_desc}}" 
    data-astypedesc="{{$show->astype_desc}}" data-wotypedesc="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}"
    data-srdate="{{$show->sr_req_date}}" data-srtime="{{$show->sr_req_time}}" data-wonumber="{{$show->wo_number}}" 
    data-startwo="{{date('d-m-Y', strtotime($show->wo_job_startdate))}}" 
    data-endwo="{{date('d-m-Y', strtotime($show->wo_job_finishdate))}}" 
    data-approver="{{$show->sr_eng_approver}}" data-reason="{{is_null($show->srta_eng_reason) ? $show->srta_reason : $show->srta_eng_reason}}"
    data-wostatus="{{is_null($show->wo_status) ? $show->sr_status : $show->wo_status}}" data-statusapproval="{{is_null($show->srta_eng_status) ? $show->srta_status : $show->srta_eng_status}}"
    data-failtype="{{$show->sr_fail_type}}" data-failcode="{{$show->sr_fail_code}}">
    <i class="icon-table fa fa-edit fa-lg"></i></a>
    @endif
    </td>
    <td style="text-align: center;">
    {{--  Cancel SR  --}}
    @php($session = session('username'))
    @if($show->sr_req_by == $session && $show->sr_status != 'Canceled')
    <a href="javascript:void(0)" class="cancelsr" data-toggle="tooltip"  title="Cancel SR"  data-target="#cancelModal" 
    data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}"
    data-reqby="{{$show->name}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" data-impact="{{$show->sr_impact}}"
    data-reqbyname="{{$show->sr_req_by}}" data-dept="{{$show->dept_desc}}" data-assetloc="{{$show->loc_desc}}" 
    data-astypedesc="{{$show->astype_desc}}" data-wotypedesc="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}"
    data-srdate="{{$show->sr_req_date}}" data-srtime="{{$show->sr_req_time}}" data-wonumber="{{$show->wo_number}}" 
    data-startwo="{{date('d-m-Y', strtotime($show->wo_job_startdate))}}" 
    data-endwo="{{date('d-m-Y', strtotime($show->wo_job_finishdate))}}" 
    data-approver="{{$show->sr_eng_approver}}"
    data-wostatus="{{is_null($show->wo_status) ? $show->sr_status : $show->wo_status}}" data-statusapproval="{{is_null($show->srta_eng_status) ? $show->srta_status : $show->srta_eng_status}}"
    data-failtype="{{$show->sr_fail_type}}" data-failcode="{{$show->sr_fail_code}}">
    <i class="icon-table fa fa-times fa-lg"></i></a>
    @endif
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
  <td colspan="11" style="border: none !important;" colspan="5">
    {{ $datas->links() }}
  </td>
</tr>