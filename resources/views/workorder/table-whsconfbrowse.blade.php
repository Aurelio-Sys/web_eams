@forelse ( $data as $datas )
<tr>
    <td>{{ $datas->wo_number }}</td>
    <td>{{ $datas->asset_code }} -- {{ $datas->asset_desc }}</td>
    <td>{{ $datas->wo_start_date }}</td>
    <td>{{ $datas->wo_due_date }}</td>
    <td>{{ $datas->wo_priority }}</td>
    <td style="text-align: center;">
        <a class="btn btn-info" href="{{route('WhsconfDetail', $datas->wo_number)}}"><i class="fa fa-check-circle"></i> Confirm</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" style="color: red; text-align: center;" >No Data Available</td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="6">
        {{ $data->appends($_GET)->links() }}
    </td>
</tr>