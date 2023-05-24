@forelse ( $data as $datas )
<tr>
    <td>{{ $datas->req_sp_number }}</td>
    <td>{{ $datas->req_sp_requested_by }}</td>
    <td>{{ $datas->req_sp_due_date }}</td>
    <td>{{ $datas->req_sp_status }}</td>
    <td style="text-align: center;">
    <a class="btn btn-info" href="{{route('trfspdet', $datas->req_sp_number)}}"><i class="fa fa-check-circle"></i> Confirm</a>
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