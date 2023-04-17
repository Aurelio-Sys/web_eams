@forelse($data as $show)

@php($qeng = $datadet->where('egr_code','=',$show->egr_code))
@php($eng = "")
@foreach($qeng as $qeng)
  @if($eng == "")
    @php($eng = $qeng->egr_eng . " (" . $qeng->eng_desc . ") ")
  @else
    @php($eng = $eng . " , " . $qeng->egr_eng . " (" . $qeng->eng_desc . ") ")
  @endif
@endforeach

<tr>
    <td>{{$show->egr_code}}</td>
    <td>{{$show->egr_desc}}</td>
    <td>{{$eng}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->egr_code}}" data-desc="{{$show->egr_desc}}">
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->egr_code}}" data-desc="{{$show->egr_desc}}">
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