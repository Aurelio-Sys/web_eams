@forelse($data as $show)
<tr>
    <td>{{$show->asset_code}}</td>
    <td>{{$show->asset_desc}}</td>
    <td>{{$show->asmove_fromsite}}</td>
    <td>{{$show->asmove_fromloc}}</td>
    <td>{{$show->descfrom}}</td>
    <td>{{$show->asmove_tosite}}</td>
    <td>{{$show->asmove_toloc}}</td>
    <td>{{$show->descto}}</td>
    <td>{{ date('d-m-Y',strtotime($show->asmove_date)) }}</td>
    <td>
        <a href="javascript:void(0)" class="viewdata2" id='viewdata' data-toggle="tooltip"  title="View Data" data-target="#viewModal"
        data-asset="{{$show->asset_code}}" data-desc="{{$show->asset_desc}}" 
        data-fromsite="{{$show->asmove_fromsite}}" data-fromloc="{{$show->asmove_fromloc}}" data-descfrom="{{$show->descfrom}}" 
        data-tosite="{{$show->asmove_tosite}}" data-toloc="{{$show->asmove_toloc}}"  data-descto="{{$show->descto}}" 
        data-ddate="{{$show->asmove_date}}" data-note="{{$show->asmove_note}}" >
        <i class="icon-table fa fa-eye fa-lg"></i></a>

        <!-- 2022.12.12 Tidak ada action karena jika akan melakukan prubahan data langsung create movement agar tercatat perubahannya
        <a href="javascript:void(0)" class="editarea2" id='editarea' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
        data-locationid="{{$show->asset_code}}" data-desc="{{$show->asset_code}}" data-site="{{$show->asset_code}}" 
        data-dsite="{{$show->asset_code}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletearea" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-locationid="{{$show->asset_code}}" data-desc="{{$show->asset_code}}" data-site="{{$show->asset_code}}">
            <i class="icon-table fa fa-trash fa-lg"></i></a>
        -->
    </td> 
    
</tr>
@empty
<tr>
    <td colspan="9" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td colspan="9" style="border: none !important;">
    {{ $data->appends($_GET)->links() }}
  </td>
</tr>