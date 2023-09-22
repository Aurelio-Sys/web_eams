@forelse ($data as $show)
<tr>
  <td>{{ $show->req_sph_spcode }}</td>
  <td>{{ $show->spm_desc }}</td>
  <td>{{ $show->req_sph_locfrom }}</td>
  <td>{{ $show->req_sph_locfrom }}</td>
  <td>{{ $show->req_sph_lotfrom }}</td>
  <td>{{ $show->req_sph_locto }}</td>
  <td>{{ $show->req_sph_locto }}</td>
  <td>{{ $show->created_at }}</td>
  <td>{{ $show->req_sph_action }}</td>
  <td>{{ $show->req_sph_number }}</td>
  <td>{{ $show->req_sph_qtytrf }}</td>
  
  
  {{--  <td>
      <a href="javascript:void(0)" class="viewwo" data-toggle="tooltip" title="View WO" >
        <i class="icon-table fa fa-eye fa-lg"></i></a>
      &ensp;
  </td>  --}}
</tr>
@empty
<tr>
  <td colspan="5" style="color:red;">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;" colspan="5">
    {{ $data->appends($_GET)->links() }}
  </td>
</tr>