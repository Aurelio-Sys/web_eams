@forelse ($data as $show)
<tr>
  <td>{{ $show->temp_asset }}</td>
  <td>{{ $show->temp_asset_desc }}</td>
  <td>{{ $show->temp_asset_site }}</td>
  <td>{{ $show->temp_asset_loc }}</td>
  <td>{{ $show->temp_asset_locdesc }}</td>
  <td style="text-align: right;">{{ number_format($show->temp_mtbf,2) }}</td>
  <td style="text-align: right;">{{ number_format($show->temp_mttf,2) }}</td>
  <td style="text-align: right;">{{ number_format($show->temp_mtbf,2) }}</td>
  <td style="text-align: right;">{{ number_format($show->temp_mtbf,2) }}</td>
  
  <td>
      <a href="javascript:void(0)" class="viewwo" data-toggle="tooltip" title="View WO" >
        <i class="icon-table fa fa-eye fa-lg"></i></a>
      &ensp;
  </td>
</tr>
@empty
<tr>
  <td colspan="15" style="color:red;">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;" colspan="15">
    {{ $data->appends($_GET)->links() }}
  </td>
</tr>