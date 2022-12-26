@forelse($data as $show)
<tr>
    <td>{{$show->pm_type}} -- {{$show->astype_desc}}</td>
    <td>{{$show->pm_group}} -- {{$show->asgroup_desc}}</td>
    <td>{{$show->pm_asset}} -- {{$show->asset_desc}}</td>

    @php($arrayeng = [])
    @if ($show->pm_engcode != "")
    @foreach(explode(';', $show->pm_engcode) as $info) 
        @php($arrayeng[] = $info)
    @endforeach
    @endif

    <td>{{isset($arrayeng[1]) ? $arrayeng[1] : ""}}</td>
    <td>{{isset($arrayeng[2]) ? $arrayeng[2] : ""}}</td>
    <td>{{isset($arrayeng[3]) ? $arrayeng[3] : ""}}</td>
    <td>{{isset($arrayeng[4]) ? $arrayeng[4] : ""}}</td>
    <td>{{isset($arrayeng[5]) ? $arrayeng[5] : ""}}</td>

    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->pm_type}}" data-desc="{{$show->pm_type}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->pm_type}}" data-desc="{{$show->pm_type}}">
            <i class="icon-table fa fa-trash fa-lg"></i></a>
    </td>
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