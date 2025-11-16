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
                <div class="w-100" style="max-width: 410px;">
                    <div class="mb-4 text-center logo" style="font-weight: 700; font-size: 2rem; color: #6651c3; letter-spacing: 2px;">
                        <img src="{{ asset('frontend/assets/images/logo.svg') }}" class="img-fluid">
                    </div>
                    <h1 class="mb-2 font-extrabold text-center">
                        Sign up as a <span class="text-lowercase">{{ $breadcrumb }}</span>
                    </h1>
                    <div class="mb-2 text-center text-black" style="font-size: 1rem;">
                        Enter your email and password to log in
                    </div>
                    <form method="POST" action="{{ route('submit.user.details') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="name">Full name</label>
                            <input type="text" id="name" class="form-control" name="name" placeholder="Lois becket" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" class="form-control" name="email" placeholder="Loisbecket@gmail.com" value="{{ $email }}" required readonly>
                        </div>
                        <div class="mb-3 position-relative">
                            <label class="form-label" for="password">Create a password</label>
                            <input type="password" id="password" class="form-control pr-5" name="password" required>
                            <span class="position-absolute end-0 top-50 translate-middle-y me-3" style="cursor:pointer;" onclick="togglePassword('password', this)">
                    <i class="bi bi-eye-slash" id="eyeIconPassword"></i>
                    </span>
                        </div>
                        <div class="mb-4 position-relative">
                            <label class="form-label" for="password_confirmation">Confirm password</label>
                            <input type="password" id="password_confirmation" class="form-control pr-5" name="password_confirmation" required>
                            <span class="position-absolute end-0 top-50 translate-middle-y me-3" style="cursor:pointer;" onclick="togglePassword('password_confirmation', this)">
                    <i class="bi bi-eye-slash" id="eyeIconPasswordConfirmation"></i>
                    </span>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-lg" style="background:#6651c3; color:#fff; border-radius:10px;">Sign up</button>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascripts')
    <script src="{{ asset('frontend/assets/vendor/vanilla-wizard/js/wizard.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Initialize form validation
            $("form").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                        minlength: 2,
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255,
                        // uniqueEmail: true // Uncomment if you add AJAX unique check route
                    },
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
                    name: {
                        required: "Please enter your full name.",
                        maxlength: "Name cannot exceed 255 characters."
                    },
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email.",
                        maxlength: "Email cannot exceed 255 characters.",
                        uniqueEmail: "This email is already registered."
                    },
                    password: {
                        required: "Please create a password.",
                        minlength: "Password must be at least 8 characters long."
                    },
                    password_confirmation: {
                        required: "Please confirm your password.",
                        equalTo: "Passwords do not match."
                    }
                },
                errorElement: "div",
                errorPlacement: function (error, element) {
                    error.addClass("text-danger mt-1");
                    error.insertAfter(element);
                },
                highlight: function (element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function (element) {
                    $(element).removeClass("is-invalid");
                }
            });
        });
    </script>

@endsection
