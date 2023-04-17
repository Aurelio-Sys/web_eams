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
        box-shadow: 0 0 10px rgba(0,0,0,.1);
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
        <h1>Work Order Cancellation Notification</h1>
      </div>
      <div class="content">
        <p>Dear {{ $name }},</p>
        <p>This email is to inform you that the work order with number {{ $wonumber }} has been cancelled and the service request {{ $srnumber }} status has been returned to open. The following is the cancellation note:</p>
        <p>{{ $cancellationNote }}</p>
      </div>
      <div class="footer">
        <p>This email was sent to {{ $email }}.</p>
      </div>
    </div>
  </body>
</html>
