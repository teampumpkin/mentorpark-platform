<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
            padding: 30px;
            color: #333;
        }
        .email-container {
            max-width: 500px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 8px rgba(0,0,0,0.1);
            padding: 25px;
        }
        h2 {
            color: #2d3748;
            text-align: center;
        }
        .otp-box {
            background: #f9fafb;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            border: 2px dashed #4CAF50;
            color: #4CAF50;
            letter-spacing: 4px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="email-container">
    <h2>OTP Verification</h2>

    <p>Hi {{ $details['name'] }},</p>

    <p>We received a request to verify your identity. Use the OTP below to continue:</p>

    <div class="otp-box">
        {{ $details['otp'] }}
    </div>

    <p>This OTP is valid for <strong>5 minutes</strong>. Please do not share it with anyone for security reasons.</p>

    <p>If you did not request this, you can safely ignore this email.</p>

    <div class="footer">
        &copy; {{ date('Y') }} Your Company Name. All rights reserved.
    </div>
</div>
</body>
</html>
