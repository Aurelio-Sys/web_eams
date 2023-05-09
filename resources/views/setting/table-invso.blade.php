@forelse($data as $show)

<tr>
    <td>{{$show->inc_asset_site}} -- {{$show->assite_desc}} </td>
    <td>{{$show->inc_source_site}} -- {{$show->site_desc}}</td>
    <td>{{$show->inc_loc}} -- {{$show->loc_desc}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->inc_asset_site}}" data-desc="{{$show->inc_source_site}}" data-loc="{{$show->inc_loc}}"
        data-dasset="{{$show->assite_desc}}" data-dsource="{{$show->site_desc}}" data-dloc="{{$show->loc_desc}}" 
        data-incid="{{$show->incid}}" >
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->inc_asset_site}}" data-desc="{{$show->inc_source_site}}" data-loc="{{$show->inc_loc}}"
        data-dasset="{{$show->assite_desc}}" data-dsource="{{$show->site_desc}}" data-dloc="{{$show->loc_desc}}" 
        data-incid="{{$show->incid}}" >
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