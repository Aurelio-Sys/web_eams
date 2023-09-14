@forelse($data as $show)
<tr>
    <td>{{$show->acc_code}}</td>
    <td>{{$show->acc_desc}}</td>
    <td>
        {{--  Tidak ada edit karena data diambil dari QAD, jadi tidak bisa diedit. Karena data harus sama dengan QAD --}}
        <a href="javascript:void(0)" class="deletedata" data-toggle="tooltip"  title="Delete Data" data-target="#deleteModal" 
        data-code="{{$show->acc_code}}" data-desc="{{$show->acc_desc}}">
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