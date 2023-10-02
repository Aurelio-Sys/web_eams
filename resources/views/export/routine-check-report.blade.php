<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Asset</th>
            <th>QC Spec</th>
            <th>Schedule</th>
            <th>Checker</th>
            <th>Actual Time Check</th>
            <th>Alert Status</th>
            <th>Check Status</th>
            <th>Create Date</th>
            <th>QC Spec Detail</th>
            <th>Result 1</th>
            <th>Result 2</th>
            <th>Check Note</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($routinedata as $show)
        <tr>
            <td>{{$show->id}}</td>
            <td>{{$show->ra_asset_code}} -- {{$show->asset_desc}}</td>
            <td>{{$show->ra_det_qcscode}} -- {{$show->ra_det_qcsdesc}}</td>
            <td>{{$show->ra_schedule_time}}</td>
            <td>{{$show->ra_eng_check}}</td>
            <td>{{$show->ra_actual_check_time}}</td>
            @if ($show->ra_alert_status == 0)
                <td>No</td>                
            @else
                <td>Yes</td>
            @endif

            @if ($show->ra_already_check == 0)
                <td>No</td>                
            @else
                <td>Yes</td>
            @endif

            <td>{{$show->rcm_create_date}}</td>
            <td>{{$show->ra_det_qcsspec}}</td>
            <td>{{$show->ra_det_result1}}</td>
            <td>{{$show->ra_det_result2}}</td>
            <td>{{$show->ra_det_note}}</td>
        </tr>
        @empty
        <tr>
            <td class="text-danger" colspan='12'>
                <center><b>No Data Available</b></center>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>