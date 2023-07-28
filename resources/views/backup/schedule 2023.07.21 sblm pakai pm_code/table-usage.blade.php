@forelse ($data as $show)
<tr class="foottr">
  <td class="foot1" data-label="WO Number">{{ $show->asset_code }}</td>
  <td class="foot1" data-label="Asset">{{ $show->asset_desc }}</td>
  <td class="foot1" data-label="Asset">{{ $show->asset_site }} - {{ $show->asloc_desc }}</td>
  <td class="foot1" data-label="Asset" style="text-align: center">M</td>
  <td class="foot1" data-label="Last Measurement" style="text-align: right">
  </td>
  <td class="foot1" style="text-align: center;" >
    <a href="" class="editmodal" data-toggle="modal" data-target="#editModal" 
          data-asset="{{$show->asset_code}}" data-desc="{{$show->asset_desc}}"><i class="fas fa-edit"></i></a>  
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