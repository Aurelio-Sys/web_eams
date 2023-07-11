@forelse ($data as $show)
<tr>
    <td>{{ $show->role_code }}</td>
    <td>{{ $show->role_desc }}</td>
    <td>{{ $show->role_access }}</td>
    <td>
        <a href="javascript:void(0)" class="editdata" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
        data-role_code="{{ $show->role_code}} " data-role_desc="{{ $show->role_desc}}" data-role_access="{{ $show->role_access}}">
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        @if ($show->role_code !== 'ADMIN')
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-rolecode="{{$show->role_code}} " data-roledesc="{{ $show->role_desc }}">
        <i class="icon-table fa fa-trash fa-lg"></i></a>
        @endif
        
        
    </td>
</tr>
@empty
<tr>
    <td colspan="4" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>