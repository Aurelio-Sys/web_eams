@forelse($dataasset as $show)
<tr>
    <td>{{$show->asset_code}} aaa</td>
    <td>{{$show->asset_desc}}</td>
    @foreach (range(1,12) as $count)
        <td style="text-align:center">
            @if($plan == 1)
                <span class="badge badge-warning">Plan</span>
            @endif
        </td>
    @endforeach
</tr>
@empty
<tr>
    <td colspan="16" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="16">
        {{ $dataasset->appends($_GET)->links() }}
    </td>
</tr>