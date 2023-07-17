<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Gaya Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Gaya Konten Email */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        h1 {
            margin-top: 0;
            color: #333;
        }

        p {
            margin-bottom: 20px;
            color: #555;
        }

        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .email-header h1 {
            font-size: 24px;
            color: #333;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="email-header">
        <h1>eAMS - Alert Routine Check</h1>
    </div>
    <h4>Informasi Hasil Routine Check</h1>
    <p><strong>Tanggal Check:</strong> {{ $datarcm->ra_actual_check_time }}</p>
    <p><strong>Asset Name:</strong> {{ $datarcm->asset_desc }}</p>
    <p><strong>QC List Code:</strong> {{ $datarcm->ra_qcs_desc }}</p>

    <p><strong>Ditemukan adanya ketidaknormalan berdasarkan data berikut : </strong></p>

    <h4>Routine Check Result</h4>
    <table>
        <thead>
            <tr>
                <th>QC Spec</th>
                <th>Result</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datasendalert as $datas)
                <tr>
                    <td>{{ $datas->ra_det_qcsspec }}</td>
                    <td>{{ $datas->ra_det_result1 }}</td>
                    <td>{{ $datas->ra_det_note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
