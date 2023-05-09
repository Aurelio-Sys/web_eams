@forelse($data as $show)

@php($qdet = $datadet->where('inp_asset_site','=',$show->inp_asset_site)->where('inp_supply_site','=',$show->inp_supply_site))
@php($stepdesc = "")
@foreach($qdet as $qdet)
  @if($stepdesc == "")
    @php($stepdesc = $qdet->inp_loc)
  @else
    @php($stepdesc = $stepdesc . " , " . $qdet->inp_loc)
  @endif
@endforeach

<tr>
    <td>{{$show->inp_asset_site}} -- {{$show->assite_desc}}</td>
    <td>{{$show->inp_supply_site}} -- {{$show->site_desc}}</td>
    <td>{{$stepdesc}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip" title="Modify Data" data-target="#editModal"
        data-code="{{$show->inp_asset_site}}" data-desc="{{$show->inp_supply_site}}" data-dasset="{{$show->assite_desc}}" 
        data-dsource="{{$show->site_desc}}" >
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->inp_asset_site}}" data-desc="{{$show->inp_supply_site}}" data-dasset="{{$show->assite_desc}}" 
        data-dsource="{{$show->site_desc}}">
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