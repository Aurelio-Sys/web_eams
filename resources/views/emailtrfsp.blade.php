<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Work Order Cancellation Notification</title>
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
    <div class="container" style="font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 20px;">
        <div class="header" style="background-color: #333; color: #fff; padding: 10px;">
            <h1 style="margin: 0; text-align: center;">Spare Part Transfer</h1>
        </div>
        <div class="content" style="background-color: #fff; padding: 20px;">
            <p style="font-size: 16px;">Dear User,</p>
            <p style="font-size: 16px;">We would like to inform you that the spare parts for request sparepart number <strong>{{$rsnumber}}</strong> have been transferred by the warehouse.</p>
            <p style="font-size: 16px;">Thank you for using our system.</p>
        </div>
        <div class="footer" style="background-color: #333; color: #fff; padding: 10px; text-align: center;">
            <p style="margin: 0; font-size: 12px;">This email was sent automatically. Please do not reply.</p>
        </div>
    </div>
</body>

</html>