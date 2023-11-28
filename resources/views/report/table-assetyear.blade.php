@forelse($dataasset as $show)
<tr>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
    {{--  <td>{{$show->asset_last_mtc}}</td>  --}}
    {{--  <td>-</td>  --}}
    {{--  <td>{{$show->asset_measure}} - {{$show->asset_cal}}</td>  --}}
    {{--  <td>-</td>  --}}
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
            @php($wotampil = [])

            <!-- menampilkan aktual WO -->
            @foreach($datawo->where('wo_asset_code','=',$show->asset_code) as $do)
                {{--  @php($wotampil = $do->wo_nbr)  --}}
                @if ($do->thnwo == $bulan && $do->blnwo == $count)
                    @php($wotampil[] = $do->wo_type)
                @endif
            @endforeach
            
            <a href="javascript:void(0)" class="view" type="button" data-toggle="tooltip" title="View Service Request"
            data-code="{{$show->asset_code}}" data-codedesc="{{$show->asset_desc}}" data-schbln="{{$count}}"
            data-schthn="{{$bulan}}">
                @if(count($wotampil) == 2)
                    <span class="badge badge-primary">WO & PM</span>
                @else
                    <span class="badge badge-primary">{{ count($wotampil) > 0 ? $wotampil[0] : ""}}</span>
                @endif
            </a>

            <!-- menampilkan PM Planning yang belum confirm -->
            @php($plan = 0)
            @foreach($datapm->where('pmo_asset','=',$show->asset_code) as $dp)
                {{--  @php($wotampil = $do->wo_nbr)  --}}
                @if ($dp->thnwo == $bulan && $dp->blnwo == $count)
                    @php($plan = 1)
                @endif
            @endforeach

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