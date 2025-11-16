<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>You're Invited to Our Master Class!</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f7f7f7;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f7f7f7; padding:40px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1);">

                <!-- Header -->
                <tr>
                    <td style="background-color:#4f46e5; color:#ffffff; text-align:center; padding:20px;">
                        <h1 style="margin:0; font-size:24px;">🌟 You're Invited!</h1>
                    </td>
                </tr>

                <!-- Banner -->
                <tr>
                    <td>
                        <img src="{{ $bannerImage ?? 'https://via.placeholder.com/600x200' }}"
                             alt="Master Class Banner"
                             style="width:100%; display:block;">
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px; color:#333333;">
                        <h2 style="margin-top:0;">Hello {{ $userName }},</h2>
                        <p>
                            We’re excited to invite you to our upcoming <strong>{{ $classTitle }}</strong>.
                        </p>

                        <p>
                            @if($startDateTime)<strong>Date & Time:</strong> {{ $startDateTime }} <br>@endif
                            @if($duration)<strong>Duration:</strong> {{ $duration }} <br>@endif
                            <strong>Trainer:</strong> {{ $trainerName }}
                        </p>

                        <p>{{ $description }}</p>

                        <div style="text-align:center; margin:30px 0;">
                            <a href="{{ $joinUrl }}"
                               style="background-color:#4f46e5; color:#ffffff; text-decoration:none; padding:15px 30px; border-radius:5px; font-size:16px; display:inline-block;">
                                Join the Master Class
                            </a>
                        </div>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color:#f0f0f0; text-align:center; padding:20px; font-size:12px; color:#888888;">
                        © {{ date('Y') }} Your Company. All rights reserved. <br>
                        <a href="{{ $unsubscribeUrl ?? '#' }}" style="color:#4f46e5; text-decoration:none;">Unsubscribe</a>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
