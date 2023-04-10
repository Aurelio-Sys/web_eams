@forelse($data as $show)

@php($qdet = $detins->where('ins_code','=',$show->ins_code))
@php($stepdesc = "")
@foreach($qdet as $qdet)
  @if($stepdesc == "")
    @php($stepdesc = $qdet->ins_stepdesc)
  @else
    @php($stepdesc = $stepdesc . " , " . $qdet->ins_stepdesc)
  @endif
@endforeach

<tr>
    <td>{{$show->ins_code}}</td>
    <td>{{$show->ins_desc}}</td>
    <td>{{$stepdesc}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->ins_code}}" data-desc="{{$show->ins_desc}}">
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->ins_code}}" data-desc="{{$show->ins_desc}}">
        <i class="icon-table fa fa-trash fa-lg"></i></a>
    </td>
</tr>
@empty
<tr>
    <td colspan="3" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;">
    {{ $data->appends($_GET)->links() }}
  </td>
</tr>