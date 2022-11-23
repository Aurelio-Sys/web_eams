@forelse($datas as $show)
<tr>
    <td>{{$show->sr_number}}</td>

    @if($show->wo_number == "")
    <td>-</td>
    @else
    <td>{{$show->wo_number}}</td>
    @endif

    <td>{{$show->sr_assetcode}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->loc_desc}}</td>

    @if($show->sr_status == 1)
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
    <td>Completed</td>
    @elseif($show->sr_status == 8)
    <td>Reprocess</td>
    @endif
    <td>{{$show->sr_priority}}</td>
    <td>{{$show->dept_desc}}</td>
    <td>{{$show->req_by}}</td>

    <td>{{date('d-m-Y', strtotime($show->sr_date))}}</td>

    
    <td style="text-align: center;">
    <a href="javascript:void(0)" class="view" type="button" data-toggle="tooltip" title="View Service Request" 
    data-srnumber="{{$show->sr_number}}" data-assetcode="{{$show->sr_assetcode}}" data-assetdesc="{{$show->asset_desc}}"
    data-reqby="{{$show->username}}" data-srnote="{{$show->sr_note}}" data-priority="{{$show->sr_priority}}" 
    data-rejectnote="{{$show->rejectnote}}" data-eng1="{{$show->u11}}" data-eng2="{{$show->u22}}" 
    data-eng3="{{$show->u33}}" data-eng4="{{$show->u44}}" data-eng5="{{$show->u55}}"
    data-reqbyname="{{$show->req_by}}" data-dept="{{$show->dept_desc}}" data-assetloc="{{$show->loc_desc}}" 
    data-astypedesc="{{$show->astype_desc}}" data-wotypedesc="{{$show->wotyp_desc}}" data-impactcode="{{$show->sr_impact}}"
    data-srdate="{{date('d-m-Y', strtotime($show->sr_date))}}" data-wonumber="{{$show->wo_number}}" 
    data-startwo="{{date('d-m-Y', strtotime($show->wo_start_date))}}" 
    data-endwo="{{date('d-m-Y', strtotime($show->wo_finish_date))}}" 
    data-action="{{$show->wo_action}}" data-approver="{{$show->sr_approver}}"
    data-wostatus="{{$show->wo_status}}"
    data-failtype="{{$show->sr_wotype}}"
    data-faildesc1="{{$show->k11}}" data-faildesc2="{{$show->k22}}" data-faildesc3="{{$show->k33}}">
    <i class="icon-table far fa-eye fa-lg"></i></a>
   
    {{--  Jika tidak ada file upload, icon tidak muncul  --}}
    @php($cfile = $ceksrfile->where('sr_number','=',$show->sr_number)->count())
    @if($cfile > 0)
      <a id="srdownload" target="_blank" href="{{url('srdownloadfile/'.$show->sr_number)}}" data-toggle="tooltip"  title="Download SR document" ><i class="icon-table fas fa-download fa-lg"></i></a>  
    @endif
   
    &nbsp;
    <a href="{{url('srprint/'.$show->sr_number)}}" data-toggle="tooltip"  title="Print SR" target="_blank" ><i class="icon-table fa fa-print fa-lg"></i></a>
    
    </td>
</tr>
@empty
<tr>
    <td colspan="11" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td colspan="11" style="border: none !important;" colspan="5">
    {{ $datas->links() }}
  </td>
</tr>