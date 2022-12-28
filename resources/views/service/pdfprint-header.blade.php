

<!--------------- INI UNTUK PRINT TEMPLATE --------------->
<table style="width:730px; margin-top:-0.7cm; margin-left:0px" class="borderless">


  <tr>
    <td style="text-align:center;vertical-align:middle;border:1px solid;border-left:2px solid;border-top:2px solid" colspan="1" rowspan="2">
      <img src="{{public_path('assets/Actavis-logo.png')}}" height="40px">
    </td>
    <td style="text-align:center;border:1px solid;border-left:0px;border-top:2px solid; margin-bottom:-10px" colspan="3">
      <p style="margin-top: 5px; margin-bottom:5px"><b>FORMULIR</b><br>
        <b><em>Form</em></b>
      </p>
    </td>
    <td style="text-align:center;vertical-align:middle;border:1px solid;border-left:0px;border-top:2px solid;border-right:2px solid" colspan="1">
      <p style="margin-top: 5px; margin-bottom:5px"><b>Halaman {{$pagenow}} dari 1 </b></p>
    </td>
  </tr>
  <tr>
    <td style="text-align:center;border:1px solid;border-top:0px solid;border-left:0px;" colspan="3">
      <p style="margin-top: 5px; margin-bottom:5px"><b>DEPARTEMEN ENGINEERING</b><br>
        <b><em>Engineering Department</em></b>
      </p>
    </td>
    <td style="width:170px;border-bottom:1px solid; border-top:0px; border-right:2px solid;" colspan="1">
      <p style="margin-top: 5px; margin-bottom:5px">040GD5-001.04<br>
        Tgl. Berlaku : {{date('d-m-Y',strtotime($printdate))}}
      </p>
    </td>
  </tr>
  <tr>
    <td bgcolor="#bbbbbb" style="border: 2px solid; text-align:center; border-top:0; padding:0" colspan="5">
      <p style="margin-top: 2px; margin-bottom:2px">
        <b>
          Permintaan Tindakan Perbaikan <br>
          <em>Work Order</em>
        </b>
      </p>
    </td>
  </tr>
  <tr>
    <td style="text-align:right; border:0; font-size: 11px; padding:0;" colspan="5">
      <p style="margin-top: 2px; margin-bottom:2px">Ref. 040BD4-001</p>
    </td>
  </tr>

</table>