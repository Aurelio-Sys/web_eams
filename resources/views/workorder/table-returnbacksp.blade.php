@forelse ( $data as $datas )
<tr>
    <td style="text-align: center;">{{ $datas->wo_nbr }}</td>
    <td style="text-align: left;">{{ $datas->asset_code }} -- {{ $datas->asset_desc }}</td>
    <td style="text-align: center;">{{ $datas->wo_finish_date }} {{ $datas->wo_finish_time }}</td>
    <td style="text-align: center;">
        <a class="btn btn-info" href="{{route('RBDetail', $datas->wo_nbr)}}"><i class="fas fa-undo-alt"></i></a>
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