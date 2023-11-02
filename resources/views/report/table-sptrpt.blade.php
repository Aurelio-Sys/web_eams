@forelse ($data as $show)
<tr>
  <td>{{ $show->temp_spcode }}</td>
  <td>{{ $show->temp_spdesc }}</td>
  <td>{{ $show->temp_fromloc }}</td>
  <td>{{ $show->temp_fromlocdesc }}</td>
  <td>{{ $show->temp_fromlot }}</td>
  <td>{{ $show->temp_toloc }}</td>
  <td>{{ $show->temp_tolocdesc }}</td>
  <td>{{ $show->temp_date }}</td>
  <td>{{ $show->temp_type }}</td>
  <td>{{ $show->temp_no }}</td>
  <td>{{ $show->temp_by }}</td>
  <td>{{ $show->temp_byname }}</td>
  <td>{{ $show->temp_dept }}</td>
  <td>{{ $show->temp_deptdesc }}</td>
  <td>{{ $show->temp_qty }}</td>
  
  
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