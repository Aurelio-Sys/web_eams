@if(strpos(Session::get('menu_access'), 'SR01') !== false)
<tr>
    <td>Service Request</td>
    <td>Revise</td>
    <td><a href="/srbrowse?status=Revise">{{ $datasr ? $datasr : 0 }}</a></td>
</tr>
@endif
{{--  <tr>
   <td>Service Request Approval</td>
   <td>Need Approval</td>
   <td>0</td>
</tr>  --}}
@if(strpos(Session::get('menu_access'), 'SR05') !== false)
<tr>
   <td>Service Request Approval Engineer</td>
   <td>Waiting for engineer approval</td>
   <td><a href="/srapprovaleng?status=notif">{{ $datasrappeng ? $datasrappeng : 0 }}</a></td>
</tr>
@endif
@if(strpos(Session::get('menu_access'), 'SR04') !== false)
<tr>
   <td>User Acceptance</td>
   <td>Acceptance</td>
   <td><a href="/useracceptance">{{ $dataaccep ? $dataaccep : 0 }}</a></td>
</tr>
@endif
@if(strpos(Session::get('menu_access'), 'SR04') !== false)
<tr>
   <td>User Acceptance</td>
   <td>Acceptance</td>
   <td>{{ $dataaccep ? $dataaccep : 0 }}</td>
</tr>
@endif
@if(strpos(Session::get('menu_access'), 'WO09') !== false)
<tr>
   <td>Work Order Release</td>
   <td>Firm</td>
   <td><a href="/worelease">{{ $datawofirm ? $datawofirm : 0 }}</a></td>
</tr>
@endif
@if(strpos(Session::get('menu_access'), 'WO10') !== false)
<tr>
   <td>Work Order Release Approval</td>
   <td>waiting for approval</td>
   <td>{{ $dataapprels ? $dataapprels : 0 }}</td>
</tr>
@endif
@if(strpos(Session::get('menu_access'), 'WO07') !== false)
<tr>
   <td>Work Order Transfer</td>
   <td>Need Transfer</td>
   <td>{{ $datawotrans ? $datawotrans : 0 }}</td>
</tr>
@endif
@if(strpos(Session::get('menu_access'), 'WO02') !== false)
<tr>
   <td>Work Order Start</td>
   <td>released</td>
   <td><a href="/wojoblist">{{ $datawostart ? $datawostart : 0 }}</a></td>
</tr>
@endif
@if(strpos(Session::get('menu_access'), 'WO03') !== false)
<tr>
   <td>Work Order Reporting</td>
   <td>started</td>
   <td><a href="/woreport">{{ $datawofinish ? $datawofinish : 0 }}</a></td>
</tr>
@endif
@if(strpos(Session::get('menu_access'), 'WO08') !== false)
<tr>
   <td>Work Order Approval</td>
   <td>waiting for approval</td>
   <td><a href="/woapprovalbrowse?status=notif">{{ $dataappwo ? $dataappwo : 0 }}</a></td>
</tr>
@endif
@if(strpos(Session::get('menu_access'), 'SP03') !== false)
<tr>
   <td>Request Sparepart</td>
   <td>revision</td>
   <td>{{ $datareqsprev ? $datareqsprev : 0 }}</td>
</tr>
@endif
@if(strpos(Session::get('menu_access'), 'SP06') !== false)
<tr>
   <td>Request Sparepart Approval</td>
   <td>waiting for approval</td>
   <td>{{ $datareqspapp ? $datareqspapp : 0 }}</td>
</tr>
@endif
@if(strpos(Session::get('menu_access'), 'SP04') !== false)
<tr>
   <td>Transfer Sparepart</td>
   <td>Need Transfer</td>
   <td>{{ $datareqsptrans ? $datareqsptrans : 0 }}</td>
</tr>
@endif
{{--  @if(strpos(Session::get('menu_access'), 'SR05') !== false)
<tr>
   <td>Return Sparepart</td>
   <td>Need Approval</td>
   <td>0</td>
</tr>
@endif  --}}
@if(strpos(Session::get('menu_access'), 'SP08') !== false)
<tr>
   <td>Return Sparepart Warehouse</td>
   <td>Need Transfer</td>
   <td>{{ $dataretsptrans ? $dataretsptrans : 0 }}</td>
</tr>
@endif