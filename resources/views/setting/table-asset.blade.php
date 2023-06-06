@forelse($data as $show)
@php($dsite = $datasite->where('assite_code','=',$show->asset_site)->first())
@php($dloc = $dataloc->where('asloc_code','=',$show->asset_loc)->where('asloc_site','=',$show->asset_site)->count())
@if($dloc == 0)
    @php($descloc = "")
@else
    @php($ddloc = $dataloc->where('asloc_code','=',$show->asset_loc)->where('asloc_site','=',$show->asset_site)->first())
    @php($descloc = $ddloc->asloc_desc)
@endif
<tr>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->astype_desc}}</td>
    <td>{{$show->asgroup_desc}}</td>
    <td>{{$show->asset_site}} : {{$descloc}}  </td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->asset_code}}" data-desc="{{$show->asset_desc}}" data-site="{{$show->asset_site}}" 
        data-loc="{{$show->asset_loc}}" data-um="{{$show->asset_um}}" data-sn="{{$show->asset_sn}}" 
        data-prc_date="{{$show->asset_prcdate}}" data-prc_price="{{$show->asset_prcprice}}" data-type="{{$show->asset_type}}" 
        data-group="{{$show->asset_group}}" data-supp="{{$show->asset_supp}}" data-note="{{$show->asset_note}}" 
        data-active="{{$show->asset_active}}" data-upload="{{$show->asset_upload}}" data-assetimg="{{$show->asset_image}}" 
        data-qad="{{$show->asset_accounting}}"  data-assetid="{{$show->asset_id}}">
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal"  
        data-code="{{$show->asset_code}}" data-desc="{{$show->asset_desc}}" 
        data-site="{{$show->asset_site}}" data-loc="{{$show->asset_loc}}">
            <i class="icon-table fa fa-trash fa-lg"></i></a>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td colspan="6" style="border: none !important;">
    {{ $data->appends($_GET)->links() }}
  </td>
</tr>