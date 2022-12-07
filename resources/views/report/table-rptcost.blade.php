@forelse($data as $show)
<tr>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->asset_loc}}</td>
    @foreach (range(1,12) as $count)
        <td style="text-align:center">
            <!-- mencari bulan jadwal Preventive -->
            @foreach($datatemp->where('temp_code','=',$show->asset_code) as $pa)
                @php($bulantampil = '')
                @php($bln = $pa->temp_bln )
                @php($tahun = $pa->temp_thn)
                @php($bulantampil = $bln == $count ? $pa->temp_cost : '')
                @if ($tahun == $bulan)
                    <span class="badge badge-primary">{{ $bulantampil }}</span>
                @endif
            @endforeach
        </td>
    @endforeach
</tr>
@empty
<tr>
    <td colspan="15" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="15">
        {{ $data->appends($_GET)->links() }}
    </td>
</tr>