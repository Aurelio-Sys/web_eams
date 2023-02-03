@forelse ($data as $show)
<tr class="foottr">
  <td class="foot1" data-label="WO Number">{{ $show->assetcode }}</td>
  <td class="foot1" data-label="Asset">{{ $show->asset_desc }}</td>
  <td class="foot1" data-label="Asset">{{ $show->asloc_code }} - {{ $show->asloc_desc }}</td>
  <td class="foot1" data-label="Asset" style="text-align: right">{{ number_format($show->asset_meter,2) }}</td>
  <td class="foot1" data-label="Asset" style="text-align: center">{{ $show->asset_mea_um }}</td>
  <td class="foot1" data-label="Last Usage" style="text-align: right">
  @if(is_null($show->asset_last_usage))
    0
  @else
    {{ number_format($show->asset_last_usage,2) }}
  @endif
  </td>
  <td class="foot1" data-label="Next Usage" style="text-align: right">{{ number_format($show->asset_last_usage + $show->asset_meter,2) }}</td>
  <td class="foot1" data-label="Last Checked" style="text-align: right">
  @if(is_null($show->asset_last_usage_mtc))
    0
  @else
    {{ number_format($show->asset_last_usage_mtc,2) }}
  @endif
  </td>
  <td class="foot1" style="text-align: center;" >
    <a href="" class="editmodal" data-toggle="modal" data-target="#editModal" 
            data-asset="{{$show->assetcode}}" data-desc="{{$show->asset_desc}}" data-lastusage="{{$show->asset_last_usage}}"
            data-lastmt="{{$show->asset_last_usage_mtc}}"><i class="fas fa-edit"></i></a>  
  </td>
</tr>
@empty
<tr>
  <td colspan="10" style="color:red;" class="nodata">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;" colspan="10">
    {{ $data->links() }}
  </td>
</tr>