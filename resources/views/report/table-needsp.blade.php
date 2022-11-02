@forelse($data as $show)
<tr>
    <td>{{$show->temp_wo}}</td>
    <td>{{$show->temp_sch_date}}</td>
    <td>{{$show->temp_status}}</td>
    <td>{{$show->temp_sp}}</td>
    <td>{{$show->temp_sp_desc}}</td>
    <td style="text-align: right">{{number_format($show->temp_qty_req,2)}}</td>
    <td style="text-align: right">{{number_format($show->temp_qty_whs,2)}}</td>
    <td style="text-align: right">{{number_format($show->temp_qty_need,2)}}</td>
</tr>
@empty
<tr>
    <td colspan="8" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="8">
        {{ $data->appends($_GET)->links() }}
    </td>
</tr>