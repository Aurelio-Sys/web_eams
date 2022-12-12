@forelse($data as $show)
<tr>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->asmove_fromsite}}</td>
    <td>{{$show->asmove_fromloc}}</td>
    <td>{{$show->asmove_tosite}}</td>
    <td>{{$show->asmove_toloc}}</td>
    <td>{{$show->asmove_date}}</td>
    <!-- 2022.12.12 Tidak ada action karena jika akan melakukan prubahan data langsung create movement agar tercatat perubahannya
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editarea' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
        data-locationid="{{$show->asloc_code}}" data-desc="{{$show->asloc_desc}}" data-site="{{$show->asloc_site}}" 
        data-dsite="{{$show->assite_desc}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletearea" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-locationid="{{$show->asloc_code}}" data-desc="{{$show->asloc_desc}}" data-site="{{$show->asloc_site}}">
            <i class="icon-table fa fa-trash fa-lg"></i></a>
    </td> -->
    
</tr>
@empty
<tr>
    <td colspan="8" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td colspan="8" style="border: none !important;">
    {{ $data->links() }}
  </td>
</tr>