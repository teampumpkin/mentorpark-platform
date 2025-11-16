<x-app-layout>
    <!-- Breadcrumb Start-->
    <x-slot name="header">
        <div class="page-title-head d-flex align-items-center gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-bold mb-0">{{ $breadcrumb }}</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0 fs-13">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    {{--            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>--}}
                    <li class="breadcrumb-item active">{{ $breadcrumb }}</li>
                </ol>
            </div>
        </div>
    </x-slot>
    <!-- Breadcrumb End-->

    <!-- Page Content Start -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="container">
                    <div class="row">
                        <!-- Left Column: User Details -->
                        <div class="col-lg-8">
                            <div class="d-flex align-items-end">
                                <!-- Profile Picture & Badge -->
                                <div class="profile-picture-container">
                                    <img src="{{ $user->information->profile_photo ? asset('storage/' . $user->information->profile_photo) : 'https://placehold.co/150x150/png' }}"
                                         alt="{{ $user->name }}" class="rounded-circle profile-picture">


                                    @if(!empty($user->information?->user_type))
                                        @foreach($user->information->user_type as $type)
                                            <span class="badge text-bg-secondary">{{ $type }}</span>
                                        @endforeach
                                    @endif

                                    {{-- Conditionally show Top Mentor badge --}}
                                </div>

                                <!-- Social Links -->
                                <div class="ms-auto social-links mb-3">
                                    @if($user->information?->linkedin)
                                        <a href="{{ $user->information->linkedin }}" target="_blank"><i data-lucide="linkedin"></i></a>
                                    @endif
                                    @if($user->information?->twitter)
                                        <a href="{{ $user->information->twitter }}" target="_blank"><i data-lucide="x"></i></a>
                                    @endif
                                </div>
                            </div>

                            <!-- User Info Text -->
                            <div class="mt-3">
                                <h1 class="mb-0">{{ $user->name }}</h1>
                                <p class="text-muted fs-5">{{ $user->information?->job_title ?? 'No designation provided' }}</p>
                                <p class="mt-3">{{ $user->information?->about ?? 'No description available.' }}</p>

                                <ul class="list-unstyled text-muted mt-4">
                                    <li class="d-flex align-items-center mb-2">
                                        <i data-lucide="map"></i>
                                        <span class="ms-2">{{ $user->information?->state ?? '' }}, {{ $user->information?->country ?? '' }}</span>
                                    </li>

                                    <li class="d-flex align-items-center mb-2">
                                        <i data-lucide="clock"></i> &nbsp;
                                        @if($user->last_login_at)
                                            Active {{ $user->last_login_at->diffForHumans() }}
                                        @else
                                            Never logged in
                                        @endif
                                    </li>
                                </ul>

                                <!-- Skills -->
                                <div class="mt-4">
                                    <h4>Skills</h4>
                                    @if(!empty($user->skills))
                                        @foreach($user->skills as $skill)
                                            <span class="badge badge-soft-success">{{ $skill->name }}</span>
                                        @endforeach
                                    @else
                                        <p>No skills listed.</p>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <h4>Goals</h4>
                                    @if(!empty($user->goals))
                                        <ul>
                                        @foreach($user->goals as $goal)
                                                <li>{{ $goal->name }}</li>
                                        @endforeach
                                        </ul>
                                    @else
                                        <p>No goals listed.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Sessions Card -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Tabs -->
                                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                       {{-- <li class="nav-item">
                                            <a href="#plans" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                                Mentorship plans
                                            </a>
                                        </li>--}}
                                        <li class="nav-item">
                                            <a href="#sessions" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                                Sessions
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- Tab Content -->
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="sessions">
                                            <div class="form-check session-card p-3 mb-2 active">
                                                <input class="form-check-input" type="radio" name="session" id="session1" checked>
                                                <label class="form-check-label w-100" for="session1">
                                                    <span class="d-block fw-bold">Introductory Call</span>
                                                    <span class="d-block text-muted small">30 minutes, $60 per session</span>
                                                </label>
                                            </div>
                                            <div class="form-check session-card p-3 mb-2">
                                                <input class="form-check-input" type="radio" name="session" id="session2">
                                                <label class="form-check-label w-100" for="session2">
                                                    <span class="d-block fw-bold">Resume Feedback</span>
                                                    <span class="d-block text-muted small">30 minutes, $89 per session</span>
                                                </label>
                                            </div>
                                            <div class="form-check session-card p-3 mb-2">
                                                <input class="form-check-input" type="radio" name="session" id="session3">
                                                <label class="form-check-label w-100" for="session3">
                                                    <span class="d-block fw-bold">Interview Preparation</span>
                                                    <span class="d-block text-muted small">60 minutes, $149 per session</span>
                                                </label>
                                            </div>
                                            <div class="form-check session-card p-3 mb-2">
                                                <input class="form-check-input" type="radio" name="session" id="session4">
                                                <label class="form-check-label w-100" for="session4">
                                                    <span class="d-block fw-bold">Ask Me Anything - 60 Minutes</span>
                                                    <span class="d-block text-muted small">60 minutes, $189 per session</span>
                                                </label>
                                            </div>

                                            <div class="d-grid gap-2 mt-4">
                                                <button class="btn btn-success btn-lg" type="button">Book now</button>
                                                <button class="btn btn-light btn-lg" type="button">View all sessions</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end container -->
            </div>
        </div>
    </div>
    <!-- Page Content End -->


</x-app-layout>
