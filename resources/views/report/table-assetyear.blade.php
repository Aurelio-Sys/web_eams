@forelse($dataasset as $show)
<tr>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
    {{--  <td>{{$show->asset_last_mtc}}</td>  --}}
    <td>-</td>
    {{--  <td>{{$show->asset_measure}} - {{$show->asset_cal}}</td>  --}}
    <td>-</td>
    @foreach (range(1,12) as $count)
        {{--  @php(dd($datatemp))  --}}
        <td style="text-align:center">
            {{--  <!-- mencari bulan jadwal Preventive -->
            @foreach($datatemp->where('temp_code','=',$show->asset_code) as $pa)
                @php($bulantampil = '')
                @php($bln = substr($pa->temp_sch,4,1) == '0' ? substr($pa->temp_sch,5,1) : substr($pa->temp_sch,4,2) )
                @php($tahun = substr($pa->temp_sch,0,4))
                @php($bulantampil = $bln == $count ? 'PM' : '')
                @if ($tahun == $bulan)
                <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
                data-code="{{$bulantampil}}">
                <span class="badge badge-primary">{{ $bulantampil }}</span></a>
                    
                @endif
            @endforeach  --}}
            <!-- menampilkan aktual WO -->
            @php($wotampil = [])
            @foreach($datawo->where('wo_asset','=',$show->asset_code) as $do)
                {{--  @php($wotampil = $do->wo_nbr)  --}}
                @if ($do->thnwo == $bulan && $do->blnwo == $count)
                    @if($do->wo_type == "auto")
                        @php($wotampil[] = "PM")
                    @else
                        @php($wotampil[] = "WO")
                    @endif
                @endif
            @endforeach
            @php($wotampil = array_unique($wotampil))
            @if(count($wotampil) == 2)
                <span class="badge badge-primary">WO & PM</span>
            @else
                <span class="badge badge-primary">{{ count($wotampil) > 0 ? $wotampil[0] : ""}}</span>
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