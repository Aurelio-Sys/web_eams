@forelse ( $datawo as $do )
<tr>
    <td>{{ $do->wo_nbr }}</td>
    <td>{{ $do->wo_status }}</td>
    <td>{{ $do->wo_schedule }}</td>
    <td>{{ $do->wo_duedate }}</td>
    <td>{{ $do->wo_priority }}</td>
    <td>{{ $do->asset_code }} -- {{ $do->asset_desc }}</td>
    <td>{{ $do->spm_code }} -- {{ $do->spm_desc }}</td>
    <td style="text-align: right">{{ $do->wo_dets_sp_qty }}
    <td style="text-align: right">{{ number_format($do->wo_dets_wh_qty,0) }}
</tr>
@empty
<tr>
    <td colspan="6" style="color: red;" >No Data Available</td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="6">
        {{ $datawo->appends($_GET)->links() }}
    </td>
</tr>