@forelse ($data as $show)
<tr class="foottr">
  {{--  Mencari data pengukuran terakhir  --}}
  @php($qlastmea = $dataussage->where('us_asset','=',$show->asset_code)->where('us_mea_um','=',$show->pma_meterum)->first())
  @php($lastusage = $qlastmea ? $qlastmea->us_last_mea : 0)
  @php($dlastdate = $qlastmea ? date('d-m-Y', strtotime($qlastmea->tgl)) : "-")
  @php($dloc = $show->asset_site . " : " . $show->asset_loc . " - " . $show->asloc_desc )

  <td>{{ $show->asset_code }}</td>
  <td>{{ $show->asset_desc }}</td>
  <td>{{ $show->asset_site }} : {{ $show->asset_loc }} - {{ $show->asloc_desc }}</td>
  <td style="text-align: center">{{ $show->pma_meterum }}</td>
  <td style="text-align: right">{{ $dlastdate }}</td>
  <td style="text-align: right">{{ number_format($lastusage,2) }}</td>

  <td class="foot1" style="text-align: center;" >
    {{--  {{ $dloc }}  --}}
    <a href="" class="editmodal" data-toggle="modal" data-target="#editModal" 
          data-asset="{{$show->asset_code}}" data-desc="{{$show->asset_desc}}" data-lastusage="{{$lastusage}}"
          data-lastdate={{$dlastdate}} data-meterum={{$show->pma_meterum}} data-assetloc={{rawurlencode($dloc)}} >
      <i class="fas fa-edit"></i></a>  
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
    {{ $data->appends($_GET)->links() }}
  </td>
</tr>