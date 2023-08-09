@switch($dp->pma_mea)
   @case('C')
      @php($pmmea = $dp->pma_mea . ' : ' . $dp->pma_cal ." days")
      @break
   @case('M')
      @php($pmmea = $dp->pma_mea . ' : ' . $dp->pma_meter ." ". $dp->pma_meterum)
      @break
   @case('B')
      @php($pmmea = "C : " . $dp->pma_cal . " days / M : " . $dp->pma_meter ." ". $dp->pma_meterum . "(Both)")
      @break
   @default
      @php($pmmea = "")
@endswitch


@php($assetloc = $dp->asset_site . ' : ' . $dp->asset_loc . ' - ' . $dp->asloc_desc)
@php($pmcode = $dp->pmo_pmcode . ' - ' . $dp->pmc_desc)
@php($qlast = $datalastwo->where('wo_asset_code','=',$dp->pmo_asset)->where('wo_mt_code','=',$dp->pmo_pmcode)->first())
@php($dlastno = $qlast ? $qlast->wo_number . " ( " . $qlast->wo_status . " )" : "")
@php($dlastdate = $qlast ? $qlast->wo_start_date : "")

<a href="javascript:void(0)" class="viewpm" data-toggle="modal"  title="View PM"  data-target="#viewpmModal" 
   data-asset="{{$dp->pmo_asset}}" data-assetdesc="{{$dp->asset_desc}}" data-assetloc="{{$assetloc}}"
   data-eng="{{$dp->pma_eng}}" data-startdate="{{$dp->pmo_sch_date}}" data-duedate="{{$dp->tgl_duedate}}"
   data-pmcode="{{$pmcode}}" data-pmmea="{{$pmmea}}" data-lastno="{{$dlastno}}"
   data-lastdate="{{$dlastdate}}">
   <span class="badge badge-info">Plan : {{$dp->asset_desc}}</span>
</a>