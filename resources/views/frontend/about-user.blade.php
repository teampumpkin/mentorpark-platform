@extends('frontend.layouts.app')

@section('stylesheets')
    <!-- Add any custom styles here if needed -->
    <style>

    </style>

@endsection

@section('pageContent')
    @include('frontend.includes.top-right-menu')

    <div class="container-fluid" style="min-height: 100vh; padding-top: 48px; background: linear-gradient(180deg, #fff 60%, #F7F0FE 100%);">
        <!-- Step Indicator -->
        <div class="step-indicator d-flex justify-content-center mb-0">
            <div class="step-circle active" data-step="1">1</div>
            <div class="step-line"></div>
            <div class="step-circle" data-step="2">2</div>
            <div class="step-line"></div>
            <div class="step-circle" data-step="3">3</div>
        </div>
        <!-- Multi-Step Form -->
        <form id="aboutForm" class="about-form mt-0" method="POST" action="{{ route('frontend.user.about.store') }}">
            @csrf

            @error('field_name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <!-- Step 1 -->
            <div class="form-step step-field-form" data-step="1" style="display: flex;">
                <div class="about-section-center">
                    <div class="section-title">About</div>
                    <div class="section-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</div>
                    <div class="mb-3">
                        <label for="industry" class="form-label">Which industry are you from? <span class="required">*</span></label>
                        <select class="form-select @error('industry') is-invalid @enderror" id="industry" name="industry" required>
                            <option value="">Select</option>
                            @foreach($industry_type as $type)
                                <option value="{{ $type->id }}" {{ old('industry') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="organization" class="form-label">What organization do you belong to? </label>
                        <input type="text" class="form-control" id="organization" name="organization">
                        {{--<select class="form-select" id="organization" name="organization">
                            <option value="">Select Organization</option>
                            @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                            @endforeach
                        </select>--}}
                    </div>

                    <div class="mb-3">
                        <label for="your_level" class="form-label">Your Level <span class="required">*</span></label>
                        <select class="form-select @error('your_level') is-invalid @enderror" id="your_level" name="your_level" required>
                            <option value="">Select level</option>

                            <optgroup label="Individual Contributor">
                                <option value="Intern">Intern</option>
                                <option value="Graduate Engineer Trainee (GET)">Graduate Engineer Trainee (GET)</option>
                                <option value="Management Trainee">Management Trainee</option>
                                <option value="Analyst">Analyst</option>
                                <option value="Associate">Associate</option>
                                <option value="Junior Engineer">Junior Engineer</option>
                                <option value="Software Developer">Software Developer</option>
                                <option value="Research Associate">Research Associate</option>
                                <option value="Officer">Officer</option>
                                <option value="Assistant">Assistant</option>
                                <option value="Specialist">Specialist</option>
                            </optgroup>

                            <optgroup label="First-Time Manager">
                                <option value="Team Lead">Team Lead</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Assistant Manager">Assistant Manager</option>
                                <option value="Project Lead">Project Lead</option>
                                <option value="Senior Analyst">Senior Analyst</option>
                                <option value="Senior Engineer">Senior Engineer</option>
                                <option value="Lead Associate">Lead Associate</option>
                                <option value="Shift Lead">Shift Lead</option>
                                <option value="Operations Supervisor">Operations Supervisor</option>
                                <option value="Coordinator (with direct reports)">Coordinator (with direct reports)</option>
                            </optgroup>

                            <optgroup label="Mid-Level Manager">
                                <option value="Manager">Manager</option>
                                <option value="Senior Manager">Senior Manager</option>
                                <option value="Project Manager">Project Manager</option>
                                <option value="Program Manager">Program Manager</option>
                                <option value="Product Manager">Product Manager</option>
                                <option value="Plant Manager">Plant Manager</option>
                                <option value="Delivery Manager">Delivery Manager</option>
                                <option value="Section Head">Section Head</option>
                                <option value="Unit Manager">Unit Manager</option>
                                <option value="Cluster Manager">Cluster Manager</option>
                            </optgroup>

                            <optgroup label="Functional Leader">
                                <option value="General Manager (Function)">General Manager (Function)</option>
                                <option value="Department Head">Department Head</option>
                                <option value="Functional Head (e.g., Head of HR, Head of Finance, Head of Marketing)">Functional Head (e.g., Head of HR, Head of Finance, Head of Marketing)</option>
                                <option value="AVP (Associate Vice President)">AVP (Associate Vice President)</option>
                                <option value="Senior Plant Manager">Senior Plant Manager</option>
                                <option value="Regional Manager">Regional Manager</option>
                                <option value="Country Manager (single-function)">Country Manager (single-function)</option>
                            </optgroup>

                            <optgroup label="Business Leader">
                                <option value="Vice President (VP)">Vice President (VP)</option>
                                <option value="Business Unit Head">Business Unit Head</option>
                                <option value="Business Director">Business Director</option>
                                <option value="P&L Head">P&amp;L Head</option>
                                <option value="Senior GM">Senior GM</option>
                                <option value="Global Function Head">Global Function Head</option>
                                <option value="Divisional Director">Divisional Director</option>
                                <option value="Country Head (multi-function)">Country Head (multi-function)</option>
                            </optgroup>

                            <optgroup label="Group Leader">
                                <option value="Senior Vice President (SVP)">Senior Vice President (SVP)</option>
                                <option value="Executive Vice President (EVP)">Executive Vice President (EVP)</option>
                                <option value="Group CEO">Group CEO</option>
                                <option value="Group CFO">Group CFO</option>
                                <option value="Group CHRO">Group CHRO</option>
                                <option value="Group CTO">Group CTO</option>
                                <option value="Managing Director (for multiple businesses)">Managing Director (for multiple businesses)</option>
                                <option value="Regional CEO">Regional CEO</option>
                            </optgroup>

                            <optgroup label="C-Suite / Board">
                                <option value="CEO">CEO</option>
                                <option value="CFO">CFO</option>
                                <option value="CHRO">CHRO</option>
                                <option value="CTO">CTO</option>
                                <option value="COO">COO</option>
                                <option value="CIO">CIO</option>
                                <option value="CMO">CMO</option>
                                <option value="President">President</option>
                                <option value="Chairman / Chairperson">Chairman / Chairperson</option>
                                <option value="Board Member">Board Member</option>
                                <option value="Managing Director (enterprise-wide)">Managing Director (enterprise-wide)</option>
                                <option value="Founder">Founder</option>
                            </optgroup>
                        </select>
                        {{--<input type="text" class="form-control @error('your_level') is-invalid @enderror" id="your_level" name="your_level" value="{{ old('your_level') }}" required>
                        @error('your_level')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror--}}
                    </div>

                    <div class="mb-3">
                        <label for="job_title" class="form-label">Your Designation <span class="required">*</span></label>
                        <input type="text" class="form-control @error('job_title') is-invalid @enderror" id="job_title" name="job_title" value="{{ old('job_title') }}" required>
                        @error('job_title')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="total_experience" class="form-label">How many years of experience do you have? <span class="required">*</span></label>
                        <input type="number"
                               class="form-control @error('total_experience') is-invalid @enderror"
                               id="total_experience"
                               name="total_experience"
                               value="{{ old('total_experience') }}"
                               required
                               min="0"
                               max="100"
                               step="1"
                               placeholder="Enter number of years">
                        @error('total_experience')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mt-4">
                        <button type="button" class="btn btn-primary next-step">Continue</button>
                    </div>
                </div>
            </div>
            <!-- Step 2 -->
            <div class="form-step" data-step="2" style="display: none;">

                <div class="section-title">What key skills would you like to develop through mentoring?</div>
                <div class="section-desc"><i>Pick at least 3 to get started*</i></div>
                <div class="skill-checkbox-grid mt-3">
                    @foreach($skills as $idx => $skill)
                        <div class="col">
                            <label class="skill-check-btn w-100">
                                <input type="checkbox" class="skill-checkbox" name="skills[]" value="{{ $skill->id }}">
                                <span class="btn-label">{{ $skill->name }}</span>
                                <span class="tick-mark"></span>
                            </label>
                        </div>
                    @endforeach

                </div>
                <div class="text-danger skill-error pt-2" style="display: none;">Please select at least 3 skills to continue.</div>

                {{--                Step 2 content goes here--}}

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary prev-step">Back</button>
                    <button type="button" class="btn btn-primary next-step">Continue</button>
                </div>
            </div>
            <!-- Step 3 -->
            <div class="form-step step-field-form" data-step="3" style="display: none;">

                <div class="about-section-center">
                    <div class="section-title">What motivates you to become a mentor on our platform?</div>

                    <div class="mb-3">
                        <label for="mentor_motivation" class="form-label">Why do you think mentoring is important for you? <span class="required">*</span></label>
                        <textarea
                            class="form-control mentoring-textarea @error('mentor_motivation') is-invalid @enderror"
                            id="mentor_motivation"
                            name="mentor_motivation"
                            rows="5"
                            required
                            placeholder="Write at least 50 words"
                        >{{ old('mentor_motivation') }}</textarea>
                        @error('mentor_motivation')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="associate_yourself" class="form-label">Why have you chosen to associate your self with MentorPark mentoring ? <span class="required">*</span></label>
                        <textarea
                            class="form-control mentoring-textarea @error('associate_yourself') is-invalid @enderror"
                            id="associate_yourself"
                            name="associate_yourself"
                            rows="5"
                            required
                            placeholder="Write at least 50 words"
                        >{{ old('associate_yourself') }}</textarea>
                        @error('associate_yourself')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>


                    {{--<div class="d-grid mt-4">
                        <button type="button" class="btn btn-primary next-step">Continue</button>
                    </div>--}}
                </div>


                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary prev-step">Back</button>
                    <button type="submit" class="btn btn-primary">Finish</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('javascripts')
    <script>
        $(function () {

            function goToStep(step) {
                // Show step, hide others
                $('.form-step').hide();
                $('.form-step[data-step="' + step + '"]').show();
                // Progress indicator
                $('.step-circle').removeClass('active completed');
                $('.step-circle').each(function () {
                    var s = $(this).data('step');
                    if (s < step) $(this).addClass('completed');
                    else if (s == step) $(this).addClass('active');
                });
                // Progress lines
                $('.step-line').css('background', '#e8dbfc');
                $('.step-circle.completed').next('.step-line').css('background', '#8d5cf6');
            }

            // Next step button
            $('.next-step').on('click', function () {
                var currentStep = Number($('.form-step:visible').data('step'));
                var valid = true;

                var $currentStep = $('.form-step:visible');
                var currentStepNum = Number($currentStep.data('step'));

                // Validate selects (required)
                $currentStep.find('select[required]').each(function () {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                // Validate input[type=text], input[type=number], textarea (required)
                $currentStep.find('input[type="text"][required], input[type="number"][required], textarea[required]').each(function () {
                    if (!$(this).val().trim()) {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                // Validate radio buttons (required)
                // For radios: at least one in the group must be checked
                $currentStep.find('input[type="radio"][required]').each(function () {
                    var name = $(this).attr('name');
                    // Check if any radio in this group is checked
                    if ($currentStep.find('input[name="' + name + '"]:checked').length === 0) {
                        // Mark all radios in group as invalid (or their container)
                        $currentStep.find('input[name="' + name + '"]').addClass('is-invalid');
                        valid = false;
                    } else {
                        $currentStep.find('input[name="' + name + '"]').removeClass('is-invalid');
                    }
                    // Since all radios in a group share name, this logic needs to run only once per group
                    return false; // exit after first radio of group processed
                });


                // Validate checkboxes (required)
                // For checkboxes: if named individually required, check if checked
                $currentStep.find('input[type="checkbox"][required]').each(function () {
                    // If checkbox group, handle similarly - assuming individual required here
                    if (!$(this).is(':checked')) {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (currentStepNum === 2) {
                    var skillsChecked = $currentStep.find('.skill-checkbox:checked').length;
                    if (skillsChecked < 3) {
                        $currentStep.find('.skill-error').show();
                        return;
                    } else {
                        $currentStep.find('.skill-error').hide();
                    }
                }

                if (!valid) return;

                if (currentStepNum < 3) {
                    goToStep(currentStepNum + 1);
                } else {
                    // Last step: submit form
                    $('#aboutForm').submit();
                }
            });

            $(document).on('change', '.skill-checkbox', function () {
                if (this.checked) {
                    $(this).closest('.skill-check-btn').addClass('selected');
                } else {
                    $(this).closest('.skill-check-btn').removeClass('selected');
                }
            });


            // Previous step button
            $('.prev-step').on('click', function () {
                var currentStep = Number($('.form-step:visible').data('step'));
                goToStep(currentStep - 1);
            });

            // Remove validation error on change
            $('select[required]').on('change', function () {
                if ($(this).val()) $(this).removeClass('is-invalid');
            });

            // Prevent form submit unless on last step and valid
            $('#aboutForm').on('submit', function (e) {
                var valid = true;
                $('.form-step:visible select[required]').each(function () {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                if (!valid) e.preventDefault();
            });

        });
    </script>
@endsection
