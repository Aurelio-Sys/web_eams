@forelse($data as $show)
<tr>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
</tr>
@empty
<tr>
    <td colspan="2" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="2">
        {{ $data->appends($_GET)->links() }}
    </td>
</tr>