@forelse($data as $show)

@php($qdet = $dataqcs->where('qcs_code','=',$show->rcm_qcs))
@php($desc1 = "")
@foreach($qdet as $qdet)
  @if($desc1 == "")
    @php($desc1 = $qdet->qcs_desc)
  @else
    @php($desc1 = $desc1 . " ; " . $qdet->qcs_desc)
  @endif
@endforeach

<tr>
    <td>{{$show->rcm_asset}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->rcm_qcs}}</td>
    <td>{{$desc1}}</td>
    <td>{{date('H:i', strtotime($show->rcm_start))}} - {{date('H:i', strtotime($show->rcm_end))}}</td>
    <td>{{$show->rcm_interval}} HR</td>
    <td>{{$show->rcm_eng}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-asset="{{$show->rcm_asset}}" data-qcs="{{$show->rcm_qcs}}" data-start="{{$show->rcm_start}}"
        data-end="{{$show->rcm_end}}" data-interval="{{$show->rcm_interval}}" data-eng="{{$show->rcm_eng}}"
        data-email="{{$show->rcm_email}}"
        >
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-asset="{{$show->rcm_asset}}" data-qcs="{{$show->rcm_qcs}}"
        data-assetdesc="{{$show->asset_desc}}" data-qcsdesc="{{$desc1}}" >
        <i class="icon-table fa fa-trash fa-lg"></i></a>
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
  <td style="border: none !important;">
    {{ $data->appends($_GET)->links() }}
  </td>
</tr>