<!DOCTYPE html>
<html>

<head>
  <title>Service Request Requisition </title>
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
              <p style="margin-top: 0px; font-size:12px;">: {{$srmstr->sr_wotype}} -- {{$srmstr->wotyp_desc}}</p>
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: -2px; font-size:12px;"><b>Failure Code &nbsp;</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              : @if($srmstr->fn1 != null)
              <p class="fcode" style="margin-top: -3px; margin-left:6px; font-size:12px">
                - {{$srmstr->fn1}}
              </p><br>
              @endif
              &nbsp; @if($srmstr->fn2 != null)
              <p style="margin-top: -3px; margin-left:6px; font-size:12px">
                - {{$srmstr->fn2}}
              </p><br>
              @endif
              &nbsp; @if($srmstr->fn3 != null)
              <p style="margin-top: -3px; margin-left:6px; font-size:12px">
                - {{$srmstr->fn3}}
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
                : @if (strlen($srmstr->sr_impact) > 11)
                <?php
                $imp = explode(',', $srmstr->sr_impact);
                $impc = $impact->where('imp_code', '=', $imp[0]);
                $impc1 = $impact->where('imp_code', '=', $imp[1]);
                $impc2 = $impact->where('imp_code', '=', $imp[2]);
                // dd(strlen($srmstr->sr_impact));
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
                @elseif (strlen($srmstr->sr_impact) >= 6)
                <?php
                $imp = explode(',', $srmstr->sr_impact);
                $impc = $impact->where('imp_code', '=', $imp[0]);
                $impc1 = $impact->where('imp_code', '=', $imp[1]);
                ?>
                @foreach($impc as $impct)
                {{$impct->imp_desc}},
                @endforeach
                @foreach($impc1 as $impct)
                {{$impct->imp_desc}},
                @endforeach
                @else
                {{$srmstr->imp_desc}}
                @endif
              </p>
            </td>
          </tr>
        </table>
      </td>
      <td colspan="2" style="border-left: 0px; border-top:2px solid; border-right: 1.5px solid;">
        <!-- <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">{{$srmstr->dept_desc}} -- {{$srmstr->eng_desc}}</p> -->
        <table style="border-collapse: collapse;margin-left:5px;">
          <tr>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin:0;padding:0;font-size:12px"><b>No. SR / No. WO </b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: 0px; font-size:12px;">
                @if($womstr != null)
                : {{$srmstr->sr_number}} / {{$womstr->wo_nbr}}
                @else
                : {{$srmstr->sr_number}} /
                @endif
              </p>
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: -2px; font-size:12px;"><b>Tanggal & Jam SR / WO</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px;border-collapse: collapse;">
              <p style="margin-top: -2px; font-size:12px">
                @if($womstr != null)
                : {{$srmstr->sr_date}} & {{date('H:i', strtotime($srmstr->sr_time))}} / {{date('d-m-y', strtotime($womstr->wo_created_at))}} & {{date('H:i', strtotime($womstr->wo_created_at))}}
                @else
                : {{$srmstr->sr_date}} & {{date('H:i', strtotime($srmstr->sr_time))}} /
                @endif
              </p>
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;">
              <p style="margin-top: 0px; font-size:12px"><b>Divisi</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px">
              <p style="margin-top: 0px; font-size:12px">: {{$srmstr->sr_dept}}</p>
            </td>
          </tr>
          <tr style="line-height: 2px;">
            <td style="border-top:0px;border-right:0px;">
              <p style="margin-top: 0px; font-size:12px"><b>Nama & No. Mesin &nbsp;</b></p>
            </td>
            <td style="border-top:0px solid;border-right:0px">
              <p style="margin-top: 0px; font-size:12px">: {{$srmstr->asset_desc}} & {{$srmstr->sr_assetcode}}</p>
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
          {{$srmstr->sr_note}}
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="1" style="text-align:center;border-left: 2px solid; border-right:0px; border-top:0.5px solid; border-bottom:2px solid; width:350px">
        <p style=" margin-bottom:5px; margin-top:0px;font-size:12px"><span style="padding-bottom: 0px;border-bottom:1px solid black;">Diusulkan oleh,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px">{{$srmstr->req_by}}</p>
      </td>
      <td colspan="2" style="text-align:center;border-left: 0px; border-top:0.5px solid; border-right: 1.5px solid; border-bottom:2px solid;">
        <p style=" margin-bottom:5px; margin-top:0px"><span style="padding-bottom: 0px;border-bottom:1px solid black;font-size:12px">Penanggung Jawab,</span></p>
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px">{{$srmstr->sr_approver}}</p>
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
                $dept_appr = $dept->where('dept_code', '=', $srmstr->dept_user);
                ?>
                @foreach($dept_appr as $dept)
                {{$dept->dept_desc}} --
                @endforeach
                {{$srmstr->sr_approver}}
              </p>
            </td>
          </tr>
        </table>
      </td>
      <td colspan="2" style="border-left: 0px; border-top:2px solid; border-right: 1.5px solid;">
        <!-- <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">{{$srmstr->dept_desc}} -- {{$srmstr->eng_desc}}</p> -->
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
                @if($womstr != null)
                {{date('d/m/Y', strtotime($womstr->wo_created_at))}}
                @else
                &nbsp;
                @endif
              </p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
                @if($womstr != null)
                {{date('d/m/Y', strtotime($womstr->wo_schedule))}}
                @else
                &nbsp;
                @endif
              </p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
                @if($womstr != null)
                {{date('d/m/Y', strtotime($womstr->wo_duedate))}}
                @else
                &nbsp;
                @endif
              </p>
            </td>
          </tr>
          <tr>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
                @if($womstr != null)
                {{date('H:i', strtotime($womstr->wo_created_at))}}
                @else
                &nbsp;
                @endif
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
          @if($womstr != null)
          {{$womstr->wo_note}}
          @else
          &nbsp;
          @endif
        </p>
      </td>
      <td colspan="1" style="text-align:center;border-left: 0px; border-top:0.5px solid; border-right: 1.5px solid; border-bottom:2px solid;">
        <p style=" margin-bottom:5px; margin-left: 100px; margin-top:0px"><span style="padding-bottom: 0px;border-bottom:1px solid black;font-size:12px">Petugas yang melakukan pemeriksaan,</span></p>
        <p style=" margin-bottom:5px; margin-left: 100px; margin-top:30px;font-size:12px">{{$srmstr->sr_approver}}</p>
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
                @if($engineerlist != null)
                @if($engineerlist->eng1 != null)
                {{$engineerlist->eng1}}
                @else
                &nbsp;
                @endif
                @endif
              </p>
              <p style="margin:0px;padding:0px;font-size:12px">
                @if($engineerlist != null)
                @if($engineerlist->eng2 != null)
                {{$engineerlist->eng2}}
                @else
                &nbsp;
                @endif
                @endif
              </p>
              <p style="margin:0px;padding:0px;font-size:12px">
                @if($engineerlist != null)
                @if($engineerlist->eng3 != null)
                {{$engineerlist->eng3}}
                @else
                &nbsp;
                @endif
                @endif
              </p>
              <p style="margin:0px;padding:0px;font-size:12px">
                @if($engineerlist != null)
                @if($engineerlist->eng4 != null)
                {{$engineerlist->eng4}}
                @else
                &nbsp;
                @endif
                @endif
              </p>
              <p style="margin:0px;padding:0px;font-size:12px">
                @if($engineerlist != null)
                @if($engineerlist->eng5 != null)
                {{$engineerlist->eng5}}
                @else
                &nbsp;
                @endif
                @endif
              </p>
            </td>
          </tr>
          <tr>
          </tr>
        </table>
      </td>
      <td colspan="2" style="border-left: 1px; border-top:2px solid; border-right: 1.5px solid;">
        <!-- <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">{{$srmstr->dept_desc}} -- {{$srmstr->eng_desc}}</p> -->
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
                @if($womstr != null)
                @if($womstr->wo_start_date != null)
                {{date('d/m/Y', strtotime($womstr->wo_start_date))}}
                @else
                &nbsp;
                @endif
                @endif
              </p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
                @if($womstr != null)
                @if($womstr->wo_finish_date != null)
                {{date('d/m/Y', strtotime($womstr->wo_finish_date))}}
                @else
                &nbsp;
                @endif
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
                @if($womstr != null)
                @if($womstr->wo_start_time != null)
                {{date('H:i', strtotime($womstr->wo_start_time))}}
                @else
                &nbsp;
                @endif
                @endif
              </p>
            </td>
            <td style="text-align:center;border:1px solid;">
              <p style="margin:0;padding:0;font-size:12px">
                @if($womstr != null)
                @if($womstr->wo_start_time != null)
                {{date('H:i', strtotime($womstr->wo_finish_time))}}
                @else
                &nbsp;
                @endif
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
          @if($womstr != null)
          {{$womstr->wo_approval_note}}
          @else
          &nbsp;
          @endif
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
        <p style=" margin-bottom:5px; margin-top:30px;font-size:12px">
          @if($womstr != null)
          {{$womstr->wo_approver}}
          @else
          &nbsp;
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
              <p style="margin-top: 0px; font-size:12px;">: </p>
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