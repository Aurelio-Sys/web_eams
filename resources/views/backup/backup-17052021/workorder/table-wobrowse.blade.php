@forelse ($data as $show)
<tr style="text-align: center;">
  <td>{{ $show->wo_nbr }}</td>
  <td>{{ $show->asset_desc }}</td>
  <td>{{ date('d-m-Y',strtotime($show->wo_schedule)) }}</td>
  <td>{{ date('d-m-Y',strtotime($show->wo_duedate)) }}</td>
  <td>{{ $show->wo_status }}</td>
  <td>{{$show->wo_priority}}</td>

  <td>{{date('d-m-Y',strtotime($show->wo_created_at))}}</td>
  <td>{{$show->wo_creator}}</td>
  <td>
    <input type="hidden" name='wonbrr' value="{{$show->wo_nbr}}">
    <a href="javascript:void(0)" class="viewwo" data-toggle="tooltip"  title="View WO"  data-wonbr="{{$show->wo_nbr}}" data-srnbr="{{$show->wo_sr_nbr}}" data-woengineer="{{$show->wo_engineer1}}" data-woasset="{{$show->wo_asset}}" data-schedule="{{$show->wo_schedule}}" data-duedate="{{$show->wo_duedate}}"><i class="icon-table fa fa-eye fa-lg"></i></a>
    &ensp;
    @if($show->wo_status == 'open' || $show->wo_status == 'plan')
    <a href="javascript:void(0)" class="editwo2" data-toggle="tooltip"  title="Edit WO"  data-target="#editModal" data-wonbr="{{$show->wo_nbr}}" data-srnbr="{{$show->wo_sr_nbr}}" data-woengineer="{{$show->wo_engineer1}}" data-woasset="{{$show->wo_asset}}" data-schedule="{{$show->wo_schedule}}" data-duedate="{{$show->wo_duedate}}"><i class="icon-table fa fa-edit fa-lg"></i></a>
    &ensp;
    
    @endif
    @if($show->wo_status =='plan' && $usernow[0]->approver == 1)
      
    <a href="javascript:void(0)" class="approvewo" data-toggle="tooltip"  title="Approve WO"  data-target="#approveModal" data-wonbr="{{$show->wo_nbr}}"  data-woengineer="{{$show->wo_engineer1}}" data-woasset="{{$show->wo_asset}}" data-schedule="{{$show->wo_schedule}}" data-duedate="{{$show->wo_duedate}}"><i class="icon-table fa fa-thumbs-up fa-lg"></i></a>
    &ensp;
    @endif
    <!-- @if ($show->wo_status == 'closed')
    <a href="javascript:void(0)" class="reopen"  data-wonbr="{{$show->wo_nbr}}"  data-woengineer="{{$show->wo_engineer1}}" data-woasset="{{$show->wo_asset}}" data-schedule="{{$show->wo_schedule}}" data-duedate="{{$show->wo_duedate}}"><i class="icon-table fa fa-redo fa-lg"></i></a>      
    &ensp;
    @endif -->
    @if ($show->wo_status == 'finish')
    <a href="javascript:void(0)" class="accepting" data-toggle="tooltip"  title="Confirm WO" data-wonbr="{{$show->wo_nbr}}"  data-woengineer="{{$show->wo_engineer1}}" data-woasset="{{$show->wo_asset}}" data-schedule="{{$show->wo_schedule}}" data-duedate="{{$show->wo_duedate}}"><i class="icon-table fas fa-check-double fa-lg"></i></a>      
    &ensp;
    @endif
    

    <a href="{{url('openprint/'.$show->wo_nbr)}}" data-toggle="tooltip"  title="Print WO Requisition" target="_blank" ><i class="icon-table fa fa-print fa-lg"></i></a>
    
    @if($show->wo_status == 'open')
    &ensp;
    <a href="" class="deletewo" data-toggle="modal" data-target="#deleteModal" data-wonbr="{{$show->wo_nbr}}"><i class="icon-table fa fa-trash fa-lg"></i></a>
    
    @endif
    @if($show->wo_status =='closed')
    &ensp;
      <a id="aprint2" target="_blank" href="{{url('openprint2/'.$show->wo_nbr)}}" data-toggle="tooltip"  title="Print Preventive Maintenance" ><i class="icon-table fas fa-sticky-note fa-lg"></i></a>  
    @endif
  </td>
</tr>
@empty
<tr>
  <td colspan="7" style="color:red;">
    <center>No Data Available</center>
  </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;" colspan="7">
    {{ $data->links() }}
  </td>
</tr>