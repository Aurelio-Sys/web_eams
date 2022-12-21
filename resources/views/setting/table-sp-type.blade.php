@forelse($data as $show)
<tr>
    @if ($show->spt_code == "")
        <td>-</td>
    @else
        <td>{{$show->spt_code}}</td>
    @endif

    @if ($show->spt_desc == "")
        <td>-</td>
    @else
        <td>{{$show->spt_desc}}</td>
    @endif
    
    <!--
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
        data-code="{{$show->spt_code}}" data-desc="{{$show->spt_desc}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->spt_code}}" data-desc="{{$show->spt_desc}}">
            <i class="icon-table fa fa-trash fa-lg"></i></a>
    </td>
    -->
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