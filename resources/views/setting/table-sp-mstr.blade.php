@forelse($data as $show)

<tr>
    <td>{{$show->spm_code}}</td>
    <td>{{$show->spm_desc}}</td>
    <td>{{$show->spm_um}}</td>
    <td>{{$show->spm_site}} -- {{$show->site_desc}}</td>
    <td>{{$show->spm_loc}} -- {{$show->loc_desc}}</td>
    <td>{{$show->spm_active}}</td>
    <!--
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->spm_code}}" data-desc="{{$show->spm_desc}}" data-price="{{$show->spm_price}}" data-site="{{$show->spm_site}}" 
        data-loc="{{$show->spm_loc}}" data-supp="{{$show->spm_supp}}" data-safety="{{$show->spm_safety}}" 
        data-um="{{$show->spm_um}}" 
        data-lot="{{$show->spm_lot}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal"
        data-code="{{$show->spm_code}}" data-desc="{{$show->spm_desc}}" >
            <i class="icon-table fa fa-trash fa-lg"></i></a>
    </td>
    -->
</tr>
@empty
<tr>
    <td colspan="12" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;" colspan="6">
    {{ $data->links() }}
  </td>
</tr>