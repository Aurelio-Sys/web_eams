@forelse($data as $show)
<tr>
    <td>{{$show->supp_code}}</td>
    <td>{{$show->supp_desc}}</td>
    <td>
        {{--  Ditutup karena data diambil dari QAD, jadi tidak bisa diedit. Karena data harus sama dengan QAD
        <a href="javascript:void(0)" class="editarea2" id='editdata' data-toggle="tooltip"  title="Modify Data" data-target="#editModal" 
        data-code="{{$show->supp_code}}" data-desc="{{$show->supp_desc}}">
            <i class="icon-table fa fa-edit fa-lg"></i></a>  --}}
        &ensp;
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->supp_code}}" data-desc="{{$show->supp_desc}}">
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