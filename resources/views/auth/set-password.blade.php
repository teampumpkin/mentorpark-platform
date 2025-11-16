<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set Your Password | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- jQuery + Validation --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a, #5E3A95);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #222;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 18px;
            padding: 40px 35px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
        }

        .card h3 {
            font-weight: 700;
            color: #111827;
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            font-weight: 500;
            margin-bottom: 6px;
        }

        input.form-control {
            height: 48px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            font-size: 15px;
        }

        input.form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .btn-primary {
            background-color: #2563eb;
            border: none;
            font-weight: 600;
            font-size: 16px;
            height: 48px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }

        label.error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 4px;
        }

        .brand-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .brand-logo img {
            width: 250px;
            height: auto;
            border-radius: 12px;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
            font-size: 13px;
        }

        @media (max-width: 576px) {
            .card {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>

<div class="card">
    {{-- Optional logo --}}
    <div class="brand-logo">
        <img src="{{ asset('logo-dark.svg') }}" alt="Brand Logo">
    </div>

    <h3>Set Your Password</h3>

    <form id="passwordForm" method="POST" action="{{ route('user.update_password', $user->user_slug) }}">
        @csrf

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" name="password" id="password" class="form-control" required minlength="8">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="8">
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-2">Save Password</button>
    </form>

    <div class="footer-text">
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</div>

<script>
    $(function() {
        $("#passwordForm").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                password: {
                    required: "Please enter a password.",
                    minlength: "Password must be at least 8 characters long."
                },
                password_confirmation: {
                    required: "Please confirm your password.",
                    equalTo: "Passwords do not match."
                }
            },
            errorElement: "label",
            errorPlacement: function (error, element) {
                error.addClass("error");
                error.insertAfter(element);
            },
            highlight: function(element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            }
        });
    });
</script>

</body>
</html>
