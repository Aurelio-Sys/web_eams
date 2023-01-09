@forelse($datas as $show)
<tr>
    <td>{{$show->sr_number}}</td>
    <td>{{$show->sr_date}}</td>
    <td>{{$show->asset_code}} -- {{$show->asset_desc}}</td>
    <td>{{$show->loc_desc}}</td>
    <td>{{$show->name}}</td>
    <td>{{$show->sr_note}}</td>
    <td>{{$show->sr_priority}}</td>
    <td style="text-align: center;">
    <a href="javascript:void(0)" class="approval" type="button" data-toggle="tooltip" title="Service Request Approval" 
    data-target="#viewModal" data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_assetcode}}" 
    data-assetdesc="{{$show->asset_desc}}" data-srdate="{{$show->sr_date}}"
    data-reqby="{{$show->username}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" 
    data-deptdesc="{{$show->dept_desc}}" data-deptcode="{{$show->dept_code}}" data-reqbyname="{{$show->req_by}}" 
    data-assetloc="{{$show->loc_desc}}" data-astypedesc="{{$show->astype_desc}}"
    data-wotypedescx="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}"
    data-fc1="{{$show->sr_failurecode1}}" data-fc2="{{$show->sr_failurecode2}}" data-fc3="{{$show->sr_failurecode3}}" 
    data-failcode1="{{$show->k11}}" data-failcode2="{{$show->k22}}" data-failcode3="{{$show->k33}}">
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