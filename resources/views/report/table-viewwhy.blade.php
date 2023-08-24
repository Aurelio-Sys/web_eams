@forelse($data as $show)

<tr>
    <td>{{$show->why_asset}} -- {{$show->asset_desc}} </td>
    <td>{{$show->why_wo}} </td>
    <td>{{$show->why_problem}} </td>
    <td>{{$show->why_inputby}} </td>
    <td>{{date('d-m-Y',strtotime($show->created_at))}} </td>
    <td>
        <a href="javascript:void(0)" class="viewdata" data-toggle="tooltip" title="View" 
        data-id="{{$show->id}}" data-asset="{{$show->why_asset}}" data-asset="{{$show->why_wo}}" data-key="{{$show->why_key}}" 
        data-problem="{{$show->why_problem}}" data-why1="{{$show->why_why1}}" data-why2="{{$show->why_why2}}"
        data-why3="{{$show->why_why3}}" data-why4="{{$show->why_why4}}" data-why5="{{$show->why_why5}}" >
          <i class="icon-table fa fa-eye fa-lg"></i></a>
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