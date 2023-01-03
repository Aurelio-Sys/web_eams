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
  <table style="width:730px; height:800.5px; margin-bottom:-5cm;border:1px solid;" class="borderless">
    <tr>
      <td colspan="1">
        <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">1. Departemen/Seksi -- Nama Engineer</p>
      </td>
      <td colspan="2" style="border-left: 0;">
        <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">{{$srmstr->dept_desc}} -- {{$srmstr->eng_desc}}</p>
      </td>
    </tr>
    <tr>
      <td colspan="1">
        <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">2. SR Number -- Tanggal</p>
      </td>
      <td colspan="2" style="border-left: 0;">
        <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">{{$srmstr->sr_number}} -- {{date('d-m-Y',strtotime($srmstr->sr_created_at))}}</p>
      </td>
    </tr>
    <tr>
      <td colspan="1">
        <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">3. Nama Mesin/Peralatan/Fasilitas Umum/Bangunan</p>
      </td>
      <td colspan="2" style="border-left: 0; width:500px">
        <p style="margin-left:5px; margin-bottom:5px; margin-top:5px">{{$srmstr->asset_desc}}</p>
      </td>
    </tr>
    <tr>
      <td bgcolor="#bbbbbb" style="text-align:center;" colspan="3">
        <p style=" margin-bottom:5px; margin-top:5px"><b>MACAM PERMINTAAN TINDAKAN PERBAIKAN</b></p>
      </td>
    </tr>
    <tr>
      <td style="height: 65px" colspan="3">
        <p style=" margin-bottom:5px; margin-top:5px">
          <b>Deskripsi kerusakan :</b>
          @if($srmstr->fn1 != null)
          {{$srmstr->fn1}},
          @endif
          @if($srmstr->fn2 != null)
          {{$srmstr->fn2}},
          @endif
          @if($srmstr->fn3 != null)
          {{$srmstr->fn3}}
          @endif
          <br>
          <b>Tipe kerusakan : </b> {{$srmstr->wotyp_desc}}
          <br>
          <b>Catatan : </b>{{$srmstr->sr_note}}
        </p>
      </td>
    </tr>
    <tr>
      <th>Pemohon</th>
      <th>Mengetahui</th>
      <th>Menyetujui</th>
    </tr>
    <tr>
      <td style="height: 50px; text-align:center;">
        <p style=" margin-bottom:0;">{{$srmstr->req_by}}</p>
      </td>
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
    <tr>
      <td bgcolor="#bbbbbb" style="text-align:center;" colspan="3">
        <hr>
        <p style=" margin-bottom:5px; margin-top:5px"><b>VERIFIKASI PERMINTAAN TINDAKAN PERBAIKAN</b></p>
      </td>
    </tr>
    <tr>
      <td rowspan="2" style="height: 15px; border-bottom: 1px solid">
        <div style="margin-top:5px; margin-left: 10px;">
          @if($srmstr->wo_nbr != null)
          <input type="checkbox" id="checkboxreject" style="vertical-align: middle;" checked><label for="checkboxreject" style="vertical-align:middle"> Disetujui</label>
          @else
          <input type="checkbox" id="checkboxreject" style="vertical-align: middle;"><label for="checkboxreject" style="vertical-align:middle"> Disetujui</label>
          @endif
          <?php
          $datefr = strtotime($srmstr->wo_schedule);
          $dateto = strtotime($srmstr->wo_duedate);
          // $count = round(($dateto - $datefr)/3600); -- hour
          $count = round(($dateto - $datefr) / 86400);
          ?>
          <p style="margin-top: 0;">
            Estimasi Pengerjaan :
            @if($srmstr->wo_nbr != null)
            {{$count + 1}} hari
            @endif
          </p>
        </div>
      </td>
      <td rowspan="2" style="height: 15px; border-bottom: 1px solid">
        <div style="margin-top:5px; margin-left: 10px;">
          <input type="checkbox" id="checkboxreject" style="vertical-align: middle;"><label for="checkboxreject" style="vertical-align:middle"> Ditolak</label>
          <p style="margin-top: 0;">Alasan :</p>
        </div>
      </td>
      <th>Engineering Unit Head</th>
    </tr>
    <tr>
      <td style="height: 50px; vertical-align:bottom; border-bottom: 1px solid">
        <p style=" margin-bottom:0;">Tgl.</p>
      </td>
    </tr>
    <tr>
      <td bgcolor="#bbbbbb" style="text-align:center;" colspan="3">
        <hr>
        <p style=" margin-bottom:5px; margin-top:5px"><b>HASIL TINDAKAN PERBAIKAN</b></p>
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <p style="margin-left:5px; margin-top:-3px; margin-bottom: -1px;"><b>A. Penyebab Ketidaksesuaian</b></p>
      </td>
    </tr>
    <tr>
      <td style="height: 50px" colspan="3">
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <p style="margin-left:5px; margin-top:-3px; margin-bottom: -1px;"><b>B. Data Hasil Tindakan Perbaikan</b></p>
      </td>
    </tr>
    <tr>
      <td rowspan="4">
        <p style="margin-top: 0;margin-left:20px">Tindakan yang telah dilakukan :</p>
      </td>
      <th rowspan="1">Operator/Shift Head</th>
      <th>Tanggal</th>
    </tr>
    <tr>
      <td rowspan="3"></td>
      <td style="height: 30px; vertical-align:bottom;">
        <!-- <p style=" margin-bottom:0;"></p> -->
      </td>
    <tr>
      <th>Waktu</th>
    </tr>
    <tr>
      <td style="height: 30px; vertical-align:bottom;">
        <!-- <p style=" margin-bottom:0;"></p> -->
      </td>
    </tr>
    </tr>
    <tr>
      <td style="height: 70px;" colspan="2">
        <p style="margin-top: 0;margin-left:20px">Spare part yang digunakan :</p>
      </td>
      <td style="height: 70px;" colspan="1">
        <p style="margin-top: 0;margin-left:20px">Hasil perbaikan :</p>
      </td>
    </tr>
    <tr>
      <td bgcolor="#bbbbbb" style="text-align:center;" colspan="3">
        <p style=" margin-bottom:5px; margin-top:5px"><b>KONFIRMASI HASIL PERBAIKAN</b></p>
      </td>
    </tr>
    <tr>
      <th>Dilaporkan oleh</th>
      <th>Mengetahui</th>
      <th>Mengetahui</th>
    </tr>
    <tr>
      <td style="height: 50px"></td>
      <td style="height: 50px; vertical-align:bottom; text-align:center;">
        <p style=" margin-bottom:0;">Unit Head/Section Head</p>
      </td>
      <td style="height: 50px; vertical-align:bottom; text-align:center;">
        <p style=" margin-bottom:0;">Unit Head/Section Head Dept. Terkait</p>
      </td>
    </tr>
    <tr>
      <td style="height: 15px; border-bottom: 0px solid" colspan="1"></td>
      <td style="height: 15px; border-bottom: 0px solid" colspan="1"></td>
      <td style="height: 15px; border-bottom: 0px solid" colspan="1"></td>
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