<!DOCTYPE html>
<html>

<head>
  <title>Work Order Requisition </title>
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
              <p style="margin:0;padding:0;font-size:12px"><b>Failure Type </b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: 0px; font-size:12px;">
                : @if($datasr != null)
                {{$datasr->sr_wotype}} -- {{$datasr->wotyp_desc}}
                @else
                {{$womstr->wo_new_type}} -- {{$womstr->wotyp_desc}}
                @endif
              </p>
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: -2px; font-size:12px;"><b>Failure Code &nbsp;</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              : @if($womstr->wo_failure_code1 != null)
              <p class="fcode" style="margin-top: -3px; margin-left:6px; font-size:12px">
                - {{$womstr->wo_failure_code1}}
              </p><br>
              @endif
              &nbsp; @if($womstr->wo_failure_code2 != null)
              <p style="margin-top: -3px; margin-left:6px; font-size:12px">
                - {{$womstr->wo_failure_code2}}
              </p><br>
              @endif
              &nbsp; @if($womstr->wo_failure_code3 != null)
              <p style="margin-top: -3px; margin-left:6px; font-size:12px">
                - {{$womstr->wo_failure_code3}}
              </p><br>
              @endif
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;">
              <p style="margin-top: 0px; font-size:12px"><b>Impact</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px">
              <p style="margin-top: 0px; font-size:12px">
                : @if (strlen($womstr->wo_impact) > 11)
                <?php
                $imp = explode(';', $womstr->wo_impact);
                $impc = $impact->where('imp_code', '=', $imp[0]);
                $impc1 = $impact->where('imp_code', '=', $imp[1]);
                $impc2 = $impact->where('imp_code', '=', $imp[2]);
                ?>
                @foreach($impc as $impct)
                {{$impct->imp_desc}},
                @endforeach
                @foreach($impc1 as $impct)
                {{$impct->imp_desc}},
                @endforeach
                @foreach($impc2 as $impct)
                {{$impct->imp_desc}}
                @endforeach
                @elseif (strlen($womstr->wo_impact) >= 6)
                <?php
                $imp = explode(';', $womstr->wo_impact);
                $impc = $impact->where('imp_code', '=', $imp[0]);
                $impc1 = $impact->where('imp_code', '=', $imp[1]);
                ?>
                @foreach($impc as $impct)
                {{$impct->imp_desc}},
                @endforeach
                @foreach($impc1 as $impct)
                {{$impct->imp_desc}}
                @endforeach
                @else
                {{$womstr->wo_impact_desc}}
                @endif
              </p>
            </td>
          </tr>
        </table>
      </td>
      <td colspan="2" style="border-left: 0px; border-top:2px solid; border-right: 1.5px solid;">
        <!-- <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">{{$womstr->wo_dept}}</p> -->
        <table style="border-collapse: collapse;margin-left:5px;">
          <tr>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin:0;padding:0;font-size:12px"><b>No. SR / WO</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: 0px; font-size:12px;">
                @if($womstr->wo_sr_nbr != null)
                : {{$datasr->sr_number}} / {{$womstr->wo_nbr}}
                @else
                : - / {{$womstr->wo_nbr}}
                @endif</p>
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: -2px; font-size:12px;"><b>Tanggal & Jam SR / WO </b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: -2px; font-size:12px">
                @if($womstr->wo_sr_nbr != null)
                : {{date('d-m-y', strtotime($datasr->sr_created_at))}} & {{date('H:i', strtotime($datasr->sr_created_at))}} / {{date('d-m-y', strtotime($womstr->wo_created_at))}} & {{date('H:i', strtotime($womstr->wo_created_at))}}
                @else
                : - / {{date('d-m-y', strtotime($womstr->wo_created_at))}} & {{date('H:i', strtotime($womstr->wo_created_at))}}
                @endif
              </p>
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;">
              <p style="margin-top: 0px; font-size:12px"><b>Divisi</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px">
              <p style="margin-top: 0px; font-size:12px">: {{$womstr->wo_dept}} -- {{$womstr->dept_desc}}</p>
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;">
              <p style="margin-top: 0px; font-size:12px"><b>Nama & No. Mesin &nbsp;</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px">
              <p style="margin-top: 0px; font-size:12px">: {{$womstr->asset_desc}} & {{$womstr->wo_asset}}</p>
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
          @if($womstr->wo_sr_nbr != null)
          {{$datasr->sr_note}}
          @else
          {{$womstr->wo_note}}
          @endif
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="1" style="text-align:center;border-left: 2px solid; border-right:0; border-top:0.5px solid; border-bottom:2px solid; width:350px">
        <p style=" margin-bottom:5px; margin-top:0px;font-size:12px"><span style="padding-bottom: 0px;border-bottom:1px solid black;">Diusulkan oleh,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px">
          @if($womstr->wo_sr_nbr != null)
          {{$datasr->req_by}}
          @else
          &nbsp;
          @endif
        </p>
      </td>
      <td colspan="2" style="text-align:center;border-left: 0px; border-top:0.5px solid; border-right: 1.5px solid; border-bottom:2px solid;">
        <p style=" margin-bottom:5px; margin-top:0px"><span style="padding-bottom: 0px;border-bottom:1px solid black;font-size:12px">Penanggung Jawab,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px">
          @if($womstr->wo_sr_nbr != null)
          {{$datasr->sr_approver}}
          @else
          &nbsp;
          @endif
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
                <?php
                $dept_appr = $dept->where('dept_code', '=', $womstr->dept_user);
                ?>
                @foreach($dept_appr as $dept)
                {{$dept->dept_desc}} --
                @endforeach
                @if($womstr->wo_sr_nbr != null)
                {{$datasr->sr_approver}}
                @else
                &nbsp;
                @endif
              </p>
            </td>
          </tr>
        </table>
      </td>
      <td colspan="2" style="border-left: 0px; border-top:2px solid; border-right: 1.5px solid;">

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
              <p style="margin:0;padding:0;font-size:12px">{{date('d/m/Y', strtotime($womstr->wo_created_at))}}</p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">{{date('d/m/Y', strtotime($womstr->wo_schedule))}}</p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">{{date('d/m/Y', strtotime($womstr->wo_duedate))}}</p>
            </td>
          </tr>
          <tr>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">{{date('H:i', strtotime($womstr->wo_created_at))}}</p>
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
        <p style=" margin-bottom:5px; margin-left: 100px; margin-top:30px;font-size:12px"></p>
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
              @if($engineerlist->eng1 != null)
              <p style="margin:0px;padding:0px;font-size:12px">{{$engineerlist->eng1}}</p>
              @endif
              @if($engineerlist->eng2 != null)
              <p style="margin:0px;padding:0px;font-size:12px">{{$engineerlist->eng2}}</p>
              @endif
              @if($engineerlist->eng3 != null)
              <p style="margin:0px;padding:0px;font-size:12px">{{$engineerlist->eng3}}</p>
              @endif
              @if($engineerlist->eng4 != null)
              <p style="margin:0px;padding:0px;font-size:12px">{{$engineerlist->eng4}}</p>
              @endif
              @if($engineerlist->eng5 != null)
              <p style="margin:0px;padding:0px;font-size:12px">{{$engineerlist->eng5}}</p>
              @endif
            </td>
          </tr>
          <tr>
          </tr>
        </table>
      </td>
      <td colspan="2" style="border-left: 1px; border-top:2px solid; border-right: 1.5px solid;">
        <!-- <p style="margin-left:5px; margin-bottom:5px; margin-top:5px"></p> -->
        <table style="border-collapse: collapse;margin-left:5px;margin-top:-3px; margin-bottom:-1.5px">
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
                @if($womstr->wo_start_date != null)
                {{date('d/m/Y', strtotime($womstr->wo_start_date))}}
                @else
                &nbsp;
                @endif
              </p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
                @if($womstr->wo_finish_date != null)
                {{date('d/m/Y', strtotime($womstr->wo_finish_date))}}
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
                @if($womstr->wo_start_time != null)
                {{date('H:i', strtotime($womstr->wo_start_time))}}
                @else
                &nbsp;
                @endif
              </p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
                @if($womstr->wo_start_time != null)
                {{date('H:i', strtotime($womstr->wo_finish_time))}}
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
          {{$womstr->wo_approval_note}}
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="1" style="text-align:center;border-left: 2px solid; border-right:0px; border-top:0.5px solid; border-bottom:2px solid; width:350px">
        <p style=" margin-bottom:5px; margin-top:0px;font-size:12px"><span style="padding-bottom: 0px;border-bottom:1px solid black;">Diselesaikan oleh,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px"></p>
      </td>
      <td colspan="2" style="text-align:center;border-left: 0px; border-top:0.5px solid; border-right: 1.5px solid; border-bottom:2px solid;">
        <p style=" margin-bottom:5px; margin-top:0px"><span style="padding-bottom: 0px;border-bottom:1px solid black;font-size:12px">Penanggung Jawab,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px">{{$womstr->wo_approver}}</p>
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
              <p style="margin-top: 0px; font-size:12px;">:</p>
            </td>
          </tr>
        </table>
      </td>s
    </tr>
    <tr>
      <td style="height: 65px;border-left: 2px solid; border-right:1.5px" colspan="3">
        <p style=" margin-bottom:0px; margin-top:0px; margin-left: 5px; font-size:12px">
          <b><span style="padding-bottom: 0px;border-bottom:1px solid black;">Uraian</span>:</b>
          <br>

        </p>
      </td>
    </tr>
    <tr>
      <td colspan="1" style="text-align:center;border-left: 2px solid; border-right:0px; border-top:0.5px solid; border-bottom:2px solid; width:350px">
        <p style=" margin-bottom:5px; margin-top:0px;font-size:12px"><span style="padding-bottom: 0px;border-bottom:1px solid black;">Diserahkan oleh,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px"></p>
      </td>
      <td colspan="2" style="text-align:center;border-left: 0px; border-top:0.5px solid; border-right: 1.5px solid; border-bottom:2px solid;">
        <p style=" margin-bottom:5px; margin-top:0px"><span style="padding-bottom: 0px;border-bottom:1px solid black;font-size:12px">Diterima oleh,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px"></p>
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