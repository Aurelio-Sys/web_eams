@forelse ( $data as $datas )
<tr>
    <td>{{ $datas->req_sp_number }}</td>
    <td>{{ $datas->req_sp_wonumber }}</td>
    <td>{{ $datas->req_sp_requested_by }}</td>
    <td>{{ date("d-m-Y", strtotime($datas->req_sp_due_date)) }}</td>
    <td>{{ $datas->req_sp_status }}</td>
    <td style="text-align: center;">
        <!-- approval -->
        @if($datas->getCurrentApprover != null)
        @if($datas->getCurrentApprover->rqtr_role_approval == session('role') || session('role') == 'ADMIN')
        <a class="approvalreqsp" href="javascript:void(0)" type="button" data-toggle="tooltip" title="Approval Request Sparepart" data-rsnumber="{{ $datas->req_sp_number }}" data-wonumber="{{ $datas->req_sp_wonumber }}" data-reqby="{{ $datas->req_sp_requested_by }}" data-duedate="{{ $datas->req_sp_due_date == '0000-00-00' ? '' : $datas->req_sp_due_date }}" data-trfby="{{ $datas->req_sp_transfered_by }}" data-trfdate="{{ $datas->req_sp_transfer_date == '0000-00-00' ? '' : date('m/d/Y', strtotime($datas->req_sp_transfer_date)) }}" data-status="{{ $datas->req_sp_status }}" data-spcode="{{ $datas->req_spd_sparepart_code }}" data-spdesc="{{ $datas->spm_desc }}" data-qtyreq="{{ $datas->req_spd_qty_request }}" data-qtytrf="{{ $datas->req_spd_qty_transfer }}" data-locfrom="{{ $datas->req_spd_loc_from }}" data-locto="{{ $datas->req_spd_loc_to }}" data-note="{{ $datas->req_spd_note }}"><i class="icon-table fas fa-thumbs-up fa-lg"></i></a>
        @else
        <!-- view -->
        <a class="viewreqsp" href="javascript:void(0)" type="button" data-toggle="tooltip" title="View Request Sparepart" data-rsnumber="{{ $datas->req_sp_number }}" data-wonumber="{{ $datas->req_sp_wonumber }}" data-reqby="{{ $datas->req_sp_requested_by }}" data-duedate="{{ $datas->req_sp_due_date == '0000-00-00' ? '' : date('m/d/Y', strtotime($datas->req_sp_due_date)) }}" data-trfby="{{ $datas->req_sp_transfered_by }}" data-trfdate="{{ $datas->req_sp_transfer_date == '0000-00-00' ? '' : date('m/d/Y', strtotime($datas->req_sp_transfer_date)) }}" data-status="{{ $datas->req_sp_status }}" data-spcode="{{ $datas->req_spd_sparepart_code }}" data-spdesc="{{ $datas->spm_desc }}" data-qtyreq="{{ $datas->req_spd_qty_request }}" data-qtytrf="{{ $datas->req_spd_qty_transfer }}" data-locfrom="{{ $datas->req_spd_loc_from }}" data-locto="{{ $datas->req_spd_loc_to }}" data-note="{{ $datas->req_spd_note }}"><i class="icon-table far fa-eye fa-lg"></i></a>
        @endif
        @endif
        <a href="javascript:void(0)" class="route" data-rsnumber="{{ $datas->req_sp_number }}" data-wonumber="{{ $datas->req_sp_wonumber }}" data-reqby="{{ $datas->req_sp_requested_by }}" data-duedate="{{ $datas->req_sp_due_date == '0000-00-00' ? '' : date('m/d/Y', strtotime($datas->req_sp_due_date)) }}">
            <i class="icon-table fa fa-info-circle fa-lg"></i></a>
    </td>
</tr>
@empty
<tr>
    <td colspan="12" style="color: red;text-align: center;">No Data Available</td>
</tr>
@endforelse
<tr>
    <td style="border: none !important;" colspan="7">
        {{ $data->appends($_GET)->links() }}
    </td>
</tr>