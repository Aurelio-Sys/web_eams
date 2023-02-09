@forelse ( $dataApproval as $datas )
<tr>
    <td>{{ $datas->wo_nbr }}</td>
    <td style="text-align: left;">{{ $datas->asset_code }} -- {{ $datas->asset_desc }}</td>
    <td style="text-align: left;">{{ $datas->asset_loc }} -- {{ $datas->asloc_desc }}</td>
    <td style="text-align: center;">{{ $datas->wo_status }}</td>
    <td style="text-align: center;">{{ $datas->wo_priority }}</td>
    <td style="text-align: center;">
        <a class="btn btn-info" href="{{route('woQCDetail', [$datas->wo_id, $datas->wo_nbr])}}"><i class="fa fa-thumbs-up"></i> Approval</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="12" style="color: red;text-align: center;" >No Data Available</td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="7">
        {{ $dataApproval->appends($_GET)->links() }}
    </td>
</tr>