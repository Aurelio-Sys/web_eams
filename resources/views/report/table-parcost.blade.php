@forelse ($data as $show)
<tr>
   <td>{{ $show->wo_asset }}</td>
   <td>{{ $show->wo_asset }}</td>
   <td>{{ $show->wo_asset }}</td>
   <td>{{ $show->wo_asset }}</td>
   <td>{{ $show->wo_asset }}</td>
   <td>{{ $show->wo_asset }}</td>
   <td>{{ $show->wo_asset }}</td>
   <td>{{ $show->wo_asset }}</td>
   <td>{{ $show->wo_asset }}</td>
   <td>{{ $show->wo_asset }}</td>
   
   <td>
      <a href="javascript:void(0)" class="viewwo" data-toggle="tooltip" title="View WO" >
        {{--  data-woengineer="{{$show->wo_engineer1}}"  data-duedate="{{$show->wo_duedate}}"--}}
        <i class="icon-table fa fa-eye fa-lg"></i></a>
  </td>
</tr>
@empty
<tr>
  <td colspan="11" style="color:red;">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;" colspan="11">
    {{ $data->appends($_GET)->links() }}
  </td>
</tr>