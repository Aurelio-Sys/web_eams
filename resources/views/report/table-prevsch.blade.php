@forelse($data as $show)
<tr>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->asset_last_mtc}}</td>
    <td>{{$show->asset_measure}} - {{$show->asset_cal}}</td>
    @foreach (range(1,12) as $count)
        {{--  @php(dd($datatemp))  --}}
        <td style="text-align:center">
            <!-- mencari bulan jadwal Preventive -->
            @foreach($datatemp->where('temp_code','=',$show->asset_code) as $pa)
                @php($bulantampil = '')
                @php($bulan = substr($pa->temp_sch,4,1) == '0' ? substr($pa->temp_sch,5,1) : substr($pa->temp_sch,4,2) )
                @php($tahun = substr($pa->temp_sch,0,4))
                @php($bulantampil = $bulan == $count ? 'PM' : '')
                @if ($tahun == '2022')
                    <span class="badge badge-primary">{{ $bulantampil }}</span>
                @endif
            @endforeach
            <!-- menampilkan aktual WO -->
            @php($wotampil = '')
            @foreach($datawo->where('wo_asset','=',$show->asset_code) as $do)
                @php($wotampil = $do->wo_nbr)
                @if (date('Y',strtotime($do->wo_schedule)) == '2022' && date('n',strtotime($do->wo_schedule)) == $count)
                <span class="badge badge-danger">{{ $wotampil }}</span>
                @endif
            @endforeach
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
  <td colspan="16" style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>