@forelse($data as $show)

<tr>
    <td>{{$show->why_asset}} </td>
    <td>{{$show->why_wo}} </td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip" title="Modify Data" data-target="#editModal"
        data-code="{{$show->why_asset}}" data-desc="{{$show->why_wo}}"  >
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->why_asset}}" data-desc="{{$show->why_wo}}" >
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