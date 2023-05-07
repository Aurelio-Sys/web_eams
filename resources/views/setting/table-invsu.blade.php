@forelse($data as $show)

<tr>
    <td>{{$show->inp_asset_site}} -- {{$show->assite_desc}}</td>
    <td>{{$show->inp_supply_site}} -- {{$show->site_desc}}</td>
    <td>{{$show->inp_loc}} -- {{$show->loc_desc}}</td>
    <td>{{$show->inp_avail}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip" title="Modify Data" data-target="#editModal"
        data-code="{{$show->inp_asset_site}}" data-desc="{{$show->inp_supply_site}}" data-loc="{{$show->inp_loc}}"
        data-dasset="{{$show->assite_desc}}" data-dsource="{{$show->site_desc}}" data-dloc="{{$show->loc_desc}}" 
        data-transid="{{$show->transid}}" data-avail="{{$show->inp_avail}}" >
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->inp_asset_site}}" data-desc="{{$show->inp_supply_site}}" data-loc="{{$show->inp_loc}}"
        data-dasset="{{$show->assite_desc}}" data-dsource="{{$show->site_desc}}" data-dloc="{{$show->loc_desc}}" 
        data-transid="{{$show->transid}}" data-avail="{{$show->inp_avail}}" >
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