@forelse($data as $show)
<tr>
    <td>{{$show->wo_number}}</td>
    <td>{{$show->wo_asset_code}}</td>
    <td>{{$show->asset_loc}}</td>
    <td>{{date('Y-m-d',strtotime($show->wo_system_create))}}</td>
    <td>{{$show->wo_start_date}}</td>
    <td>{{$show->wo_status}}</td>
    <td>{{$show->wd_sp_spcode}}</td>
    <td>{{$show->spm_desc}}</td>
    <td style="text-align: right">{{number_format($show->wd_sp_required,2)}}</td>
    <td style="text-align: right">{{number_format($show->wd_sp_issued,2)}}</td>
    <td style="text-align: right">{{number_format($show->wd_sp_required - $show->wd_sp_issued,2)}}</td>
</tr>
@empty
<tr>
    <td colspan="12" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="12">
        {{ $data->appends($_GET)->links() }}
    </td>
</tr>