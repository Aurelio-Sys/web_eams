@forelse($data as $show)
<tr>
    <td>{{$show->asgroup_code}}</td>
    <td>{{$show->asgroup_desc}}</td>
    <td>{{$show->wotyp_code}}</td>
    <td>{{$show->wotyp_desc}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editarea' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
        data-asset="{{$show->asgroup_code}}" data-fntype="{{$show->wotyp_code}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletearea" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-asset="{{$show->asgroup_code}}" data-fntype="{{$show->wotyp_code}}">
            <i class="icon-table fa fa-trash fa-lg"></i></a>
    </td>
    
</tr>
@empty
<tr>
    <td colspan="5" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td colspan="5" style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>