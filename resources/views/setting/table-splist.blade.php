@forelse($data as $show)

<tr>
    <td>{{$show->spg_code}}</td>
    <td>{{$show->spg_desc}}</td>
    {{--  <td>{{$show->spg_spcode}} -- {{$show->spm_desc}}</td>
    <td>{{$show->spg_qtyreq}} {{$show->spm_um}}</td>  --}}
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->spg_code}}" data-desc="{{$show->spg_desc}}" data-transid="{{$show->transid}}" >
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->spg_code}}" data-desc="{{$show->spg_desc}}" data-transid="{{$show->transid}}">
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