@forelse($datas as $show)
@php($session_role = session('role'))
@php($session_dept = session('department'))
<?php
// dd($session_role);
?>
<tr>
    <td>{{$show->sr_number}}</td>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
    @if( $show->srta_eng_status == 'Revision from engineer approval')
    <td> Rejected </td>
    @elseif ($show->srta_eng_status == 'Waiting for engineer approval')
    <td> Waiting for approval </td>
    @else
    <td> Approved </td>
    @endif
    <!-- <td>{{$show->asset_loc}}</td> -->
    <td>{{$show->sr_priority}}</td>
    <td>{{$show->username}}</td>
    <td>{{date('d-m-Y', strtotime($show->sr_req_date))}}</td>
    <td>{{date('H:i', strtotime($show->sr_req_time))}}</td>
    
    <td style="text-align: center;">
    @if($show->srta_eng_status == 'Waiting for engineer approval')
    <a href="javascript:void(0)" class="approvaleng" type="button" data-toggle="tooltip" title="Service Request Approval" 
    data-target="#viewModal" data-idsr="{{$show->id}}" data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" 
    data-assetdesc="{{$show->asset_desc}}" data-srdate="{{$show->sr_req_date}}"
    data-reqby="{{$show->username}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" 
    data-deptdesc="{{$show->dept_desc}}" data-deptcode="{{$show->dept_code}}" data-reqbyname="{{$show->sr_req_by}}" 
    data-assetloc="{{$show->asloc_desc}}" data-hassetloc="{{$show->asset_loc}}" data-hassetsite="{{$show->asset_site}}"
    data-astypedesc="{{$show->astype_desc}}" data-failcode="{{$show->sr_fail_code}}" data-engineer="{{$show->wo_list_engineer}}"
    data-wotypedescx="{{$show->wotyp_code}}" data-impactcode="{{$show->sr_impact}}">
    <i class="icon-table fas fa-thumbs-up fa-lg">
    </i></a>
    @else
    <a href="javascript:void(0)" class="viewapprovaleng" type="button" data-toggle="tooltip" title="Service Request Approval View" 
    data-target="#viewApprModal" data-idsr="{{$show->id}}" data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" 
    data-assetdesc="{{$show->asset_desc}}" data-srdate="{{$show->sr_req_date}}"
    data-reqby="{{$show->username}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" 
    data-deptdesc="{{$show->dept_desc}}" data-deptcode="{{$show->dept_code}}" data-reqbyname="{{$show->sr_req_by}}" 
    data-assetloc="{{$show->asloc_desc}}" data-hassetloc="{{$show->asset_loc}}" data-hassetsite="{{$show->asset_site}}"
    data-astypedesc="{{$show->astype_desc}}" data-failcode="{{$show->sr_fail_code}}" data-engineer="{{$show->wo_list_engineer}}"
    data-wotypedescx="{{$show->wotyp_code}}" data-impactcode="{{$show->sr_impact}}" data-status="{{$show->srta_eng_status}}" 
    data-reason="{{$show->srta_eng_reason}}" data-wonote="{{$show->wo_note}}" data-engineer="{{$show->wo_list_engineer}}"
    data-wostart="{{$show->wo_start_date}}" data-wodue="{{$show->wo_due_date}}" data-womtc="{{$show->wo_mt_code}}"
    data-woinsc="{{$show->wo_ins_code}}" data-wospc="{{$show->wo_sp_code}}" data-woqcs="{{$show->wo_qcspec_code}}">
    <i class="icon-table fas fa-eye fa-lg">
    </i></a>
    @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="8" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td colspan="6" style="border: none !important;">
    {{ $datas->links() }}
  </td>
</tr>