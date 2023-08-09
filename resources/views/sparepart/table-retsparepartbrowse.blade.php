@forelse ( $data as $datas )
<tr>
    <td>{{ $datas->ret_sp_number }}</td>
    <td>{{ $datas->ret_sp_wonumber }}</td>
    <td>{{ $datas->ret_sp_return_by }}</td>
    <td>{{ date("d-m-Y", strtotime($datas->created_at)) }}</td>
    <td>{{ $datas->ret_sp_status }}</td>
    <td style="text-align: center;">
    <!-- view -->
        <a class="viewretsp" href="javascript:void(0)" type="button" data-toggle="tooltip" title="View Return Sparepart" 
        data-rsnumber="{{ $datas->ret_sp_number }}" data-wonumber="{{ $datas->ret_sp_wonumber }}" data-retby="{{ $datas->ret_sp_return_by }}" data-crdate="{{ date('d/m/Y', strtotime($datas->created_at)) }}"
        data-trfby="{{ $datas->ret_sp_transfered_by }}" data-trfdate="{{ $datas->ret_sp_transfer_date == '0000-00-00' ? '' : date('m/d/Y', strtotime($datas->ret_sp_transfer_date)) }}" data-status="{{ $datas->ret_sp_status }}"
        data-spcode="{{ $datas->ret_spd_sparepart_code }}" data-spdesc="{{ $datas->spm_desc }}" data-qtyret="{{ $datas->ret_spd_qty_return }}" data-qtytrf="{{ $datas->ret_spd_qty_transfer }}"
        data-locfrom="{{ $datas->ret_spd_loc_from }}" data-locto="{{ $datas->ret_spd_loc_to }}" data-note="{{ $datas->ret_spd_engnote }}" data-cancelnote="{{ $datas->ret_sp_cancelnote }}"><i class="icon-table far fa-eye fa-lg"></i></a>
    <!-- edit -->
        @if($datas->ret_sp_status == 'open' && $datas->ret_sp_return_by == session('username'))
        <a class="editretsp" href="javascript:void(0)" type="button" data-toggle="tooltip" title="Edit Return Sparepart"
        data-rsnumber="{{ $datas->ret_sp_number }}" data-wonumber="{{ $datas->ret_sp_wonumber }}" data-retby="{{ $datas->ret_sp_return_by }}" data-crdate="{{ date('d/m/Y', strtotime($datas->created_at)) }}"
        data-trfby="{{ $datas->ret_sp_transfered_by }}" data-trfdate="{{ $datas->ret_sp_transfer_date == '0000-00-00' ? '' : date('m/d/Y', strtotime($datas->ret_sp_transfer_date)) }}" data-status="{{ $datas->ret_sp_status }}"
        data-spcode="{{ $datas->ret_spd_sparepart_code }}" data-spdesc="{{ $datas->spm_desc }}" data-qtyret="{{ $datas->ret_spd_qty_return }}" data-qtytrf="{{ $datas->ret_spd_qty_transfer }}"
        data-locfrom="{{ $datas->ret_spd_loc_from }}" data-locto="{{ $datas->ret_spd_loc_to }}" data-note="{{ $datas->ret_spd_engnote }}" ><i class="icon-table fa fa-edit fa-lg"></i></a>
        
    <!-- cancel -->
        <a class="cancelretsp" href="javascript:void(0)" type="button" data-toggle="tooltip" title="Cancel Return Sparepart" data-rsnumber="{{ $datas->ret_sp_number }}"><i class="icon-table fas fa-window-close fa-lg"></i></a>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="12" style="color: red;text-align: center;" >No Data Available</td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="7">
        {{ $data->appends($_GET)->links() }}
    </td>
</tr>