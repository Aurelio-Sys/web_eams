{{--  @php($eng = $ds->wo_engineer1)
@if(!is_null($ds->wo_engineer2))
    @php($eng .= ','.$ds->wo_engineer2)
@endif
@if(!is_null($ds->wo_engineer3))
    @php($eng .= ','.$ds->wo_engineer3)
@endif
@if(!is_null($ds->wo_engineer4))
    @php($eng .= ','.$ds->wo_engineer4)
@endif
@if(!is_null($ds->wo_engineer5))
    @php($eng .= ','.$ds->wo_engineer5)
@endif

@php($fc = $ds->wo_failure_code1)
@php($dfc = "")
@if(!is_null($ds->wo_failure_code1) && $ds->wo_failure_code1 != "")
    @php($fcode = $datafn->where('fn_code','=',$ds->wo_failure_code1)->first())
    @php($dfc = $fc.' - '.$fcode->fn_desc."\n")
@endif
@if(!is_null($ds->wo_failure_code2) && $ds->wo_failure_code2 != "")
    @php($fcode = $datafn->where('fn_code','=',$ds->wo_failure_code2)->first())
    @php($dfc .= $ds->wo_failure_code2.' - '.$fcode->fn_desc."\n")
@endif
@if(!is_null($ds->wo_failure_code3) && $ds->wo_failure_code3 != "")
    @php($fcode = $datafn->where('fn_code','=',$ds->wo_failure_code3)->first())
    @php($dfc .= $ds->wo_failure_code3.' - '.$fcode->fn_desc."\n")    
@endif  --}}

@if($ds->wo_type == 'auto')
    @php($tipe = 'PM')
@else
    @php($tipe = 'WO')
@endif

@php($eng = 'eng')
@php($dfc = '-')

<a href="javascript:void(0)" class="viewwo" data-toggle="modal"  title="View WO"  data-target="#viewModal" 
    data-wonbr="{{$ds->wo_number}}" data-srnbr="{{$ds->wo_sr_number}}" 
    data-woasset="{{$ds->wo_asset_code}}" data-schedule="{{$ds->wo_start_date}}" data-duedate="{{$ds->wo_due_date}}"
    data-assdesc="{{$ds->asset_desc}}" data-eng="{{$eng}}" data-dfc="{{$dfc}}" data-creator="{{$ds->wo_createdby}}"
    data-note="{{$ds->wo_note}}" data-startdate="{{$ds->wo_job_startdate}}" data-finishdate="{{$ds->wo_job_finishdate}}"
    data-status="{{$ds->wo_status}}">

    @if($ds->wo_status == 'plan')
        <span class="badge badge-primary">{{$tipe}} : {{$ds->asset_desc}} - {{$eng}}</span>
    @elseif($ds->wo_status == 'started')
        <span class="badge badge-warning">{{$tipe}} : {{$ds->asset_desc}} - {{$eng}}</span>
    @elseif($ds->wo_status == 'open')
        <span class="badge badge-danger">{{$tipe}} : {{$ds->asset_desc}} - {{$eng}}</span>
    @elseif($ds->wo_status == 'finish')
        <span class="badge badge-success">{{$tipe}} : {{$ds->asset_desc}} - {{$eng}}</span>
    @elseif($ds->wo_status == 'closed')
        <span class="badge badge-secondary">{{$tipe}} : {{$ds->asset_desc}} - {{$eng}}</span>
    @else 
        <span class="badge badge-success">{{$tipe}} : {{$ds->asset_desc}} - {{$eng}}</span>
    @endif

</a>