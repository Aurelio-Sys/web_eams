@forelse ( $data as $datas )
<tr>
    <td>{{ $datas->wo_nbr }}</td>
    <td style="text-align: left;">{{ $datas->asset_code }} -- {{ $datas->asset_desc }}</td>
    <td>{{ $datas->wo_status }}</td>
    <td>{{ $datas->wo_schedule }}</td>
    <td>{{ $datas->wo_duedate }}</td>
    <td>{{ $datas->wo_priority }}</td>
    <td style="text-align: center;">
        <a class="btn btn-info" href="{{route('ReleaseDetail', [$datas->wo_id, $datas->wo_nbr])}}"><i class="fas fa-box-open"></i> Release</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="12" style="color: red;text-align: center;" >No Data Available</td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="7">
        {{ $data->appends($_GET)->links() }}
    </td>
</tr>