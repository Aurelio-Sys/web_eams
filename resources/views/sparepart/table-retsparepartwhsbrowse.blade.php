@forelse ( $data as $datas )
<tr>
    <td>{{ $datas->ret_sp_number }}</td>
    <td>{{ $datas->ret_sp_wonumber }}</td>
    <td>{{ $datas->ret_sp_return_by }}</td>
    <td>{{ date("d-m-Y",strtotime($datas->created_at)) }}</td>
    <td>{{ $datas->ret_sp_status }}</td>
    <td style="text-align: center;">
    @if($datas->ret_sp_status == 'open')
    <a class="btn btn-info" href="{{route('retspwhsdet', $datas->ret_sp_number)}}"><i class="fa fa-check-circle"></i> Confirm</a>
    @else
    <a class="btn btn-secondary viewtrfsp" style="padding: 0.4em 1.2em;" href="javascript:void(0)"
    data-rsnumber="{{ $datas->ret_sp_number }}" data-wonumber="{{ $datas->ret_sp_wonumber }}" data-cancelnote="{{ $datas->ret_sp_cancelnote }}" data-retby="{{ $datas->ret_sp_return_by}}" data-duedate="{{ $datas->created_at == '0000-00-00' ? '' : date('m/d/Y', strtotime($datas->created_at)) }}"
    data-trfby="{{ $datas->ret_sp_transfered_by }}" data-trfdate="{{ $datas->ret_sp_transfer_date == '0000-00-00' ? '' : date('m/d/Y', strtotime($datas->ret_sp_transfer_date)) }}" data-status="{{ $datas->ret_sp_status }}"
    data-spcode="{{ $datas->ret_spd_sparepart_code }}" data-spdesc="{{ $datas->spm_desc }}" data-qtyreq="{{ $datas->ret_spd_qty_return }}" data-qtytrf="{{ $datas->ret_spd_qty_transfer }}"
    data-locfrom="{{ $datas->ret_spd_loc_from }}" data-sitefrom="{{ $datas->ret_spd_site_from }}" data-lotfrom="{{ $datas->ret_spd_lot_to }}" data-locto="{{ $datas->ret_spd_loc_to }}" data-siteto="{{ $datas->ret_spd_site_to }}" data-note="{{ $datas->ret_spd_engnote }}"
    ><i class="fa fa-info-circle"></i> Detail</a>
    @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="7" style="color: red; text-align: center;" >No Data Available</td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="6">
        {{ $data->appends($_GET)->links() }}
    </td>
</tr>