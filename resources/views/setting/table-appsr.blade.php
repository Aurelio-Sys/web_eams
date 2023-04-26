@forelse($data as $show)

@php($qdet = $datadet->where('sr_approver_dept','=',$show->dept_code))
@php($ddesc = "")
@foreach($qdet as $qdet)
  @if($ddesc == "")
    @php($ddesc = $qdet->sr_approver_role)
  @else
    @php($ddesc = $ddesc . " , " . $qdet->sr_approver_role)
  @endif
@endforeach

<tr>
    <td>{{$show->dept_code}}</td>
    <td>{{$show->dept_desc}}</td>
    <td>{{$ddesc}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->dept_code}}" data-desc="{{$show->dept_desc}}" >
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->dept_code}}" data-desc="{{$show->dept_desc}}">
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