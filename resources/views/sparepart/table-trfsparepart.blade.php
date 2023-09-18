@forelse ( $data as $datas )
<tr>
    <td>{{ $datas->req_sp_number }}</td>
    <td>{{ $datas->req_sp_wonumber }}</td>
    <td>{{ $datas->req_sp_requested_by }}</td>
    <td>{{ date("d-m-Y",strtotime($datas->req_sp_due_date)) }}</td>
    <td>{{ $datas->req_sp_status }}</td>
    <td style="text-align: center;">
    @if($datas->req_sp_status != 'closed')
    <a class="btn btn-info" href="{{route('trfspdet', $datas->req_sp_number)}}"><i class="fa fa-check-circle"></i> Confirm</a>
    @else
    <a class="btn btn-secondary viewtrfsp" style="padding: 0.4em 1.2em;" href="javascript:void(0)"
    data-rsnumber="{{ $datas->req_sp_number }}" data-reqby="{{ $datas->req_sp_requested_by }}" data-duedate="{{ $datas->req_sp_due_date == '0000-00-00' ? '' : date('m/d/Y', strtotime($datas->req_sp_due_date)) }}"
    data-trfby="{{ $datas->req_sp_transfered_by }}" data-trfdate="{{ $datas->req_sp_transfer_date == '0000-00-00' ? '' : date('m/d/Y', strtotime($datas->req_sp_transfer_date)) }}" data-status="{{ $datas->req_sp_status }}"
    data-spcode="{{ $datas->req_spd_sparepart_code }}" data-spdesc="{{ $datas->spm_desc }}" data-qtyreq="{{ $datas->req_spd_qty_request }}" data-qtytrf="{{ $datas->req_spd_qty_transfer }}"
    data-locfrom="{{ $datas->req_spd_loc_from }}" data-sitefrom="{{ $datas->req_spd_site_from }}" data-lotfrom="{{ $datas->req_spd_lot_from }}" data-locto="{{ $datas->req_spd_loc_to }}" data-siteto="{{ $datas->req_spd_site_to }}" data-note="{{ $datas->req_spd_note }}"
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