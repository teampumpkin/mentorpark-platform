<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Notification' }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f6fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .email-container {
            background: #ffffff;
            max-width: 640px;
            margin: 40px auto;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .email-header {
            background-color: #2563eb;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .email-body {
            padding: 30px;
        }

        .email-body p {
            line-height: 1.6;
            font-size: 15px;
        }

        .email-button {
            display: inline-block;
            background-color: #2563eb;
            color: #fff !important;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 20px;
            font-weight: 600;
        }

        .email-footer {
            background: #f1f1f1;
            text-align: center;
            padding: 12px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h2>{{ $subject ?? 'Notification' }}</h2>
    </div>

    <div class="email-body">

        <p>Hi {{ $name }},</p>

        <p>{{ $introText ?? 'You have been invited to join our platform!' }}</p>

        @if(!empty($messageText))
            <p><strong>Message:</strong> {{ $messageText }}</p>
        @endif

        @if(!empty($actionUrl))
            <a href="{{ $actionUrl }}" class="email-button">
                {{ $actionText ?? 'View Invitation' }}
            </a>
        @endif

        <p>If you didn’t expect this invitation, you can safely ignore this email.</p>

    </div>

    <div class="email-footer">
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</div>
</body>
</html>
