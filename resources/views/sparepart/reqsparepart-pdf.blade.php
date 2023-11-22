<!DOCTYPE html>
<html>

<head>
    <style>
        .container {
            width: 100%;
        }

        /* Logo styling */
        .logo {
            margin-top: -10px;
            width: 100px;
            /* Adjust the width as needed */
            vertical-align: middle;
            display: inline-block;
        }

        /* Title styling */
        .title {
            font-size: 20px;
            margin-top: 0;
            /* Remove the margin-top to align with the logo */
            margin-left: 6em;
            display: inline-block;
            vertical-align: middle;
        }

        .printedDate {
            font-size: 14px;
            margin-top: 5px;
            /* margin-left: 30em; */
            float: right;
            display: inline-block;
            vertical-align: middle;
        }

        /* Content styling (optional) */
        .content {
            margin-top: 1em;
        }

        /* Bootstrap classes (optional) */
        .col-md-2 {
            width: 16.66667%;
            /* 2 columns out of 12, adjust as needed */
            float: left;
        }

        .col-md-6 {
            width: 50.00001%;
            /* 6 columns out of 12, adjust as needed */
            float: left;
        }

        .col-md-4 {
            width: 33.33334%;
            float: right;
        }

        .pembatasJudul {
            margin-top: 4.5em;
            margin-bottom: -1em;
        }

        .pheader {
            margin: 0;
            padding: 0;
            font-size: 13px
        }

        .tableheader {
            margin-top: 0px;
            margin-bottom: 10px;
            border-collapse: collapse;
            border: 0px;
        }

        .tdheader {
            border-collapse: collapse;
            border: 0px;
        }

        .trheader {
            background-color: #ffffff;
        }

        #pdfMutasiKas {
            /* width: 100%;
            max-width: 100%; */
            margin-bottom: 0;
            /* display: block; */
            overflow-x: auto;
            white-space: nowrap;
            /* height: 520px; */
            /* border-collapse: separate; */
            border-spacing: 0;
            /* table-layout: fixed; */
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            /* Set a maximum width as needed */
            margin: 0 auto;
            /* Center the table on the page */
            font-family: Arial, sans-serif;
            /* Choose your preferred font */
        }

        /* Style for table headers (th) */
        th {
            background-color: #000000;
            font-weight: bold;
            font-size: 14px;
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
            color: #f5f5f5;
        }

        /* Style for table rows (td) */
        td {
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        /* Alternate row background color for better readability */
        tr:nth-child(even) {
            background-color: #cccccc;
        }

        /* Hover effect on table rows */
        tr:hover {
            background-color: #e0e0e0;
        }

        .rowSaldoAwal {
            text-align: center;
        }

        .nilai {
            text-align: right;
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2 logo">
                {{--  <img src="{{ public_path('assets/DK-logo.jpg') }}" width="80" height="80" alt="Logo">  --}}
            </div>
            <div class="col-md-6 title">
                <h3>Request Sparepart List</h1>
            </div>
            <div class="col-md-4" style="float: right; width: 100%; margin-top: 2.5em;">
                <h5 class="printedDate">{{now()}}</h5>
            </div>
            <div class="pembatasJudul">
                <hr style="border: 1px solid #000;">
            </div>
        </div>
        <div class="content">
            <!-- Your content goes here -->
            <table class="tableheader">
                <tr class="trheader">
                    <td class="tdheader">
                        <p class="pheader"><b>RS Number </b></p>
                    </td>
                    <td class="tdheader">
                        <p class="pheader">: {{$data->req_sp_number}}</p>
                    </td>
                    <td class="tdheader">
                        <p class="pheader"><b>Requested By </b></p>
                    </td>
                    <td class="tdheader">
                        <p class="pheader">: {{$data->req_sp_requested_by}}</p>
                    </td>
                </tr>
                <tr class="trheader">
                    <td class="tdheader">
                        <p class="pheader"><b>WO Number </b></p>
                    </td>
                    <td class="tdheader">
                        <p class="pheader">: {{$data->req_sp_wonumber}}</p>
                    </td>
                    <td class="tdheader">
                        <p class="pheader"><b>Needed Date </b></p>
                    </td>
                    <td class="tdheader">
                        <p class="pheader">: {{$data->req_sp_due_date == '0000-00-00' ? '' : date('m/d/Y', strtotime($data->req_sp_due_date)) }}</p>
                    </td>
                </tr>
            </table>
            <table id="pdfMutasiKas">
                <thead>
                    <tr>
                        <th>Spare Part</ths>
                        <th>Qty Request</th>
                        <th>Qty Transfer</th>
                        <th>Location To</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detail as $data)
                    <tr>
                        <td>
                            {{$data->req_spd_sparepart_code}} -- {{$data->spm_desc}}
                        </td>
                        <td>
                            {{$data->req_spd_qty_request}}
                        </td>
                        <td>
                            {{$data->req_spd_qty_transfer}}
                        </td>
                        <td>
                            {{$data->req_spd_loc_to}}
                        </td>
                        <td>
                            {{$data->req_spd_reqnote}}
                        </td>
                    </tr>
                    @empty
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>