@extends('frontend.layouts.app')

@section('stylesheets')
    <style>
        input.form-control, select.form-control, textarea.form-control {
            background-color: #F8FAFB;
            border: none;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }

        .step-indicator {
            margin: 0 5px;
            padding: 8px 12px;
            border-radius: 30px;
        }

        .is-invalid {
            border-color: #dc3545; /* Bootstrap danger red */
            box-shadow: 0 0 5px #dc3545;
        }

    </style>
@endsection

@section('pageContent')
    <div class="wrapper">
        @include('frontend.includes.sidebar')

        <div class="page-content">
            <div class="page-title-head d-flex align-items-center gap-2">
                <div class="flex-grow-1">
                    <h2 class=" fw-bold mb-0" style="color: #5D29A6;">
                        {{ $breadcrumb }}
                    </h2>
                </div>

            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="col-lg-8 mx-auto">
                                {{--                                <h4 class="mb-4 text-center fw-bold">Add New User</h4>--}}

                                <!-- Progress Bar -->
                                <div class="progress mb-4" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" style="width: 25%;"></div>
                                </div>

                                <form id="userForm" action="{{ route('frontend.organization.mentee.store', ['organization_id' => $organization_id]) }}" method="POST" enctype="multipart/form-data" class="">
                                    @csrf

                                    <!-- STEP 1 -->
                                    <div class="form-step active">
                                        <h5 class="mb-3">👤 Basic Information</h5>
                                        <div class="mb-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mobile</label>
                                            <input type="text" class="form-control" name="mobile" required>
                                        </div>
                                        {{--<div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>--}}
                                        <input type="hidden" name="organization_id" value="{{ $organization_id }}">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary next-step">Next</button>
                                        </div>
                                    </div>

                                    <!-- STEP 2 -->
                                    <div class="form-step">
                                        <h5 class="mb-3">💼 Professional Details</h5>


                                        <div class="mb-3">
                                            <label class="form-label">Job Title</label>
                                            <input type="text" class="form-control" name="job_title">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Experience (Years)</label>
                                            <input type="number" class="form-control" name="total_experience">
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary prev-step">Previous</button>
                                            <button type="button" class="btn btn-primary next-step">Next</button>
                                        </div>
                                    </div>

                                    <!-- STEP 3 -->
                                    <div class="form-step">
                                        <h5 class="mb-3">🎯 Skills & Goals</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Skills</label>
                                            <select class="form-control select2" name="skills[]" multiple required>
                                                @foreach($skills as $skill)
                                                    <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Goals</label>
                                            <select class="form-control select2" name="goals[]" multiple required>
                                                @foreach($goals as $goal)
                                                    <option value="{{ $goal->id }}">{{ $goal->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">About</label>
                                            <textarea class="form-control" name="about" rows="3"></textarea>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary prev-step">Previous</button>
                                            <button type="button" class="btn btn-primary next-step">Next</button>
                                        </div>
                                    </div>

                                    <!-- STEP 4 -->
                                    <div class="form-step">
                                        <h5 class="mb-3">🌐 Social & Final Details</h5>

                                        <div class="mb-3">
                                            <label class="form-label">LinkedIn</label>
                                            <input type="url" class="form-control" name="linkedin">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Profile Photo</label>
                                            <input type="file" class="form-control" name="profile_photo"
                                                   accept="image/*">
                                        </div>
                                        <div class="row">
                                            <div class="col-3 mb-3">
                                                <label class="form-label">Country</label>
                                                <select name="country" id="country">
                                                    <option value="">Select Country</option>
                                                    @foreach($country as $list)
                                                        <option value="{{ $list->id }}">{{ $list->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-3 mb-3">
                                                <label class="form-label">State</label>
                                                <select name="state" id="state">
                                                    <option value="">Select State</option>
                                                </select>
                                            </div>

                                            <div class="col-3 mb-3">
                                                <label class="form-label">City</label>
                                                <select name="city" id="city">
                                                    <option value="">Select City</option>
                                                </select>
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label class="form-label">Postal Code</label>
                                                <input type="number" class="form-control" name="postal_code">
                                            </div>
                                        </div>

                                        {{--<div class="form-check mb-3">
                                            <input type="checkbox" name="checkmeout" value="accepted" class="form-check-input" id="checkmeout" required>
                                            <label class="form-check-label" for="checkmeout">I accept the terms</label>
                                        </div>--}}

                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary prev-step">Previous</button>
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection

@section('javascripts')

    <script>
        $(document).ready(function () {
            let currentStep = 0;
            const steps = $(".form-step");
            const progressBar = $(".progress-bar");


            $("select").select2({
                width: '100%',
                placeholder: "Select an option",
                allowClear: true
            });


            function showStep(index) {
                steps.removeClass("active").hide().eq(index).fadeIn(300).addClass("active");
                const progress = ((index + 1) / steps.length) * 100;
                progressBar.css("width", progress + "%");

                // Reinitialize Select2 for visible elements
                $("select").select2({
                    width: '100%',
                    placeholder: "Select an option",
                    allowClear: true,
                    dropdownParent: steps.eq(index)
                });
            }


            $(".next-step").click(function () {
                const currentInputs = steps.eq(currentStep).find("input, select, textarea");
                let valid = true;

                currentInputs.each(function () {
                    const $input = $(this);
                    if (!this.checkValidity()) {
                        $input.addClass("is-invalid");

                        // Handle Select2 highlighting
                        if ($input.hasClass('select2-hidden-accessible')) {
                            $input.next('.select2-container').find('.select2-selection').addClass('is-invalid');
                        }

                        this.reportValidity();
                        valid = false;
                    } else {
                        $input.removeClass("is-invalid");

                        if ($input.hasClass('select2-hidden-accessible')) {
                            $input.next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                        }
                    }
                });


                if (valid && currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });



            $(".prev-step").click(function () {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            steps.find("input, select, textarea").on("input change", function () {
                if (this.checkValidity()) {
                    $(this).removeClass("is-invalid");
                }
            });

            showStep(currentStep);



            $(document).on('change', '#country', function () {
                let countryId  = $(this).val();

                let stateSelect = $('#state');
                let citySelect  = $('#city');
                // console.log('#classes_' + number + '_state')
                stateSelect.empty().append('<option value="">-- Select State --</option>');
                citySelect.empty().append('<option value="">-- Select City --</option>');

                if (countryId) {
                    $.ajax({
                        url: '/api/stateList/' + countryId,
                        type: 'GET',
                        success: function (states) {
                            states.forEach(function (state) {
                                stateSelect.append(`<option value="${state.id}">${state.name}</option>`);
                            });
                        }
                    });
                }
            });

            $(document).on('change', '#state', function () {
                let stateId  = $(this).val();
                let citySelect  = $('#city');

                citySelect.empty().append('<option value="">-- Select City --</option>');

                if (stateId) {
                    $.ajax({
                        url: '/api/cityList/' + stateId,
                        type: 'GET',
                        success: function (cities) {
                            cities.forEach(function (city) {
                                citySelect.append(`<option value="${city.id}">${city.name}</option>`);
                            });
                        }
                    });
                }
            });

        });
    </script>

@endsection
