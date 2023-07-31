@php($tipe = $ds->wo_type)

{{--  Mencari data Engineer  --}}
@php($arrayEng = explode(';', $ds->wo_list_engineer))
@foreach($arrayEng as $descEng)
    @php($engDesc = $dataeng->where('eng_code', $descEng)->pluck('eng_desc')->first())

    @if($engDesc)
        @php($eng = isset($eng) ? $eng . " ; " . $engDesc : $engDesc)
    @endif
@endforeach

{{--  Mencari data Lokasi  --}}
@php($loc = $ds->wo_site . ' ; ' . $ds->wo_location . ' -- ' . $ds->asloc_desc)
@php($dfc = '-')

<a href="javascript:void(0)" class="viewwo" data-toggle="modal"  title="View WO"  data-target="#viewModal" 
    data-wonbr="{{$ds->wo_number}}" data-srnbr="{{$ds->wo_sr_number}}" 
    data-woasset="{{$ds->wo_asset_code}}" data-schedule="{{$ds->wo_start_date}}" data-duedate="{{$ds->wo_due_date}}"
    data-assdesc="{{$ds->asset_desc}}" data-eng="{{$eng}}" data-dfc="{{$dfc}}" data-creator="{{$ds->wo_createdby}}"
    data-note="{{$ds->wo_note}}" data-startdate="{{$ds->wo_job_startdate}}" data-finishdate="{{$ds->wo_job_finishdate}}"
    data-status="{{$ds->wo_status}}" data-loc="{{$loc}}">

    @if($ds->wo_status == 'firm')
        <span class="badge badge-primary">{{$tipe}} : {{$ds->asset_desc}} - {{$eng}}</span>
    @elseif($ds->wo_status == 'started')
        <span class="badge badge-success">{{$tipe}} : {{$ds->asset_desc}} - {{$eng}}</span>
    @elseif($ds->wo_status == 'acceptance')
        <span class="badge badge-warning">{{$tipe}} : {{$ds->asset_desc}} - {{$eng}}</span>
    @elseif($ds->wo_status == 'finished')
        <span class="badge badge-warning">{{$tipe}} : {{$ds->asset_desc}} - {{$eng}}</span>
    @elseif($ds->wo_status == 'closed')
        <span class="badge badge-secondary">{{$tipe}} : {{$ds->asset_desc}} - {{$eng}}</span>
    @else 
        <span class="badge badge-success">{{$tipe}} : {{$ds->asset_desc}} - {{$eng}}</span>
    @endif

</a>