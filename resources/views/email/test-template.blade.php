<!DOCTYPE html>
<html>

<head>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Typography */
        body {
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 16px;
            line-height: 1.5;
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        p {
            margin-bottom: 8px;
        }

        /* Table */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        /* Button */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin-bottom: 0;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.5;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #286090;
            border-color: #204d74;
        }
    </style>
</head>

<body>
    <p>Dear [Nama],</p>
    <p>Berikut adalah daftar permintaan yang harus diperiksa:</p>
    <table>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Deskripsi</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Permintaan 1</td>
            <td>Deskripsi permintaan 1</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Permintaan 2</td>
            <td>Deskripsi permintaan 2</td>
        </tr>
    </table>
    <br>
    <a href="#" class="btn btn-primary">Approve</a>
    <a href="#" class="btn btn-primary">Reject</a>
    <br><br>
    <p>Terima kasih,</p>
    <p>[Nama]</p>
</body>

</html>