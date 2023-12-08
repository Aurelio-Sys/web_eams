<!DOCTYPE html>
<html>

<head>
  <title>Work Order </title>
</head>

<body>
  <style type="text/css">
    @page {
      margin: 50px 0px 50px 30px;
    }

    #header {
      position: fixed;
      left: 0px;
      top: -70px;
      right: 0px;
      text-align: center;
    }

    #detail {
      position: fixed;
      left: 0px;
      top: -60px;
      right: 0px;
      text-align: center;
    }

    .pindah {
      display: block;
      page-break-before: always;
    }

    table.minimalistBlack td,
    table.minimalistBlack th {
      border: 0.5px solid #000000;
      vertical-align: center;
      padding-left: 3px;
      padding-right: 3px;
      padding-top: 2px;
    }

    table.minimalistBlack tbody td {
      font-size: 14px;
      word-wrap: break-word;
    }

    table.minimalistBlack {
      width: 816.4px;
      border-spacing: 0px;

    }

    table.borderless td,
    table.borderless th {
      border-top: 0.5px solid #000000;

      border-right: 0.5px solid #000000;
      vertical-align: center;
      /* padding-left: 3px;
      padding-right: 3px;
      padding-top: 2px; */
    }

    table.borderless tbody td {
      font-size: 14px;
      word-wrap: break-word;
    }

    table.borderless {
      width: 816.4px;
      border-spacing: 0px;
    }

    .noborder tr td {
      border: none;
      vertical-align: center;
    }

    th {
      font-weight: bold;
      font-size: 14px;
      text-align: center;
    }
  </style>
  @php($flg = 0)
  @php($batas = 30)
  @php($batasakhir = 0)
  @php($pagenow = 1)

  <!-- Daftar Perubahan 
  A211014 : Ganti nama approver, tadinya yang tampil username, diganti jadi namanya
  B211014 : Tambahin tanggal user acceptance
-->


  <!--------------- INI UNTUK PRINT TEMPLATE --------------->
  @include('service.pdfprint-header')
  <table style="width:733.5px; height:800.5px; margin-bottom:-5cm;border-left:1px solid; border-right:1px solid; border-bottom:1px solid; border-top:0px; padding: 0px 5px 5px 5px; border-top:0" class="borderless">
    <tr>
      <td colspan="1" style="border-left: 2px solid; border-right:0px; border-top:2px solid; width:350px">
        <table style="border-collapse: collapse;margin-left:5px;">
          <tr>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin-top:2px;padding:0;font-size:12px"><b>Failure Type </b>: </p>
            </td>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: 2px; margin-left:6px; font-size:12px;">
                @if($womstr->wo_sr_number != "")
                @if($womstr->wo_failure_type == "" || $womstr->sr_fail_type == "")

                @else
                {{$womstr->sr_fail_type}} -- {{$womstr->wotyp_desc}}
                @endif
                @else($womstr->wo_sr_number == "")
                @if($womstr->wo_failure_type == "")

                @else
                {{$womstr->wo_failure_type}} -- {{$womstr->wotyp_desc}}
                @endif
                @endif
              </p>
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: 0px; font-size:12px;"><b>Failure Code </b>: </p>
            </td>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              @foreach($failurecode as $key => $fcode)
              <p class="fcode" style="margin-top: 0px; margin-left:6px; font-size:12px">
                {{$key + 1}}. {{$fcode['fn_code']}} -- {{$fcode['fn_desc']}}
              </p><br><br>
              @endforeach
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;">
              <p style="margin-top: 0px; font-size:12px"><b>Impact &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>: </p>
            </td>
            <td style="border-top:0px solid;border-right:0px">
              @foreach($impact as $key => $imp)
              <p class="fcode" style="margin-top: 0px; margin-left:6px; font-size:12px">
                {{$key + 1}}. {{$imp['imp_code']}} -- {{$imp['imp_desc']}}
              </p><br><br>
              @endforeach
            </td>
          </tr>
        </table>
      </td>
      <td colspan="2" style="border-left: 0px; border-top:2px solid; border-right: 1.5px solid;">
        <!-- <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">{{$womstr->dept_desc}} -- {{$womstr->eng_desc}}</p> -->
        <table style="border-collapse: collapse;margin-left:5px;">
          <tr>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;" width="100px">
              <p style="margin-top:2px;padding:0;font-size:12px"><b>No. SR / No. WO</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: 2px; font-size:12px;">
                @if($womstr->wo_number == null)
                : {{$womstr->sr_number}} /
                @elseif($womstr->wo_sr_number == '')
                : - / {{$womstr->wo_number}}
                @else
                : {{$womstr->wo_sr_number}} / {{$womstr->wo_number}}
                @endif
              </p>
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;border-collapse: collapse;" width="120px">
              <p style="margin-top: 0px; font-size:12px;"><b>Tgl & Jam SR / WO</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: 0px; font-size:12px">
                
@if($womstr->wo_number == null)
                : {{date('d-m-Y', strtotime($womstr->sr_req_time))}} & {{date('H:i', strtotime($womstr->sr_req_time))}} /
                @elseif($womstr->wo_sr_number == '')
                : - / {{date('d-m-Y', strtotime($womstr->wo_system_create))}} & {{date('H:i', strtotime($womstr->wo_system_create))}}
                @else
                : {{date('d-m-Y', strtotime($womstr->sr_req_time))}} & {{date('H:i', strtotime($womstr->sr_req_time))}} / {{date('d-m-Y', strtotime($womstr->wo_system_create))}} & {{date('H:i', strtotime($womstr->wo_system_create))}}
                @endif
              </p>
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;">
              <p style="margin-top: 2px; font-size:12px"><b>Divisi</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px">
              <p style="margin-top: 2px; font-size:12px">
                @if($womstr->wo_sr_number != "")
                : {{$womstr->sr_dept}} -- {{$womstr->dept_desc}}
                @else
                : {{$womstr->wo_department}} -- {{$womstr->dept_desc}}
                @endif
              </p>
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;">
              <p style="margin-top: 2px; font-size:12px"><b>Nama & No. Mesin &nbsp;</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px;">
              <p style="margin-top: -10px; font-size:12px;line-height: 1.5">
                @if($womstr->wo_sr_number != "")
                : {{$womstr->asset_desc}} & {{$womstr->sr_asset}}
                @else
                : {{$womstr->asset_desc}} -- {{$womstr->wo_asset_code}}
                @endif
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="height: 65px;border-left: 2px solid; border-right:1.5px" colspan="3">
        <p style=" margin-bottom:0px; margin-top:0px; margin-left: 5px; font-size:12px">
          <b><span style="padding-bottom: 0px;border-bottom:1px solid black;">Uraian</span>:</b>
          <br>
          @if($womstr->wo_sr_number != "")
          SR Note: {{$womstr->sr_note}}<br>
          WO Note: {{$womstr->wo_note}}
          @else
          {{$womstr->wo_note}}
          @endif
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="1" style="text-align:center;border-left: 2px solid; border-right:0px; border-top:0.5px solid; border-bottom:2px solid; width:350px">
        <p style=" margin-bottom:5px; margin-top:0px;font-size:12px"><span style="padding-bottom: 0px;border-bottom:1px solid black;">Diusulkan oleh,</span></p>

        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px">
          @if($womstr->wo_sr_number != "")
          {{$womstr->sr_req_by}}
          @else
          {{$womstr->wo_createdby}}
          @endif
        </p>
      </td>
      <td colspan="2" style="text-align:center;border-left: 0px; border-top:0.5px solid; border-right: 1.5px solid; border-bottom:2px solid;">
        <p style=" margin-bottom:5px; margin-top:0px"><span style="padding-bottom: 0px;border-bottom:1px solid black;font-size:12px">Penanggung Jawab,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px">
          {{$engapprover->eng_code}}
        </p>
      </td>
    </tr>
    <tr>
      <td style="border-top:0px; border-right:0px; border-bottom:0px; font-size: 11px; padding:0;" colspan="5">
        <p style="margin-top: 2px; margin-bottom:2px;">
          <b><span style="padding-bottom: 0px;border-bottom:1px solid black;">Diisi oleh Petugas yang Melakukan Pemeriksaan</span></b>
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="1" style="border-left: 2px solid; border-right:0px; border-top:2px solid; width:350px">
        <table style="border-collapse: collapse;margin-left:5px;">
          <tr>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin:0;padding:0;font-size:12px"><span style="padding-bottom: 0px;border-bottom:1px solid black;">Divisi yang melakukan <b>Pemeriksaan</b></span> :</p>
            </td>
          </tr>
          <tr>
            <td style="border-top:0px;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: 0px; font-size:12px">
                {{$spvcheckedby->eng_dept}} -- {{$spvcheckedby->dept_desc}}
              </p>
            </td>
          </tr>
        </table>
      </td>
      <td colspan="2" style="border-left: 0px; border-top:2px solid; border-right: 1.5px solid;">
        <!-- <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">{{$womstr->dept_desc}} -- {{$womstr->eng_desc}}</p> -->
        <table style="border-collapse: collapse;margin-left:5px;margin-top:-1px; margin-bottom:-1px">
          <tr>
            <td style="text-align:center;vertical-align:middle;border:1px solid;width:150px">
              <p style="margin:0;padding:0;font-size:12px">Waktu Pemeriksaan</p>
            </td>
            <td style="text-align:center;vertical-align:middle;border:1px solid;width:100px">
              <p style="margin:0;padding:0;font-size:12px">Mulai dijadwalkan</p>
            </td>
            <td style="text-align:center;vertical-align:middle;border:1px solid;width:100px">
              <p style="margin:0;padding:0;font-size:12px">Batas pemeriksaan</p>
            </td>
          </tr>
          <tr>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
                {{date('d-m-Y', strtotime($womstr->wo_system_create))}}
              </p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
                {{date('d-m-Y', strtotime($womstr->wo_system_create))}}
              </p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
                {{date('d-m-Y', strtotime($womstr->wo_system_create))}}
              </p>
            </td>
          </tr>
          <tr>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
                {{date('H:i', strtotime($womstr->wo_system_create))}}
              </p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px"></p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px"></p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="height: 65px;border-left: 2px solid; border-bottom: 2px solid; border-right:0px; border-top:0.5px" colspan="2">
        <p style=" margin-bottom:0px; margin-top:0px; margin-left: 5px; font-size:12px">
          <span style="padding-bottom: 0px;border-bottom:1px solid black;">Uraian Pemeriksaan</span>:
          <br>
          {{$womstr->wo_note}}
        </p>
      </td>
      <td colspan="1" style="text-align:center;border-left: 0px; border-top:0.5px solid; border-right: 1.5px solid; border-bottom:2px solid;">
        <p style=" margin-bottom:5px; margin-left: 100px; margin-top:0px"><span style="padding-bottom: 0px;border-bottom:1px solid black;font-size:12px">Petugas yang melakukan pemeriksaan,</span></p>
        <p style=" margin-bottom:5px; margin-left: 100px; margin-top:30px;font-size:12px">
          {{$spvcheckedby->eng_code}}
      </td>
    </tr>
    <tr>
      <td style="border-top:0px; border-right:0px; border-bottom:0px; font-size: 11px; padding:0;" colspan="5">
        <p style="margin-top: 2px; margin-bottom:2px;">
          <b><span style="padding-bottom: 0px;border-bottom:1px solid black;">Diisi oleh Petugas yang Melakukan Penyelesaian Job</span></b>
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="1" style="border-left: 2px solid; border-right:0px; border-top:2px solid; width:350px">
        <table style="border-collapse: collapse;margin-left:5px;">
          <tr>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin:0;padding:0;font-size:12px"><span style="padding-bottom: 0px;border-bottom:1px solid black;">Divisi yang melakukan <b>Penyelesaian Job</b></span> :</p>
              <p style="margin:0px;padding:0px;font-size:12px">
	@if($womstr->wo_status != 'canceled')
          {{$spvcheckedby->eng_dept}} -- {{$spvcheckedby->dept_desc}}
	@endif
              </p>
            </td>
          </tr>
          <tr>
          </tr>
        </table>
      </td>
      <td colspan="2" style="border-left: 1px; border-top:2px solid; border-right: 1.5px solid;">
        <!-- <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">{{$womstr->dept_desc}} -- {{$womstr->eng_desc}}</p> -->
        <table style="border-collapse: collapse;margin-left:5px;margin-top:-1px; margin-bottom:-1px">
          <tr>
            <td style="text-align:center;vertical-align:middle;border:1px solid;width:150px">
              <p style="margin:0;padding:0;font-size:12px">Waktu Penyelesaian</p>
            </td>
            <td style="text-align:center;vertical-align:middle;border:1px solid;width:100px">
              <p style="margin:0;padding:0;font-size:12px">Mulai</p>
            </td>
            <td style="text-align:center;vertical-align:middle;border:1px solid;width:100px">
              <p style="margin:0;padding:0;font-size:12px">Selesai</p>
            </td>
          </tr>
          <tr>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">Tanggal</p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
@if($womstr->wo_job_startdate != null)
{{date('d-m-Y', strtotime($womstr->wo_job_startdate))}}
@else
&nbsp;
@endif
              </p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
@if($womstr->wo_job_finishdate != null)
{{date('d-m-Y', strtotime($womstr->wo_job_finishdate))}}
@else
&nbsp;
@endif
              </p>
            </td>
          </tr>
          <tr>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">Jam</p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
@if($womstr->wo_job_starttime != null)
{{date('H:i', strtotime($womstr->wo_job_starttime))}}
@else
&nbsp;
@endif
              </p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
@if($womstr->wo_job_finishtime != null)
{{date('H:i', strtotime($womstr->wo_job_finishtime))}}
@else
&nbsp;
@endif
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="height: 65px;border-left: 2px solid; border-right:1.5px" colspan="3">
        <p style=" margin-bottom:0px; margin-top:0px; margin-left: 5px; font-size:12px">
          <span style="padding-bottom: 0px;border-bottom:1px solid black;">Uraian Penyelesaian Job</span>:
          <br>
          {{$womstr->wo_report_note}}
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="1" style="text-align:center;border-left: 2px solid; border-right:0px; border-top:0.5px solid; border-bottom:2px solid; width:350px">
        <p style=" margin-bottom:5px; margin-top:0px;font-size:12px"><span style="padding-bottom: 0px;border-bottom:1px solid black;">Diselesaikan oleh,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px">
	@if($womstr->wo_status == 'closed' || $womstr->wo_status == 'finished' || $womstr->wo_status == 'acceptance')
          @foreach($engineerlist as $key => $eng)
          {{$eng['eng_code']}},
          @endforeach
	@endif
        </p>
      </td>
      <td colspan="2" style="text-align:center;border-left: 0px; border-top:0.5px solid; border-right: 1.5px solid; border-bottom:2px solid;">
        <p style=" margin-bottom:5px; margin-top:0px"><span style="padding-bottom: 0px;border-bottom:1px solid black;font-size:12px">Penanggung Jawab,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px">
          @if($womstr->wo_status == 'closed' || $womstr->wo_status == 'finished' || $womstr->wo_status == 'acceptance')
          {{$spvcheckedby->eng_code}}
	@endif
        </p>
      </td>
    </tr>
    <!-- SERAH TERIMA -->
    <tr>
      <td style="border-top:0px; border-right:0px; border-bottom:0px; font-size: 11px; padding:0;" colspan="5">
        <p style="margin-top: 2px; margin-bottom:2px;">
          <b><span style="padding-bottom: 0px;border-bottom:1px solid black;">Serah Terima</span></b>
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="3" style="border-left: 2px solid; border-right:1.5px solid; border-top:2px solid; width:350px">
        <table style="border-collapse: collapse;margin-left:5px;">
          <tr>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin:0;padding:0;font-size:12px"><b>Tanggal & Jam Serah Terima</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: 0px; font-size:12px;"> : 
@if($womstr->wo_sr_number != '' && $womstr->wo_status == 'acceptance' && $womstr->wo_status == 'closed')
          {{date('d-m-Y', strtotime($dateuseracc))}} & {{date('H:i', strtotime($dateuseracc))}} 
	@endif
</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="height: 65px;border-left: 2px solid; border-right:1.5px" colspan="3">
        <p style=" margin-bottom:0px; margin-top:0px; margin-left: 5px; font-size:12px">
          <b><span style="padding-bottom: 0px;border-bottom:1px solid black;">Uraian</span>:</b>
          <br>
@if($womstr->wo_sr_number != '' && $womstr->wo_status == 'acceptance' && $womstr->wo_status == 'closed')
          {{$womstr->sr_acceptance_note}}
          @else
          &nbsp; 
	@endif
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="1" style="text-align:center;border-left: 2px solid; border-right:0px; border-top:0.5px solid; border-bottom:2px solid; width:350px">
        <p style=" margin-bottom:5px; margin-top:0px;font-size:12px"><span style="padding-bottom: 0px;border-bottom:1px solid black;">Diserahkan oleh,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px">
@if($womstr->wo_sr_number != '' && $womstr->wo_status == 'acceptance' && $womstr->wo_status == 'closed')
          @foreach($engineerlist as $key => $eng)
          {{$eng['eng_code']}},
          @endforeach
	@endif
</p>
      </td>
      <td colspan="2" style="text-align:center;border-left: 0px; border-top:0.5px solid; border-right: 1.5px solid; border-bottom:2px solid;">
        <p style=" margin-bottom:5px; margin-top:0px"><span style="padding-bottom: 0px;border-bottom:1px solid black;font-size:12px">Diterima oleh,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px">
@if($womstr->wo_sr_number != '' && $womstr->wo_status == 'acceptance' && $womstr->wo_status == 'closed')
          {{$womstr->sr_req_by}} 
	@endif
</p>
      </td>
    </tr>


  </table>

  {{-- @php($pagenow += 1)
  @include('service.pdfprint-header') --}}

  <!-- <table style="width:730px; margin-bottom:-5cm;border:1px solid;" class="borderless">
    <tr>
      <td bgcolor="#bbbbbb" style="text-align:center;" colspan="3">
        <p style=" margin-bottom:5px; margin-top:5px"><b>MACAM PERMINTAAN TINDAKAN PERBAIKAN</b></p>
      </td>
    </tr>
    <tr>
      <th>Pemohon</th>
      <th>Mengetahui</th>
      <th>Menyetujui</th>
    </tr>
    <tr>
      <td style="height: 50px"></td>
      <td style="height: 50px; vertical-align:bottom; text-align:center;">
        <p style=" margin-bottom:0;">Unit Head/Section Head</p>
      </td>
      <td style="height: 50px; vertical-align:bottom; text-align:center;">
        <p style=" margin-bottom:0;">Dept. Head</p>
      </td>
    </tr>
    <tr>
      <td style="height: 15px; border-bottom: 1px solid" colspan="1"></td>
      <td style="height: 15px; border-bottom: 1px solid" colspan="1"></td>
      <td style="height: 15px; border-bottom: 1px solid" colspan="1"></td>
    </tr>
  </table> -->
</body>



</html>
