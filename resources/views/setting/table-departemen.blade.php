@forelse($data as $show)
<tr>
    <td>{{$show->dept_code}}</td>
    <td>{{$show->dept_desc}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
        data-code="{{$show->dept_code}}" data-desc="{{$show->dept_desc}}" data-runningnbr="{{$show->dept_running_nbr}}"
        data-cost="{{$show->dept_cc}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->dept_code}}" data-desc="{{$show->dept_desc}}" data-runningnbr="{{$show->dept_running_nbr}}">
            <i class="icon-table fa fa-trash fa-lg"></i></a>
    </td>
</tr>
@empty
<tr>
    <td colspan="12" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>