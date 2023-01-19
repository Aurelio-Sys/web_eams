@forelse ( $data as $datas )
<tr>
    <td>{{ $datas->wo_nbr }}</td>
    <td>{{ $datas->asset_code }} -- {{ $datas->asset_desc }}</td>
    <td>{{ $datas->wo_schedule }}</td>
    <td>{{ $datas->wo_duedate }}</td>
    <td>{{ $datas->wo_priority }}</td>
    <td>
        @if ($data2->where('wo_nbr', $datas->wo_nbr)->where('wo_dets_wh_qx','yes')->count() > 0)
            Partial
        @else
            Not Yet
        @endif
    </td>
    <td style="text-align: center;">
        <a class="btn btn-info" href="{{route('WhsconfDetail', $datas->wo_id)}}"><i class="fa fa-check-circle"></i> Confirm</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" style="color: red;" >No Data Available</td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="6">
        {{ $data->appends($_GET)->links() }}
    </td>
</tr>