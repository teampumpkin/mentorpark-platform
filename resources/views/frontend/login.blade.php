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
            <div class="col-md-6 d-none d-md-block p-3">
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
                        {{-- MENT<span class="star" style="color: #ffd700;">&#9733;</span>RPARK--}}
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
                        Welcome Back!
                    </div>
                    <form method="POST" action="{{ route('user.two-step-varification') }}" id="registrationForm" class="mb-3">
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


                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                   class="form-control"
                                   id="email"
                                   name="email"
                                   placeholder="abc@xyz.com"
                                   required>

                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   placeholder="******"
                                   required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" style="background:#6651c3; border: none;">Login</button>
                        </div>
                    </form>

                    <!-- OR separator -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-fill border-bottom" style="height:1px;"></div>
                        <div class="px-2" style="color:#999;">Or</div>
                        <div class="flex-fill border-bottom" style="height:1px;"></div>
                    </div>

                    <!-- Social Buttons -->
                    <div class="row g-2">
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-light w-100 border" style="font-weight:500;">SSO</button>
                        </div>
                        <div class="col-6 position-relative">
                            <a href="{{ route('google.login') }}" class="btn btn-outline-light w-100 border d-flex align-items-center justify-content-center"
                               style="font-weight:500;">
                                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" width="20" class="me-2">
                                <span>Google</span>
                            </a>

                            {{--                            <a href="{{ route('google.login') }}" class="btn btn-primary">Login with Google</a>--}}

                        </div>

                        <div class="col-6 position-relative">
                            <a href="{{ route('linkedin.login') }}" class="btn btn-outline-light w-100 border d-flex align-items-center justify-content-center"
                               style="font-weight:500;">
                                <img src="https://www.svgrepo.com/show/157006/linkedin.svg" alt="Linkedin" width="20" class="me-2">
                                <span>Linkedin</span>
                            </a>


                        </div>
                    </div>

                    <div class="text-center mt-4" style="font-size:1rem;">

                        <a href="{{ route('user.register') }}" style="color:#6651c3; font-weight:500;">Create new account</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascripts')
    <script src="{{ asset('frontend/assets/vendor/vanilla-wizard/js/wizard.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/components/form-wizard.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#registrationForm').validate({
                rules: {
                    role: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                },
                messages: {
                    role: {
                        required: "Please select a role.",
                    },
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address."
                    },
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function (element) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                errorPlacement: function (error, element) {
                    if (element.prop('type') === 'select-one') {
                        error.insertAfter(element);
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
@endsection
