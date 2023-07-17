<!--
  Daftar Perubahan :
  11 Juli 2023 : berubah mengikuti wo maintenance, tapi hanya ada fungsi view
-->
@forelse ($data as $show)
<tr>
  <td>{{ $show->wo_number }}</td>
  @if ($show->wo_sr_number != "")
    <td>{{ $show->wo_sr_number }}</td>
  @else
  <td>-</td>
  @endif
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
  <td>{{$show->name}}</td>
  <td>
    <a href="javascript:void(0)" class="viewwo" data-toggle="tooltip"  title="View WO" data-wonumber="{{$show->wo_number}}" data-srnumber="{{$show->wo_sr_number}}">
      <i class="icon-table fa fa-eye fa-lg"></i>
    </a>
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