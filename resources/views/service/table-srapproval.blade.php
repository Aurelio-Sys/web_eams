@forelse($datas as $key => $show)
<?php
?>
@php($session = session('role'))
  <tr>
    <td>{{$show->sr_number}}</td>
    <!-- <td>{{$show->asset_code}} -- {{$show->asset_desc}}</td>
    <td>{{$show->asset_loc}}</td>
    <td>{{$show->sr_priority}}</td>
    <td>{{$show->name}}</td>
    <td>{{$show->sr_req_date}}</td>
    <td>{{$show->sr_note}}</td> -->
    @if($show->wo_number == "")
    <td>-</td>
    @else
    <td>{{$show->wo_number}}</td>
    @endif

    <td>{{$show->sr_asset}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->asset_loc}}</td>
    <td>{{is_null($show->wo_status) ? $show->sr_status : $show->wo_status}}</td>

    <td>{{$show->sr_priority}}</td>
    <td>{{$show->dept_desc}}</td>
    <td>{{$show->name}}</td>

    <td>{{date('d-m-Y', strtotime($show->sr_req_date))}}</td>
    <td>{{date('H:i', strtotime($show->sr_req_time))}}</td>

    <td style="text-align: center;">
    @if($show->getCurrentApprover != null)
      @if($show->getCurrentApprover->srta_role_approval == $session || $session == 'ADMIN' && $show->sr_status == 'Open' || $show->sr_status == 'Revise')
      <a href="javascript:void(0)" class="approval" type="button" data-toggle="tooltip" title="Service Request Approval" data-target="#approvalModal" data-id="{{$show->id}}" data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}" data-assetloc="{{$show->asset_loc}}" data-srdate="{{$show->sr_req_date}}" data-reqby="{{$show->name}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" data-deptdesc="{{$show->dept_desc}}" data-deptcode="{{$show->dept_code}}" data-reqbyname="{{$show->sr_req_by}}" data-assetloc="{{$show->asset_loc}}" data-hassetloc="{{$show->asset_loc}}" data-hassetsite="{{$show->asset_site}}" data-astypedesc="{{$show->astype_desc}}" data-failcode="{{$show->sr_fail_code}}" data-wotypedescx="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}">
        <i class="icon-table fas fa-thumbs-up fa-lg"></i>
      </a>
      @elseif($show->getCurrentApprover->srta_role_approval != $session)
      <a href="javascript:void(0)" class="view" type="button" data-toggle="tooltip" title="Service Request View" data-target="#viewModal" data-id="{{$show->id}}" data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}" data-assetloc="{{$show->asset_loc}}" data-srdate="{{$show->sr_req_date}}" data-reqby="{{$show->name}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" data-deptdesc="{{$show->dept_desc}}" data-deptcode="{{$show->dept_code}}" data-reqbyname="{{$show->sr_req_by}}" data-assetloc="{{$show->asset_loc}}" data-hassetloc="{{$show->asset_loc}}" data-hassetsite="{{$show->asset_site}}" data-astypedesc="{{$show->astype_desc}}" data-failcode="{{$show->sr_fail_code}}" data-reason="{{$show->srta_reason}}" data-wotypedescx="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}">
        <i class="icon-table far fa-eye fa-lg"></i>
      </a>
      @else
      <a href="javascript:void(0)" class="view" type="button" data-toggle="tooltip" title="Service Request View" data-target="#viewModal" data-id="{{$show->id}}" data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}" data-assetloc="{{$show->asset_loc}}" data-srdate="{{$show->sr_req_date}}" data-reqby="{{$show->name}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" data-deptdesc="{{$show->dept_desc}}" data-deptcode="{{$show->dept_code}}" data-reqbyname="{{$show->sr_req_by}}" data-assetloc="{{$show->asset_loc}}" data-hassetloc="{{$show->asset_loc}}" data-hassetsite="{{$show->asset_site}}" data-astypedesc="{{$show->astype_desc}}" data-failcode="{{$show->sr_fail_code}}" data-reason="{{$show->srta_reason}}" data-wotypedescx="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}">
        <i class="icon-table far fa-eye fa-lg"></i>
      </a>
      @endif
    @else
    <a href="javascript:void(0)" class="view" type="button" data-toggle="tooltip" title="Service Request View" data-target="#viewModal" data-id="{{$show->id}}" data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}" data-assetloc="{{$show->asset_loc}}" data-srdate="{{$show->sr_req_date}}" data-reqby="{{$show->name}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" data-deptdesc="{{$show->dept_desc}}" data-deptcode="{{$show->dept_code}}" data-reqbyname="{{$show->sr_req_by}}" data-assetloc="{{$show->asset_loc}}" data-hassetloc="{{$show->asset_loc}}" data-hassetsite="{{$show->asset_site}}" data-astypedesc="{{$show->astype_desc}}" data-failcode="{{$show->sr_fail_code}}" data-reason="{{$show->srta_reason}}" data-wotypedescx="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}">
        <i class="icon-table far fa-eye fa-lg"></i>
      </a>
    @endif

      <a href="javascript:void(0)" class="route" type="button" data-toggle="tooltip" title="Route SR Approval" data-target="#routeModal" data-id="{{$show->id}}" data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" data-assetdesc="{{$show->asset_desc}}" data-assetloc="{{$show->asset_loc}}" data-srdate="{{$show->sr_req_date}}" data-reqby="{{$show->name}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" data-deptdesc="{{$show->dept_desc}}" data-deptcode="{{$show->dept_code}}" data-reqbyname="{{$show->sr_req_by}}" data-assetloc="{{$show->asset_loc}}" data-hassetloc="{{$show->asset_loc}}" data-hassetsite="{{$show->asset_site}}" data-astypedesc="{{$show->astype_desc}}" data-failcode="{{$show->sr_fail_code}}" data-wotypedescx="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}">
        <i class="icon-table fa fa-info-circle fa-lg"></i>
    </td>
  </tr>
  
<tr style="display: none;"></tr>
@empty
<tr>
  <td colspan="12" style="color:red">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td colspan="11" style="border: none !important;">
    {{ $datas->links() }}
  </td>
</tr>