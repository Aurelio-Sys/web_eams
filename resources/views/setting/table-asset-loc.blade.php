@forelse($data as $show)
<tr>
    <td>{{$show->asloc_code}}</td>
    <td>{{$show->asloc_desc}}</td>
    <td>{{$show->asloc_site}} - {{$show->assite_desc}}</td>
    
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editarea' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
        data-locationid="{{$show->asloc_code}}" data-desc="{{$show->asloc_desc}}" data-site="{{$show->asloc_site}}" 
        data-dsite="{{$show->assite_desc}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletearea" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-locationid="{{$show->asloc_code}}" data-desc="{{$show->asloc_desc}}" data-site="{{$show->asloc_site}}">
            <i class="icon-table fa fa-trash fa-lg"></i></a>
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
  <td colspan="4" style="border: none !important;">
    {{ $data->appends($_GET)->links() }}
  </td>
</tr>