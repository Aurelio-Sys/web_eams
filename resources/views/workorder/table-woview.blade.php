<!-- Daftar Perubahan
  A211103 : file yang didownload bukan hanya berupa gambar
-->
@forelse ($data as $show)
<tr>
  <td>{{ $show->wo_nbr }}</td>
  <td style="text-align: left;">{{ $show->asset_code }}</td>
  <td style="text-align: left;">{{ $show->asset_desc }}</td>
  <td>{{ date('d-m-Y',strtotime($show->wo_schedule)) }}</td>
  <td>{{ date('d-m-Y',strtotime($show->wo_duedate)) }}</td>
  <td>{{ $show->wo_status }}</td>
  {{--  <td>{{$show->wo_priority}}</td>  --}}
  @if($show->wo_type == 'auto')
  <td>PM</td>
  @else
  <td>WO</td>
  @endif
  <td>{{date('d-m-Y',strtotime($show->wo_created_at))}}</td>
  <td>{{$show->wo_creator}}</td>
  <td>
    <a href="javascript:void(0)" class="viewwo" data-toggle="tooltip" title="View WO"  data-wonbr="{{$show->wo_nbr}}" data-srnbr="{{$show->wo_sr_nbr}}" data-woengineer="{{$show->wo_engineer1}}" data-woasset="{{$show->wo_asset}}" data-schedule="{{$show->wo_schedule}}" data-duedate="{{$show->wo_duedate}}"><i class="icon-table fa fa-eye fa-lg"></i></a>
    @if($show->wo_type != 'auto' && $show->wo_status != 'open')
      &nbsp;
      <a href="{{url('openprint/'.$show->wo_nbr)}}" data-toggle="tooltip"  title="Print WO" target="_blank" ><i class="icon-table fa fa-print fa-lg"></i></a>
    @endif
    @if($show->wo_status == 'finish' || $show->wo_status == 'closed')
      &nbsp;  
      <a id="adownload" target="_blank" href="{{url('wodownloadfile/'.$show->wo_nbr)}}" data-toggle="tooltip"  title="Download document" ><i class="icon-table fas fa-download fa-lg"></i></a>  
    @endif

    @php($cfile = $ceksrfile->where('sr_number','=',$show->wo_sr_nbr)->count())
    @if($cfile > 0)
      &nbsp;
      <a id="srdownload" target="_blank" href="{{url('srdownloadfile/'.$show->wo_sr_nbr)}}" data-toggle="tooltip"  title="Download SR document" ><i class="icon-table fas fa-file-export fa-lg"></i></a>  
    @endif
  </td>

</tr>
@empty
<tr>
  <td colspan="11" style="color:red;">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;" colspan="10">
    {{ $data->links() }}
  </td>
</tr>