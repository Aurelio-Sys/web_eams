@forelse($data as $index => $show)
<tr>
    <td>{{$show->part}} -- {{$show->partdesc}}</td>
    <td>{{$show->site}}</td>
    <td>{{$show->loc}} -- {{$show->locdesc}}</td>
    <td>{{$show->lot}}</td>
    <td>{{number_format($show->qtyoh,2)}}</td>
</tr>
@empty
<tr>
    <td colspan="8" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="8">
        {{ $data->appends($_GET)->links() }}
    </td>
</tr>