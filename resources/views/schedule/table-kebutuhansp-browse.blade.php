@forelse ( $datawo as $do )
<tr>
    <td>{{ $do->wo_number }}</td>
    <td>{{ $do->wo_status }}</td>
    <td>{{ $do->wo_start_date }}</td>
    <td>{{ $do->wo_due_date }}</td>
    <td>{{ $do->wo_priority }}</td>
    <td>{{ $do->asset_code }} -- {{ $do->asset_desc }}</td>
    <td>{{ $do->spm_code }} -- {{ $do->spm_desc }}</td>
    <td>{{ $do->spm_code }} -- {{ $do->spm_desc }}</td>
    <td style="text-align: right"></td>
    <td style="text-align: right"></td>
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