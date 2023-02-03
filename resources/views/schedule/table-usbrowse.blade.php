@forelse($dataus as $show)
<tr>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->us_asset_site}} - {{$show->asloc_desc}}</td>
    <td style="text-align: right">{{number_format($show->asset_meter,0)}}</td>
    <td style="text-align: center">{{$show->us_mea_um}}</td>
    <td>{{date('d-m-Y',strtotime($show->us_date))}}</td>
    <td>{{date('H:i',strtotime($show->us_time))}}</td>
    <td style="text-align: right">{{number_format($show->us_last_mea,0)}}</td>
    <td>{{$show->edited_by}}</td>
    <td>{{date('d-m-Y',strtotime($show->created_at))}}</td>
    <td>{{$show->us_no_pm}}</td>
    
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
        {{ $dataus->appends($_GET)->links() }}
    </td>
</tr>