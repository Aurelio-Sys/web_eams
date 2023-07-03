<!--
  Daftar Perubahan :
  A210928 : reportnya hanya 1 icon, dibedakan berdasarkan type wo nya saja
  A211019 : jika status reviewer Incomplete, maka tidak akan merubah status apapun di SR. Reviewer dapat melakukan complete WO ulang
  A211101 : perubahan nama status incomplete menjadi reprocess pada approval spv
-->
@forelse ($data as $show)
<tr>
  <td>{{ $show->wo_number }}</td>
  <td style="text-align: left; width: 300px !important;">{{ $show->asset_code }}</td>
  <td style="text-align: left; width: 50% !important;">{{ $show->asset_desc }}</td>
  <td>{{ $show->wo_start_date }}</td>
  <td>{{ $show->wo_due_date }}</td>
  <td>{{ $show->wo_status }}</td>
  @if($show->wo_type == 'PM')
    <td>PM</td>
  @else
    <td>CM</td>
  @endif
  <td>{{ $show->wo_system_create }}</td>
  <td>{{$show->wo_createdby}}</td>
  <td>
    <a href="javascript:void(0)" class="viewwo" data-toggle="tooltip"  title="View WO" data-wonumber="{{$show->wo_number}}" data-srnumber="{{$show->wo_sr_number}}">
      <i class="icon-table fa fa-eye fa-lg"></i>
    </a>
    @if ( $show->wo_status !== 'closed' && $show->wo_status !== 'canceled' )
    <a href="javascript:void(0)" class="editwo2" data-toggle="tooltip"  title="Edit WO"  data-target="#editModal" data-wonumber="{{$show->wo_number}}" data-status="{{$show->wo_status}}" data-wotype="{{$show->wo_type}}">
      <i class="icon-table fa fa-edit fa-lg"></i>
    </a>
    @endif

    @if($show->wo_status == 'firm' || $show->wo_status == 'released')
    <a href="" class="deletewo" data-toggle="modal" data-toggle="tooltip" title="Cancel WO" data-target="#deleteModal" data-wonumber="{{$show->wo_number}}" data-wostatus="{{$show->wo_status}}" data-srnumber="{{$show->wo_sr_number}}"><i class="fas fa-window-close fa-lg"></i></a>
    @endif

  </td>
</tr>
@empty
<tr>
  <td colspan="12" style="color:red;">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;" colspan="10">
    {{$data->appends($_GET)->onEachSide(4)->links()}}
  </td>
</tr>