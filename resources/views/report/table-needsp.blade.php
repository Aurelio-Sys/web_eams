@forelse($data as $show)
<tr>
    <td>{{$show->temp_sch_date}}</td>
    <td>{{$show->temp_sp}}</td>
    <td>{{$show->temp_sp_desc}}</td>
    <td style="text-align: right">{{number_format($show->sumreq,2)}}</td>
    <td style="text-align: center">
        <a href="javascript:void(0)" class="view" type="button" data-toggle="tooltip" title="View Service Request"
            data-sp="{{$show->temp_sp}}" data-spdesc="{{$show->temp_sp_desc}}" data-sch="{{$show->temp_sch_date}}">
            <i class="icon-table far fa-eye fa-lg"></i>
        </a>
    </td>
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