@extends('frontend.layouts.app')

@section('stylesheets')

    <style>
        .modal-header {
            background-color: #6C3FC5;
            color: #fff;
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
        }

        .modal-content {
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background-color: #6C3FC5;
            border-color: #6C3FC5;
        }

        .btn-primary:hover {
            background-color: #5933a8;
            border-color: #5933a8;
        }

        .button-group {
            display: flex;
            gap: 12px;
            justify-content: flex-start;
            align-items: center;
            margin: 20px 0;
        }

        .btn {
            border: none;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            padding: 10px 22px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-purple {
            background-color: #6a1b9a; /* deep purple */
        }

        .btn-purple:hover {
            background-color: #4a0072;
        }

        .btn-black {
            background-color: #000;
        }

        .btn-black:hover {
            background-color: #333;
        }

        .btn-green {
            background-color: #00c8a5;
        }

        .btn-green:hover {
            background-color: #009e83;
        }


        .step-container {
            width: 100%;
        }

        .step {
            display: flex;
            align-items: center;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 12px;
            transition: all 0.2s ease;
            box-shadow: 8px 2px 20px -16px rgba(0, 0, 0, 0.75);
            -webkit-box-shadow: 8px 2px 20px -16px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 8px 2px 20px -16px rgba(0, 0, 0, 0.75);
        }

        .step:hover {
            background-color: #fafafa;
        }

        .step input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #ccc;
            border-radius: 50%;
            margin-right: 12px;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .step input[type="checkbox"]:checked {
            border-color: #6c3bd2;
            background-color: #6c3bd2;
        }

        .step input[type="checkbox"]:checked::after {
            content: "✓";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -58%);
            color: white;
            font-size: 13px;
        }

        .step label {
            cursor: pointer;
            font-size: 15px;
            color: #333;
        }

        .step input[type="checkbox"]:checked + label {
            font-weight: 600;
            color: #6c3bd2;
        }

        .upcoming-event-view {
            box-shadow: 8px 2px 20px -16px rgba(0, 0, 0, 0.75);
            -webkit-box-shadow: 8px 2px 20px -16px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 8px 2px 20px -16px rgba(0, 0, 0, 0.75);
        }

        .learning-course, .invite-friends {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 10px;
        }

    </style>
@endsection

@section('pageContent')
    <div class="wrapper">
        @include('frontend.includes.sidebar')

        <div class="page-content">
            <div class="page-title-head d-flex align-items-center gap-2">
                <div class="flex-grow-1">
                    <h4 style="color: #9A52FF; font-weight: 700;">Hi {{ $user->name }}</h4>
                    <h2 class=" fw-bold mb-0" style="color: #5D29A6;">
                        {{ $breadcrumb }}
                    </h2>
                </div>
                <div class="text-end">
                    <div class="button-group">
                        <button class="btn btn-purple">Schedule session</button>
                        <button class="btn btn-black">Find Mentors</button>
                    </div>
                </div>
            </div>


            <div class="dashboard-section">
                <div class="dashboard-box">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card p-2">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-extrabold">Quick start</h3>
                                </div>
                                <p class="text-sm text-gray-500 mb-1">Lorem ipsum dolor sit amet consectetur. Turpis
                                    consectetur</p>
                                <div class="row">
                                    <div class="col-lg-10">
                                        <br>
                                        <div class="progress mb-2" style="height: 3px;">
                                            <div class="progress-bar" role="progressbar"
                                                 style="width: 25%; height: 20px;" aria-valuenow="25" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <span class="badge badge-soft-primary">1/5 completed</span>
                                    </div>

                                    <div class="step-container">
                                        <div class="step">
                                            <input type="checkbox" id="step1"
                                                {{ $user->email_verified_at ? 'checked' : '' }}>
                                            <label for="step1"
                                                   @if($user->email_verified_at) style="text-decoration: line-through; color: black;" @endif>
                                                Email Verification
                                            </label>
                                        </div>

                                        @php
                                            $info = $user->information;

                                            // Define which fields must be filled for the profile to count as "complete"
                                            $requiredFields = [
                                                'about',
                                                'profile_photo',
                                                'state',
                                                'country',
                                                'address',
                                                'city',
                                            ];

                                            // Check if all required fields are filled
                                            $profileCompleted = collect($requiredFields)->every(fn($field) => !empty($info->$field));
                                        @endphp

                                        <div class="step">
                                            <input type="checkbox" id="step2"
                                                   {{ $profileCompleted ? 'checked' : '' }}
                                                   onchange="if(this.checked) window.location.href='{{ route('frontend.profile') }}'">

                                            <label for="step2"
                                                   @if($profileCompleted) style="text-decoration: line-through; color: gray;" @endif>
                                                Start building your profile
                                            </label>
                                        </div>

                                        <div class="step">
                                            <input type="checkbox" id="step3">
                                            <label for="step3">Enroll in your first mentoring session</label>
                                        </div>

                                        <div class="step">
                                            <input type="checkbox" id="step4">
                                            <label for="step4">Enroll in your first learning course</label>
                                        </div>
                                    </div>


                                    <div class="suggested_mentors mt-4">

                                        <div class="page-title-head d-flex align-items-center gap-2">
                                            <div class="flex-grow-1">
                                                <h4 class="mb-2">Our top Mentors</h4>
                                            </div>
                                            <div class="text-end">
                                                <div class="button-group">
                                                    <a href="{{ route('frontend.mentee.mentors') }}" class="btn btn-ghost-secondary" style="color: #5D29A6">View
                                                        all</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="top_mentors">
                                            <div class="slider top-mentors-items">
                                                @foreach($mentorsList as $mentor)
                                                    <div>
                                                        <div
                                                            class="container d-flex justify-content-center master-class-div">
                                                            <div class="card mentors-card">
                                                                <div class="card-img-top position-relative">
                                                                    <img
                                                                        src="{{ Storage::disk('public_users_profile')->url($mentor->information->profile_photo ?? '') }}"
                                                                        class="img-fluid rounded slick-poster-image"
                                                                        alt="{{ $mentor->name }}"/>

                                                                </div>
                                                                <div class="card-body">
                                                                    <a href="{{ route('frontend.mentee.mentor.detail', ['mentor_id' => $mentor->user_slug]) }}">
                                                                        <p class="mb-1">{{ $mentor->name }} &nbsp;
                                                                            @if($mentor->information && $mentor->information->country)
                                                                                @php
                                                                                    $country = $mentor->information->countryRel;
                                                                                @endphp
                                                                                @if(!empty($country->emoji))
                                                                                    <img src="https://flagcdn.com/24x18/{{ strtolower($country->iso2) }}.png"
                                                                                         alt="{{ $country->name }} flag"
                                                                                         class="me-1 countryFlag"
                                                                                         width="20" height="15">
                                                                                @endif
                                                                                <span>{{ $country->iso2 }}</span>
                                                                            @endif
                                                                        </p>

                                                                        <p class="badge bg-secondary text-purple">
                                                                            @foreach($mentor->roles as $role)
                                                                                {{ $role->name }}@if(!$loop->last) + @endif
                                                                            @endforeach
                                                                        </p>

                                                                        <p class="card-text text-muted">
                                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M6.66667 5.83333V4.16667C6.66667 3.72464 6.84226 3.30072 7.15482 2.98816C7.46738 2.67559 7.89131 2.5 8.33333 2.5H11.6667C12.1087 2.5 12.5326 2.67559 12.8452 2.98816C13.1577 3.30072 13.3333 3.72464 13.3333 4.16667V5.83333M10 10V10.0083M2.5 7.5C2.5 7.05797 2.67559 6.63405 2.98816 6.32149C3.30072 6.00893 3.72464 5.83333 4.16667 5.83333H15.8333C16.2754 5.83333 16.6993 6.00893 17.0118 6.32149C17.3244 6.63405 17.5 7.05797 17.5 7.5V15C17.5 15.442 17.3244 15.866 17.0118 16.1785C16.6993 16.4911 16.2754 16.6667 15.8333 16.6667H4.16667C3.72464 16.6667 3.30072 16.4911 2.98816 16.1785C2.67559 15.866 2.5 15.442 2.5 15V7.5Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                <path d="M2.5 10.8333C4.82632 12.0055 7.39502 12.6161 10 12.6161C12.605 12.6161 15.1737 12.0055 17.5 10.8333" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                                                                            </svg>
                                                                            {{ $mentor->information->your_level }} {{ $mentor->information->organization_name }}
                                                                        </p>

                                                                        <ul class="list-inline d-flex gap-3" style="color: #5D29A6">
                                                                            @foreach($mentor->skills->take(2) as $skill)
                                                                                <li class="badge-soft-secondary p-1 rounded">{{ $skill->name }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card dashboard-right-panel p-2">
                                <div class="upcoming-event-view mb-4">
                                    <img src="{{ asset('frontend/assets/images/sections/upcoming-events.png') }}"
                                         style="width: 100%">
                                </div>

                                <div class="learning-course mt-4">
                                    <div class="d-flex align-items-center gap-2 mb-4">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-2">Learning courses</h4>
                                        </div>
                                        <div class="text-end">
                                            <div class="button-group">
                                                <a href="" class="btn btn-ghost-secondary" style="color: #5D29A6">View
                                                    all</a>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card masterclass-card">
                                        <div class="card-img-top position-relative">
                                            <img
                                                src="{{ asset('frontend/assets/images/sections/learning-course.png') }}"
                                                class="img-fluid" style="width: 100%">

                                        </div>
                                        <div class="card-body">
                                            <a href=""
                                               tabindex="0">
                                                <p class="mb-1">Sep 29, 5:12pm
                                                    (GMT +05:30
                                                    )</p>
                                                <h5 class="card-title mb-1">
                                                    Project Management
                                                    <span class="badge bg-secondary text-purple ms-2">50000.00</span>
                                                </h5>
                                                <p class="card-text text-muted">
                                                    Learn How to manage Projects
                                                </p>
                                            </a>
                                        </div>
                                        <div
                                            class="card-footer d-flex justify-content-between align-items-center bg-white">
                                    <span class="icon-text">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
<path
    d="M10 0.625C15.1777 0.625 19.375 4.82233 19.375 10C19.375 15.1777 15.1777 19.375 10 19.375C4.82233 19.375 0.625 15.1777 0.625 10C0.625 4.82233 4.82233 0.625 10 0.625Z"
    stroke="#5D29A6" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M10.364 5.09277V10.5473L14.0004 12.3655" stroke="#F2B035" stroke-width="1.13636" stroke-linecap="round"
      stroke-linejoin="round"></path>
</svg>
                                            4 hrs</span>
                                            <span class="icon-text">
                                        <svg width="21" height="19" viewBox="0 0 21 19" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
<path
    d="M7.26542 16.6393L5.86662 17.6556C5.2842 18.0788 4.50055 17.5094 4.72302 16.8247L6.33154 11.8742C6.43103 11.568 6.32204 11.2326 6.06157 11.0433L1.85039 7.98371C1.26797 7.56055 1.5673 6.63932 2.28721 6.63932H7.49251C7.81447 6.63932 8.09981 6.43201 8.1993 6.12581L9.80783 1.17527C10.0303 0.490589 10.9989 0.490589 11.2214 1.17527L12.8299 6.12581C12.9294 6.43201 13.2148 6.63932 13.5367 6.63932H18.742C19.4619 6.63932 19.7613 7.56056 19.1788 7.98371L14.9677 11.0433C14.7072 11.2326 14.5982 11.568 14.6977 11.8742L16.3062 16.8247C16.5287 17.5094 15.745 18.0788 15.1626 17.6556L10.9514 14.596C10.691 14.4068 10.3383 14.4068 10.0778 14.596L9.70232 14.8688L9.38025 15.1028"
    stroke="#F2B035" stroke-width="1.25" stroke-linecap="round"></path>
</svg>
                                            4.5</span>
                                            <span class="icon-text">
                                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
<circle cx="6.59346" cy="4.12275" r="2.40791" stroke="#5D29A6" stroke-width="1.07143"></circle>
<path
    d="M7.91917 18.9062C8.20283 18.8221 8.36461 18.524 8.28051 18.2403C8.19641 17.9566 7.89829 17.7948 7.61462 17.8789L7.91917 18.9062ZM10.5576 11.9614H10.0218V14.4883H10.5576H11.0933V11.9614H10.5576ZM2.63477 14.5863H3.17048V11.9614H2.63477H2.09905V14.5863H2.63477ZM7.74308 18.3996L7.89535 18.9132L7.91917 18.9062L7.76689 18.3926L7.61462 17.8789L7.59081 17.886L7.74308 18.3996ZM2.63477 14.5863H2.09905C2.09905 17.0789 4.11964 19.0994 6.61217 19.0994V18.5637V18.028C4.71137 18.028 3.17048 16.4871 3.17048 14.5863H2.63477ZM6.61217 18.5637V19.0994C7.04663 19.0994 7.47881 19.0367 7.89535 18.9132L7.74308 18.3996L7.59081 17.886C7.27313 17.9802 6.94351 18.028 6.61217 18.028V18.5637ZM10.5576 14.4883H10.0218C10.0218 15.5873 9.53963 16.6308 8.70273 17.3431L9.04993 17.751L9.39712 18.159C10.4732 17.2432 11.0933 15.9014 11.0933 14.4883H10.5576ZM6.59616 8V8.53571C8.48812 8.53571 10.0218 10.0694 10.0218 11.9614H10.5576H11.0933C11.0933 9.47771 9.07985 7.46429 6.59616 7.46429V8ZM6.59616 8V7.46429C4.11248 7.46429 2.09905 9.47771 2.09905 11.9614H2.63477H3.17048C3.17048 10.0694 4.70421 8.53571 6.59616 8.53571V8Z"
    fill="#5D29A6"></path>
<circle cx="2.40791" cy="2.40791" r="2.40791" transform="matrix(-1 0 0 1 16.334 1.71484)" stroke="#5D29A6"
        stroke-width="1.07143"></circle>
<path
    d="M12.6043 18.9062C12.3206 18.8221 12.1588 18.524 12.2429 18.2403C12.327 17.9566 12.6252 17.7948 12.9088 17.8789L12.6043 18.9062ZM9.96587 11.9614H10.5016V14.4883H9.96587H9.43016V11.9614H9.96587ZM17.8887 14.5863H17.353V11.9614H17.8887H18.4244V14.5863H17.8887ZM12.7804 18.3996L12.6281 18.9132L12.6043 18.9062L12.7565 18.3926L12.9088 17.8789L12.9326 17.886L12.7804 18.3996ZM17.8887 14.5863H18.4244C18.4244 17.0789 16.4038 19.0994 13.9113 19.0994V18.5637V18.028C15.8121 18.028 17.353 16.4871 17.353 14.5863H17.8887ZM13.9113 18.5637V19.0994C13.4768 19.0994 13.0446 19.0367 12.6281 18.9132L12.7804 18.3996L12.9326 17.886C13.2503 17.9802 13.5799 18.028 13.9113 18.028V18.5637ZM9.96587 14.4883H10.5016C10.5016 15.5873 10.9838 16.6308 11.8207 17.3431L11.4735 17.751L11.1263 18.159C10.0502 17.2432 9.43016 15.9014 9.43016 14.4883H9.96587ZM13.9273 8V8.53571C12.0353 8.53571 10.5016 10.0694 10.5016 11.9614H9.96587H9.43016C9.43016 9.47771 11.4436 7.46429 13.9273 7.46429V8ZM13.9273 8V7.46429C16.411 7.46429 18.4244 9.47771 18.4244 11.9614H17.8887H17.353C17.353 10.0694 15.8192 8.53571 13.9273 8.53571V8Z"
    fill="#5D29A6"></path>
</svg> 2200 learners</span>
                                        </div>
                                    </div>

                                </div>


                                <div class="invite-friends mt-4 mb-4">
                                    <h4 class="mb-2">Invite Friends</h4>
                                    <form id="invite-friends mt-4">
                                        <input type="email" class="form-control">
                                        <button class="btn btn-purple mt-2" style="width: 100%;">Schedule session
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>

    @if(!$user->goals || $user->goals->isEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let modal = new bootstrap.Modal(document.getElementById('addGoalModal'));
                modal.show();
            });
        </script>
    @endif

    <!-- Add Skill Modal -->
    <div class="modal fade" id="addGoalModal" tabindex="-1" aria-labelledby="addGoalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGoalModalLabel"><i class="bi bi-lightbulb"></i> Add Your Goals</h5>
                </div>
                <div class="modal-body">
                    <div class="skill-checkbox-grid mt-3">
                        @foreach($goals as $goal)
                            <div class="col">
                                <label class="skill-check-btn w-100">
                                    <input type="checkbox" class="goal-checkbox" name="goals[]" value="{{ $goal->id }}">
                                    <span class="btn-label">{{ $goal->name }}</span>
                                    <span class="tick-mark"></span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-danger skill-error pt-2" style="display:none;">
                        Please select at least 3 goals to continue.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Skip</button>
                    <button type="button" id="saveGoalsBtn" class="btn btn-primary">Save Goals</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascripts')
    <script>
        $(".top-mentors-items").slick({
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 3,
            slidesToScroll: 3
        });

        $(document).ready(function () {
            $('#saveGoalsBtn').on('click', function () {
                let selectedGoals = [];

                $('.goal-checkbox:checked').each(function () {
                    selectedGoals.push($(this).val());
                });

                // Validate - must select at least 3
                if (selectedGoals.length < 3) {
                    $('.skill-error').show();
                    return;
                } else {
                    $('.skill-error').hide();
                }

                // Disable button to prevent double click
                let btn = $(this);
                btn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: "{{ route('frontend.user.save.goals') }}",  // 👈 Define this route
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        goals: selectedGoals
                    },
                    success: function (response) {
                        btn.prop('disabled', false).text('Save Goals');

                        if (response.success) {
                            // Optionally show a success alert or toast
                            alert('Goals saved successfully!');
                            $('#addGoalModal').modal('hide');
                        } else {
                            alert(response.message || 'Something went wrong!');
                        }
                    },
                    error: function (xhr) {
                        btn.prop('disabled', false).text('Save Goals');
                        alert('Server error! Please try again.');
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
