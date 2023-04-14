@forelse($data as $show)

<tr>
    <td>{{$show->pma_asset}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->pma_pmcode}}</td>
    <td>{{$show->pmc_desc}}</td>
    <td>{{$show->pma_mea}}</td>
    <td>{{$show->pma_cal}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-asset="{{$show->pma_asset}}" data-pmcode="{{$show->pma_pmcode}}" data-time="{{$show->pma_leadtime}}" 
        data-mea="{{$show->pma_mea}}" 
        data-cal="{{$show->pma_cal}}" data-meter="{{$show->pma_meter}}" data-meterum="{{$show->pma_meterum}}" 
        data-tolerance="{{$show->pma_tolerance}}" data-start="{{$show->pma_start}}" data-eng="{{$show->pma_eng}}"
        >
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-asset="{{$show->pma_asset}}" data-pmcode="{{$show->pma_pmcode}}"
        data-assetdesc="{{$show->asset_desc}}" data-pmcodedesc="{{$show->pmc_desc}}" >
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