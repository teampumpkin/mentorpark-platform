@extends('frontend.layouts.app')
@section('stylesheets')

@endsection
@section('pageContent')
    {{--<div class="wrapper">
            @include('frontend.includes.sidebar')
            @include('frontend.includes.top-bar')
        <div class="page-content"></div>
    </div>--}}
    <div class="container-fluid">
        <div class="row g-3">
            <!-- Left Col: Image & Text -->
            <div class="col-md-6 d-none d-md-block  p-3">
                <div class="left-img-bg">
                    <div class="overlay-text"
                         style="background: linear-gradient(180deg, rgb(255 255 255 / 0%) 0%, rgba(0, 0, 0, 1) 100%); width: 100%; padding: 30px; border-radius: 0 0 18px 18px;">
                        <h4>Lorem Ipsum is simply dummy text</h4>
                        <div style="font-size: 0.95rem; opacity: 0.85;">
                            Lorem Ipsum is simply dummy text
                            <span class="ms-2"><i class="bi bi-book"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Col: Login/Register Panel -->
            <div class="col-md-6 d-flex align-items-center justify-content-center min-vh-100">
                <div class="w-100" style="max-width: 340px;">
                    <div class="mb-4 text-center logo" style="font-weight: 700; font-size: 2rem; color: #6651c3; letter-spacing: 2px;">
                        <img src="{{ asset('frontend/assets/images/logo.svg') }}" class="img-fluid">
                    </div>
                    <div class="mb-3 text-center">
                        <!-- Profile images -->
                        <img src="{{ asset('frontend/assets/images/users/avatar-1.jpg') }}" class="role-img" alt="Profile1">
                        <img src="{{ asset('frontend/assets/images/users/avatar-2.jpg') }}" class="role-img" alt="Profile2">
                        <img src="{{ asset('frontend/assets/images/users/avatar-3.jpg') }}" class="role-img" alt="Profile3">
                        <img src="{{ asset('frontend/assets/images/users/avatar-4.jpg') }}" class="role-img" alt="Profile4">
                        <span class="role-img avatar-badge">50+</span>
                    </div>
                    <div class="mb-2 fw-bold text-center" style="font-size:1.2rem;">
                        Ready to lead or learn?<br>
                        choose your role and begin
                    </div>
                    <div class="mb-2 text-center text-black" style="font-size: 1rem;">
                        Lorem Ipsum is simply dummy text
                    </div>
                    <form method="POST" action="{{ route('verify-otp-login') }}" id="registrationForm">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li style="font-size: 0.875rem;">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <input type="hidden" name="email" value="{{ $email }}">
                        <div class="text-center mb-3">
                            <div class="mb-2" style="color: #888;">We’ve sent a code to <strong>{{ $email }}</strong></div>
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                @for ($i = 1; $i <= 4; $i++)
                                    <input type="text"
                                           name="otp[]"
                                           maxlength="1"
                                           class="otp-input text-center"
                                           autocomplete="one-time-code"
                                           inputmode="numeric"
                                           pattern="\d*"
                                           required
                                           style="width: 56px; height: 56px; font-size: 2rem; border: 2px solid #e2e2e2; border-radius: 16px; box-shadow: none; transition: border-color 0.2s;">
                                @endfor
                            </div>
                            <div class="mt-2">
                                <button type="button" id="resendBtn" class="btn btn-link p-0" disabled style="color:#6651c3; text-decoration:none;">Send code again</button>
                                <span id="timer">05:00</span>
                            </div>
                        </div>


                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" style="background:#6651c3; border: none;">Next</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascripts')
    <script src="{{ asset('frontend/assets/vendor/vanilla-wizard/js/wizard.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/form-wizard.js') }}"></script>
    <script>
        $(function () {
            // Auto tab to next input
            $('.otp-input').on('input', function () {
                if (this.value.length == 1) {
                    $(this).next('.otp-input').focus();
                }
            }).on('keydown', function (e) {
                if (e.key === "Backspace" && this.value === '') {
                    $(this).prev('.otp-input').focus();
                }
            });
            startFiveMinuteTimer();
        });
    </script>

    <script>
        function startFiveMinuteTimer(displayId = 'timer') {
            var timeLeft = 300; // 5 minutes in seconds
            var display = document.getElementById(displayId);

            var countdown = setInterval(function () {
                let minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;
                // Always display double digits
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                display.textContent = minutes + ':' + seconds;

                if (--timeLeft < 0) {
                    clearInterval(countdown);
                    display.textContent = "00:00";
                    // Optionally, trigger event/timer expired logic here
                }
            }, 1000);
        }

        // Start the timer when the page loads or when needed

    </script>

@endsection
