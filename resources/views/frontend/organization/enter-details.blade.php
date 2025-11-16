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
                        Enter organization details here
                    </div>
                    <div class="mb-3 organization-field">
                        <select class="form-control" name="organization" id="organization-select">
                            <option value="">Select organization</option>
                            @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}"
                                        data-image="{{ asset('storage/' . $organization->logo_path) }}">
                                    {{ $organization->name }}
                                </option>
                            @endforeach
                            <option value="register-organization">Create new organization</option>
                        </select>
                    </div>
                    <form method="POST" action="{{ route('submit.organization.details') }}" id="register-organization" style="display: none" enctype="multipart/form-data">
                        @csrf

                        <!-- Step 1: Basic info -->
                        <div class="form-step" id="step-1">
                            <div class="mb-3">
                                <label for="name" class="form-label">Organization Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" placeholder="Enter organization name" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $email ?? '') }}" placeholder="Enter email" readonly>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label">Password</label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       placeholder="Enter password">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">

                                <input type="password"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       placeholder="Confirm password">
                                @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone (optional)</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button type="button" class="btn btn-primary next-btn" data-step="1">Next</button>
                        </div>

                        <!-- Step 2: Website and address -->
                        <div class="form-step" id="step-2" style="display:none;">
                            <div class="mb-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" class="form-control @error('website') is-invalid @enderror"
                                       id="website" name="website" value="{{ old('website') }}" placeholder="https://example.com">
                                @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2" placeholder="Enter address">{{ old('address') }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-control @error('country') is-invalid @enderror" id="org-country" name="country">
                                        <option value="">-- Select Country --</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-control @error('state') is-invalid @enderror" id="org-state" name="state">
                                        <option value="">-- Select State --</option>
                                    </select>
                                    @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <select class="form-control @error('city') is-invalid @enderror" id="org-city" name="city">
                                        <option value="">-- Select City --</option>
                                    </select>
                                    @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="postal_code" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                           id="postal_code" name="postal_code" value="{{ old('postal_code') }}" placeholder="Enter postal code">
                                    @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary prev-btn" data-step="2">Previous</button>
                            <button type="button" class="btn btn-primary next-btn" data-step="2">Next</button>
                        </div>

                        <!-- Step 3: Other details -->
                        <div class="form-step" id="step-3" style="display:none;">
                            <div class="mb-3">
                                <label for="industry_type" class="form-label">Industry Type</label>
                                <select class="form-control @error('industry_type') is-invalid @enderror industry_type"
                                        id="industry_type" name="industry_type">
                                    <option value="">-- Select Industry Type --</option>
                                    {{-- Populate dynamically via JS --}}
                                </select>
                                @error('industry_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="registration_number" class="form-label">Registration Number</label>
                                <input type="text" class="form-control @error('registration_number') is-invalid @enderror"
                                       id="registration_number" name="registration_number" value="{{ old('registration_number') }}" placeholder="Enter registration number">
                                @error('registration_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="founded_date" class="form-label">Founded Date</label>
                                <input type="date" class="form-control @error('founded_date') is-invalid @enderror"
                                       id="founded_date" name="founded_date" value="{{ old('founded_date') }}">
                                @error('founded_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="logo_path" class="form-label">Logo</label>
                                <input type="file" class="form-control @error('logo_path') is-invalid @enderror"
                                       id="logo_path" name="logo_path" accept="image/*">
                                @error('logo_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button type="button" class="btn btn-secondary prev-btn" data-step="3">Previous</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
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
    {{--<script>
        $('#organization-select').select2({
            templateResult: formatState,
            templateSelection: formatState
        });

        function formatState (state) {
            if (!state.id) {
                return state.text;
            }
            var imageUrl = $(state.element).data('image');
            if (!imageUrl) {
                return state.text;
            }
            var $state = $(
                '<span><img src="' + imageUrl + '" style="width:30px; margin-right:8px;" /> ' + state.text + '</span>'
            );
            return $state;
        }

        $('#organization-select').on('change', function() {
            if ($(this).val() === 'register-organization') {
                $('#register-organization').show();
            } else {
                $('#register-organization').hide();
            }
        });

        document.querySelectorAll('.next-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var step = this.getAttribute('data-step');
                document.getElementById('step-' + step).style.display = 'none';
                document.getElementById('step-' + (parseInt(step) + 1)).style.display = 'block';
            });
        });

        document.querySelectorAll('.prev-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var step = this.getAttribute('data-step');
                document.getElementById('step-' + step).style.display = 'none';
                document.getElementById('step-' + (parseInt(step) - 1)).style.display = 'block';
            });
        });

        $(document).ready(function () {

            // Initialize jQuery Validation
            const form = $("#register-organization");

            form.validate({
                ignore: [], // include hidden fields
                rules: {
                    // Step 1
                    name: { required: true, minlength: 2 },
                    email: { required: true, email: true },
                    phone: { digits: true, minlength: 7, maxlength: 15 },

                    // Step 2
                    website: { url: true },
                    address: { required: true, minlength: 5 },
                    country: { required: true },
                    state: { required: true },
                    city: { required: true },
                    postal_code: { required: true, digits: true, minlength: 4, maxlength: 10 },

                    // Step 3
                    industry_type: { required: true },
                    registration_number: { required: true, minlength: 3 },
                    founded_date: { required: true, date: true },
                    logo_path: { extension: "jpg|jpeg|png|gif|svg" }
                },
                messages: {
                    name: "Please enter your organization name",
                    email: "Please enter a valid email",
                    phone: "Enter a valid phone number",
                    address: "Please provide an address",
                    country: "Please select your country",
                    state: "Please select your state",
                    city: "Please select your city",
                    postal_code: "Enter a valid postal code",
                    industry_type: "Please select an industry type",
                    registration_number: "Enter a valid registration number",
                    founded_date: "Please enter a valid date",
                    logo_path: "Please upload a valid image file (jpg, png, gif, svg)"
                },
                errorElement: "div",
                errorPlacement: function (error, element) {
                    error.addClass("invalid-feedback");
                    element.closest(".mb-3").append(error);
                },
                highlight: function (element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function (element) {
                    $(element).removeClass("is-invalid");
                }
            });

            // Step navigation
            $(".next-btn").click(function () {
                const step = $(this).data("step");
                const currentStep = $("#step-" + step);

                // Validate current visible fields only
                if (form.valid()) {
                    currentStep.hide();
                    $("#step-" + (step + 1)).fadeIn();
                }
            });

            $(".prev-btn").click(function () {
                const step = $(this).data("step");
                $("#step-" + step).hide();
                $("#step-" + (step - 1)).fadeIn();
            });

        });


    </script>--}}

    <script>
        $(document).ready(function () {

            // ===============================
            // 1️⃣ Initialize Select2 with Images
            // ===============================
            $('#organization-select').select2({
                templateResult: formatState,
                templateSelection: formatState,
                width: '100%'
            });

            function formatState(state) {
                if (!state.id) {
                    return state.text;
                }

                const imageUrl = $(state.element).data('image');
                if (!imageUrl) {
                    return state.text;
                }

                return $(
                    `<span><img src="${imageUrl}" style="width:30px; margin-right:8px;" /> ${state.text}</span>`
                );
            }

            // ===============================
            // 2️⃣ Show/Hide Register Organization Form
            // ===============================
            $('#organization-select').on('change', function() {
                if ($(this).val() === 'register-organization') {
                    $('#register-organization').fadeIn();
                } else {
                    $('#register-organization').fadeOut();
                }
            });

            // ===============================
            // 3️⃣ Initialize jQuery Validation
            // ===============================
            const form = $("#register-organization");

            form.validate({
                ignore: [], // include hidden fields
                rules: {
                    // Step 1
                    name: { required: true, minlength: 2 },
                    email: { required: true, email: true },
                    phone: { digits: true, minlength: 7, maxlength: 15 },
                    password: { required: true, minlength: 8 },
                    password_confirmation: { required: true, equalTo: "#password" },

                    // Step 2
                    website: { url: true },
                    address: { required: true, minlength: 5 },
                    country: { required: true },
                    state: { required: true },
                    city: { required: true },
                    postal_code: { required: true, digits: true, minlength: 4, maxlength: 10 },

                    // Step 3
                    industry_type: { required: true },
                    registration_number: { required: true, minlength: 3 },
                    founded_date: { required: true, date: true },
                    logo_path: { extension: "jpg|jpeg|png|gif|svg" }
                },
                messages: {
                    name: "Please enter your organization name",
                    email: "Please enter a valid email",
                    phone: "Enter a valid phone number",
                    password: {
                        required: "Please enter a password",
                        minlength: "Password must be at least 8 characters long"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    },
                    address: "Please provide an address",
                    country: "Please select your country",
                    state: "Please select your state",
                    city: "Please select your city",
                    postal_code: "Enter a valid postal code",
                    industry_type: "Please select an industry type",
                    registration_number: "Enter a valid registration number",
                    founded_date: "Please enter a valid date",
                    logo_path: "Please upload a valid image file (jpg, png, gif, svg)"
                },
                errorElement: "div",
                errorPlacement: function (error, element) {
                    error.addClass("invalid-feedback");
                    element.closest(".mb-3").append(error);
                },
                highlight: function (element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function (element) {
                    $(element).removeClass("is-invalid");
                }
            });

            // ===============================
            // 4️⃣ Step Navigation
            // ===============================
            $(".next-btn").on("click", function () {
                const step = $(this).data("step");
                const currentStep = $("#step-" + step);

                // Validate only visible fields in the current step
                let isValid = true;
                currentStep.find(":input").each(function () {
                    if (!form.validate().element(this)) {
                        isValid = false;
                    }
                });

                if (isValid) {
                    currentStep.hide();
                    $("#step-" + (step + 1)).fadeIn();
                    window.scrollTo({ top: 0, behavior: 'smooth' }); // optional: scroll to top
                }
            });

            $(".prev-btn").on("click", function () {
                const step = $(this).data("step");
                $("#step-" + step).hide();
                $("#step-" + (step - 1)).fadeIn();
                window.scrollTo({ top: 0, behavior: 'smooth' }); // optional: scroll to top
            });


        });
    </script>


@endsection
