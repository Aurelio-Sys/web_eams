@forelse($dataasset as $show)
<tr>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->asloc_desc}}</td>
    @foreach (range(1,12) as $count)
      @if($show->tahun == $bulan && $show->bulan == $count)
         <td style="text-align:center">
            <span class="badge badge-warning">Renew</span>
         </td>
      @else
         <td style="text-align:center">
            <span class="badge badge-warning"></span>
         </td>
      @endif
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