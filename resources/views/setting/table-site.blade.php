@forelse($data as $show)
<tr>
    <td>{{$show->site_code}}</td>
    <td>{{$show->site_desc}}</td>
    <td>{{$show->site_flag}}</td>
    {{--  <td>{{$show->site_flag}}</td>
    
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
        data-sitecode="{{$show->site_code}}" data-desc="{{$show->site_desc}}" data-flag="{{$show->site_flag}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        {{--  &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-sitecode="{{$show->site_code}}" data-desc="{{$show->site_desc}}">
            <i class="icon-table fa fa-trash fa-lg"></i></a> 
    </td>  --}}

</tr>
@empty
<tr>
    <td colspan="12" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;" colspan="2">
    {{ $data->links() }}
  </td>
</tr>