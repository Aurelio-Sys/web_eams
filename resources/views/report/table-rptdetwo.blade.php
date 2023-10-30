<!-- Daftar Perubahan
  A211103 : file yang didownload bukan hanya berupa gambar
-->
@forelse ($data as $show)
<tr>
  <td>{{ $show->temp_wo }}</td>
  <td>{{ $show->temp_sr }}</td>
  <td style="text-align: left;">{{ $show->temp_asset }}</td>
  <td style="text-align: left;">{{ $show->temp_asset_desc }}</td>
  <td>{{$show->temp_creator}}</td>
  <td>{{$show->temp_type}}</td>
  <td>{{ date('d-m-Y',strtotime($show->temp_create_date)) }}</td>
  <td>{{ date('d-m-Y',strtotime($show->temp_sch_date)) }}</td>
  <td>{{ $show->temp_note }}</td>
  <td>{{ $show->temp_status }}</td>
  <td>{{ $show->temp_sp }} </td>
  <td>{{ $show->temp_sp_desc }}</td>
  <td style="text-align: right;">{{ number_format($show->temp_qty_req,2) }}</td>
  <td style="text-align: right;">{{ number_format($show->temp_qty_whs,2) }}</td>
  
  <td>
      <a href="javascript:void(0)" class="viewwo" data-toggle="tooltip" title="View WO"  data-wonbr="{{$show->temp_wo}}" 
        data-srnbr="{{$show->temp_sr}}"  data-woasset="{{$show->temp_asset}}" 
        data-schedule="{{$show->temp_sch_date}}" >
        {{--  data-woengineer="{{$show->wo_engineer1}}"  data-duedate="{{$show->wo_duedate}}"--}}
        <i class="icon-table fa fa-eye fa-lg"></i></a>
      &ensp;
      {{--  @if($show->wo_type != 'auto' && $show->temp_status != 'open' )
        <a href="{{url('openprint/'.$show->temp_wo)}}" data-toggle="tooltip"  title="Print WO" target="_blank" >
            <i class="icon-table fa fa-print fa-lg"></i></a>
      @endif  --}}
      &ensp;
      @if(($show->temp_status == 'finished' && $show->womaint_wonbr != null) || ($show->temp_status == 'closed' && $show->womaint_wonbr != null))  
        <a id="adownload" target="_blank" href="{{url('wodownloadfile/'.$show->temp_wo)}}" data-toggle="tooltip"  
            title="Download document" ><i class="icon-table fas fa-download fa-lg"></i></a>  
      @endif
  </td>
</tr>
@empty
<tr>
  <td colspan="15" style="color:red;">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;" colspan="15">
    {{ $data->appends($_GET)->links() }}
  </td>
</tr>