@forelse($datas as $show)
<tr>
    <td>{{$show->sr_number}}</td>
    <td>{{$show->asset_code}} -- {{$show->asset_desc}}</td>
    <td>{{$show->asloc_desc}}</td>
    <td>{{$show->sr_priority}}</td>
    <td>{{$show->name}}</td>
    <td>{{$show->sr_req_date}}</td>
    <td>{{$show->sr_note}}</td>
    
    <td style="text-align: center;">
    <a href="javascript:void(0)" class="approvaleng" type="button" data-toggle="tooltip" title="Service Request Approval" 
    data-target="#viewModal" data-idsr="{{$show->id}}" data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_asset}}" 
    data-assetdesc="{{$show->asset_desc}}" data-srdate="{{$show->sr_req_date}}"
    data-reqby="{{$show->username}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" 
    data-deptdesc="{{$show->dept_desc}}" data-deptcode="{{$show->dept_code}}" data-reqbyname="{{$show->sr_req_by}}" 
    data-assetloc="{{$show->asloc_desc}}" data-hassetloc="{{$show->asset_loc}}" data-hassetsite="{{$show->asset_site}}"
    data-astypedesc="{{$show->astype_desc}}"
    data-wotypedescx="{{$show->wotyp_code}}" data-impactcode="{{$show->sr_impact}}">
    <i class="icon-table fas fa-thumbs-up fa-lg">
    </i></a>
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