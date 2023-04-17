@forelse($data as $show)

<tr>
    <td>{{$show->pmc_code}}</td>
    <td>{{$show->pmc_desc}}</td>
    <td>{{$show->pmc_type}}</td>
    <td>{{$show->pmc_ins}}</td>
    <td>{{$show->pmc_spg}}</td>
    <td>{{$show->pmc_qcs}}</td>
    <td>
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal"
        data-code="{{$show->pmc_code}}" data-desc="{{$show->pmc_desc}}" data-type="{{$show->pmc_type}}"
        data-ins="{{$show->pmc_ins}}" data-spg="{{$show->pmc_spg}}" data-qcs="{{$show->pmc_qcs}}" >
        <i class="icon-table fa fa-edit fa-lg"></i></a>
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->pmc_code}}" data-desc="{{$show->pmc_desc}}">
        <i class="icon-table fa fa-trash fa-lg"></i></a>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" style="color:red">
        <center>No Data Available</center>
    </td>
</tr>
@endforelse
<tr>
  <td style="border: none !important;">
    {{ $data->appends($_GET)->links() }}
  </td>
</tr>