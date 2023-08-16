<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Request Sparepart Approval Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            margin-bottom: 30px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Request Sparepart Approval</h1>
        </div>
        <div class="content">
            @if($wonumber != null)
            <p>Attention! Request Sparepart {{$rsnumber}} for Work Order {{$wonumber}} has been created and currently requires approval. Please review and provide your approval as soon as possible.</p>
            @else
            <p>Attention! Request Sparepart {{$rsnumber}} has been created and currently requires approval. Please review and provide your approval as soon as possible.</p>
            @endif
        </div>
        <div class="footer">
        </div>
    </div>
</body>

</html>