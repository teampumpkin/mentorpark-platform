@extends('frontend.layouts.app')

@section('stylesheets')


@endsection

@section('pageContent')
    <div class="wrapper">
        @include('frontend.includes.sidebar')

        <div class="page-content">
            <div class="row">
                <div class="page-header-bar">
                    <div>
                        <h2 class="page-title">{{ $breadcrumb }}</h2>
                        {{--<span class="page-desc">Lorem ipsum dolor</span>--}}
                    </div>
                    <button class="page-edit-btn btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editUserModal">
                        Edit&nbsp;
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                             style="vertical-align:middle;" viewBox="0 0 20 20">
                            <path fill="currentColor"
                                  d="M14.846 2.648a2.313 2.313 0 1 1 3.272 3.272l-1.004 1.004-3.273-3.272 1.005-1.004zm-2.01 2.009l3.272 3.272-8.828 8.828H4.01v-3.273l8.827-8.827z"/>
                        </svg>
                    </button>

                </div>
            </div>


            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">

                            <ul class="nav nav-tabs nav-bordered mb-3">
                                <li class="nav-item">
                                    <a href="#home-b1" data-bs-toggle="tab" aria-expanded="true"
                                       class="nav-link active">
                                        <span class="d-none d-md-inline-block">Profile</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#profile-b1" data-bs-toggle="tab" aria-expanded="false"
                                       class="nav-link">
                                        <span class="d-none d-md-inline-block">Acheivement</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#settings-b1" data-bs-toggle="tab" aria-expanded="false"
                                       class="nav-link">
                                        <span class="d-none d-md-inline-block">Leaderboard</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane show active" id="home-b1">
                                    <div class="row">
                                        @if(isset($user->information) && !empty($user->information))
                                            <div class="col-md-8">
                                                <div class="bg-opacity-50 p-2 p-lg-4 profile-box">
                                                    <div class="row g-0 align-items-center account-profile">
                                                        <div class="col-md-2">
                                                            <img
                                                                src="{{ Storage::disk('public_users_profile')->url($user->information->profile_photo ?? '') }}"
                                                                class="img-fluid profile-image" alt="...">
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="card-body">
                                                                <h3 class="heading-title font-extrabold">{{ $user->name }}</h3>
                                                                <p class="card-text"><small
                                                                        class="text-muted">{{ $user->information->job_title ?? '' }}</small>
                                                                </p>

                                                                <ul class="d-flex gap-2 list-unstyled p-0 m-0">
                                                                    @if(!empty($user->information?->user_type))
                                                                        @foreach($user->information->user_type as $type)
                                                                            <li>
                                                                                <span
                                                                                    class="badge text-bg-brand rounded-pill">{{ $type }}</span>
                                                                            </li>
                                                                        @endforeach
                                                                    @endif
                                                                </ul>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mt-3">
                                                            <h4 class="heading-title font-bold">Experience</h4>
                                                            <p>{{ $user->information->additional_description ?? '' }}</p>
                                                        </div>

                                                        <div class="col-md-12 mt-3">
                                                            <h4 class="heading-title font-bold">About me</h4>
                                                            <p>{{ $user->information->about  ?? '' }}</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <div class="bg-opacity-50 p-2 p-lg-4 profile-box">
                                                    @if(!empty($user->skills))
                                                        <div class="col-md-12 mt-3">
                                                            <h4 class="heading-title font-bold">Skills</h4>
                                                            <ul class="d-flex gap-2 list-unstyled p-0 m-0 flex-wrap">

                                                                @foreach($user->skills as $skill)
                                                                    <li>
                                                                        <span
                                                                            class="badge badge-outline-primary">{{ $skill->name }}</span>
                                                                    </li>
                                                                @endforeach

                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <div class="col-md-12 mt-3">
                                                        <h4 class="heading-title font-bold">Location</h4>
                                                        <p class="card-text"><small
                                                                class="text-muted">{{ $user->information->address ?? '' }}</small>
                                                        </p>
                                                        <p class="card-text"><small
                                                                class="text-muted">{{ $user->information->stateRel->name ?? '' }}
                                                                , {{ $user->information?->countryRel->name ?? '' }}</small>
                                                        </p>
                                                    </div>

                                                    <div class="col-md-12 mt-3">
                                                        <h4 class="heading-title font-bold">Email</h4>
                                                        <p class="card-text"><small
                                                                class="text-muted">{{ $user->email }}</small></p>
                                                    </div>

                                                    <div class="col-md-12 mt-3">
                                                        <h4 class="heading-title font-bold">Social Links</h4>
                                                        <ul class="d-flex flex-wrap gap-2 list-unstyled p-0 m-0 align-items-center">
                                                            @php
                                                                $socialLinks = [
                                                                    'linkedin'  => [
                                                                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-linkedin"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>',
                                                                        'label' => 'linkedin'
                                                                    ],
                                                                    'twitter'   => [
                                                                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-twitter"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>',
                                                                        'label' => 'twitter'
                                                                    ],
                                                                    'facebook'  => [
                                                                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
                                                                        'label' => 'facebook'
                                                                    ],
                                                                    'instagram' => [
                                                                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-instagram"><rect width="18" height="18" x="3" y="3" rx="4"/><circle cx="12" cy="12" r="3"/><path d="M17.5 6.5v.01"/></svg>',
                                                                        'label' => 'instagram'
                                                                    ],
                                                                    'youtube'   => [
                                                                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-youtube"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/></svg>',
                                                                        'label' => 'youtube'
                                                                    ],
                                                                    'website'   => [
                                                                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10A15.3 15.3 0 0 1 8 12 15.3 15.3 0 0 1 12 2z"/></svg>',
                                                                        'label' => 'website'
                                                                    ],
                                                                ];
                                                            @endphp

                                                            @foreach($socialLinks as $slug => $item)
                                                                @if(!empty($user->information?->{$slug}))
                                                                    <li>
                                                                        <a href="{{ $user->information->{$slug} }}"
                                                                           target="_blank" rel="noopener"
                                                                           class="text-decoration-none d-flex align-items-center gap-1 text-primary"
                                                                           style="min-width: 100px;">
                                                                            {!! $item['icon'] !!}
                                                                            <span class="fw-semibold text-capitalize"
                                                                                  style="margin-left: 4px;">{{ $item['label'] }}</span>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>

                                                    </div>

                                                </div>
                                            </div>

                                        @endif
                                    </div>

                                </div>
                                <div class="tab-pane" id="profile-b1">
                                    <p class="mb-0"><span
                                            class="px-1 rounded me-1 fw-semibold d-inline-block bg-danger-subtle text-danger float-start">P</span>
                                        "Hi there! I'm a passionate individual who loves to explore new ideas and
                                        connect with like-minded people. My interests span a wide range of topics
                                        including technology, literature, travel, and fitness. I believe in the
                                        power of continuous learning and enjoy challenging myself to grow both
                                        personally and professionally.</p>
                                </div>
                                <div class="tab-pane" id="settings-b1">
                                    <p class="mb-0"><span
                                            class="px-1 rounded me-1 fw-semibold d-inline-block bg-secondary-subtle text-secondary float-start">S</span>In
                                        the heart of a bustling city lies a quaint little cafe, nestled between
                                        towering skyscrapers and historic buildings. Its cozy interior boasts warm,
                                        earthy tones accented with splashes of vibrant colors, creating a welcoming
                                        atmosphere that beckons passersby to step inside.</p>
                                </div>
                            </div>

                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col -->

            </div>
        </div>

        <div class="modal fade " id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-body">
                        <form id="userInformationForm" class="mt-4" method="POST"
                              action="{{ route('frontend.update.profile') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                       value="{{ old('first_name', $user->first_name) }}"
                                       placeholder="Enter first name" required>
                                @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                       value="{{ old('last_name', $user->last_name) }}"
                                       placeholder="Enter last name" required>
                                @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ old('email', $user->email) }}" placeholder="Enter email" required>
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile"
                                       value="{{ old('mobile', $user->mobile) }}" placeholder="Enter mobile number"
                                       required>
                                @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password field optional for update -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Leave empty to keep current password">
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="user_types" class="form-label">Organization</label>
                                <select class="form-control select2" name="organization_id" id="organization_id">
                                    <option value="">Select Organization</option>
                                    @foreach($organizations as $organization)
                                        <option
                                            value="{{ $organization->id ?? '' }}"
                                            {{ isset($user->information) && $user->information->organization_id == $organization->id ? 'selected' : '' }}>
                                            {{ $organization->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('organization_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="about" class="form-label">About</label>
                                <textarea class="form-control" id="about" name="about" rows="3"
                                          placeholder="Tell us about yourself"
                                          required>{{ old('about', $user->information->about ?? '') }}</textarea>
                                @error('about')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="additional_description" class="form-label">Experience</label>
                                <textarea class="form-control" id="additional_description" name="additional_description"
                                          rows="3" placeholder="Tell us about your experience"
                                          required>{{ old('additional_description', $user->information->additional_description ?? '') }}</textarea>
                                @error('about')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="job_title" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="job_title" name="job_title"
                                       value="{{ old('job_title', $user->information->job_title ?? '') }}"
                                       placeholder="Enter job title" required>
                                @error('job_title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="total_experience" class="form-label">Total Experience (in years)</label>
                                <input type="text" class="form-control" id="total_experience" name="total_experience"
                                       value="{{ old('total_experience', $user->information->total_experience ?? '') }}"
                                       placeholder="Enter total experience" required>
                                @error('total_experience')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Skills -->
                            <div class="mb-3">
                                <label for="skills" class="form-label">Skills</label>
                                <select class="form-control select2 skills-select" name="skills[]" id="skills"
                                        data-toggle="select2" multiple required>
                                    <option value="">Select</option>
                                    @foreach($skills as $skill)
                                        <option value="{{ $skill->id }}"
                                                @if(in_array($skill->id, old('skills', $user->skills->pluck('id')->toArray()))) selected @endif>
                                            {{ $skill->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('skills')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Goals -->
                            <div class="mb-3">
                                <label for="goals" class="form-label">Goal</label>
                                <select class="form-control select2 goals-select" name="goals[]" id="goals"
                                        data-toggle="select2" multiple required>
                                    <option value="">Select</option>
                                    @foreach($goals as $goal)
                                        <option value="{{ $goal->id }}"
                                                @if(in_array($goal->id, old('goals', $user->goals->pluck('id')->toArray()))) selected @endif>
                                            {{ $goal->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('goals')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Social Media Links -->
                            <div class="mb-3">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="url" class="form-control" id="linkedin" name="linkedin"
                                       value="{{ old('linkedin', $user->information->linkedin ?? '') }}"
                                       placeholder="Enter LinkedIn URL">
                                @error('linkedin')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="url" class="form-control" id="twitter" name="twitter"
                                       value="{{ old('twitter', $user->information->twitter ?? '') }}"
                                       placeholder="Enter Twitter URL">
                                @error('twitter')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="url" class="form-control" id="facebook" name="facebook"
                                       value="{{ old('facebook', $user->information->facebook ?? '') }}"
                                       placeholder="Enter Facebook URL">
                                @error('facebook')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="url" class="form-control" id="instagram" name="instagram"
                                       value="{{ old('instagram', $user->information->instagram ?? '') }}"
                                       placeholder="Enter Instagram URL">
                                @error('instagram')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="youtube" class="form-label">YouTube</label>
                                <input type="url" class="form-control" id="youtube" name="youtube"
                                       value="{{ old('youtube', $user->information->youtube ?? '') }}"
                                       placeholder="Enter YouTube URL">
                                @error('youtube')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Profile Photo Upload -->
                            <div class="mb-3">
                                <label for="profile_photo" class="form-label">Profile Photo (Max 1.5MB)</label>
                                <input type="file" class="form-control" id="profile_photo" name="profile_photo"
                                       accept="image/*">
                                @error('profile_photo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror

                                @if (!empty($user->information?->profile_photo))
                                    <div class="mb-2">
                                        <img
                                            src="{{ Storage::disk('public_users_profile')->url($user->information->profile_photo) }}"
                                            alt="Profile Photo"
                                            class="img-thumbnail"
                                            style="max-height: 120px;">
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3"
                                          required>{{ old('address', $user->information->address ?? '') }}</textarea>
                                @error('country')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>


                            {{--<div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-control @error('country') is-invalid @enderror countryList" data-selected="{{ $user->information->country }}" id="country"
                                            name="country">
                                        <option value="">-- Select Country --</option>
                                    </select>
                                    @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-control @error('state') is-invalid @enderror" data-selected="{{ $user->information->state }}" id="state" name="state">
                                        <option value="">-- Select State --</option>
                                    </select>
                                    @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <select class="form-control cityList @error('city') is-invalid @enderror" data-selected="{{ $user->information->city }}" id="city" name="city">
                                        <option value="">-- Select City --</option>
                                    </select>
                                    @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="postal_code" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                           id="postal_code" name="postal_code" value="{{ old('postal_code', $user->information->postal_code) }}">
                                    @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>--}}

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-control @error('country') is-invalid @enderror countryList"
                                            data-selected="{{ optional($user->information)->country ?? '' }}"
                                            id="country" name="country">
                                        <option value="">-- Select Country --</option>
                                        {{--@foreach($country as $list)
                                            <option value="{{ $list->id }}">{{ $list->name }}</option>
                                        @endforeach--}}
                                    </select>
                                    @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-control @error('state') is-invalid @enderror stateList"
                                            data-selected="{{ optional($user->information)->state ?? '' }}"
                                            id="state" name="state">
                                        <option value="">-- Select State --</option>
                                    </select>
                                    @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <select class="form-control cityList @error('city') is-invalid @enderror cityList"
                                            data-selected="{{ optional($user->information)->city ?? '' }}"
                                            id="city" name="city">
                                        <option value="">-- Select City --</option>
                                    </select>
                                    @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="postal_code" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                           id="postal_code" name="postal_code"
                                           value="{{ old('postal_code', optional($user->information)->postal_code ?? '') }}">
                                    @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="d-grid mt-4">
                                <button type="button" class="btn btn-primary" id="saveProfileBtn">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        @endsection

        @section('javascripts')
            {{--            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
            <script>
                $(document).ready(function () {


                    // Custom validator for file size (2MB)
                    $.validator.addMethod('filesize', function (value, element, param) {
                        if (element.files.length == 0) {
                            return true; // no file selected, so pass
                        }
                        return element.files[0].size <= param; // check size of first selected file
                    }, 'File size must be less than 2MB.');

                    // Attach validation to the form
                    $('#userInformationForm').validate({
                        rules: {
                            first_name: {required: true, minlength: 2},
                            last_name: {required: true, minlength: 2},
                            email: {required: true, email: true},
                            mobile: {required: true},
                            password: {minlength: 6},
                            about: {required: true},
                            job_title: {required: true},
                            total_experience: {required: true},
                            state: {required: true},
                            country: {required: true},
                            address: {required: true},
                            'skills[]': {required: true},
                            'goals[]': {required: true},
                            profile_photo: {
                                extension: "jpeg|png|jpg|gif",
                                //validImage: true,
                                filesize: 2097152
                                // filesize: 1048576 // 1 MB
                            }
                        },
                        messages: {
                            profile_photo: {
                                extension: "Please upload an image (jpeg, jpg, png, gif).",
                                validImage: "Please select a valid image file (jpeg, jpg, png, gif).",
                                filesize: "Image must be less than 2MB."
                            },
                            first_name: {
                                required: "First name is required.",
                                minlength: "First name must be at least 2 characters."
                            },
                            last_name: {
                                required: "Last name is required.",
                                minlength: "Last name must be at least 2 characters."
                            },
                            email: {
                                required: "Email is required.",
                                email: "Please enter a valid email address."
                            },
                            mobile: {required: "Mobile number is required."},
                            password: {minlength: "Password must be at least 6 characters."},
                            about: {required: "Please provide information about yourself."},
                            job_title: {required: "Job title is required."},
                            total_experience: {required: "Total experience is required."},
                            state: {required: "State is required."},
                            country: {required: "Country is required."},
                            address: {required: "Address is required."},
                            'skills[]': {required: "Please select at least one skill."},
                            'goals[]': {required: "Please select at least one goal."}
                        },
                        errorElement: 'div',
                        errorPlacement: function (error, element) {
                            error.addClass('text-danger');
                            if (element.hasClass('select2-hidden-accessible')) {
                                error.insertAfter(element.next('.select2-container'));
                            } else {
                                error.insertAfter(element);
                            }
                        },
                        invalidHandler: function () {
                            console.log("Form validation failed.");
                        },
                        submitHandler: function (form) {
                            console.log("Form validated successfully.");
                            form.submit();
                        }
                    });
					
					
					// Handle Save button click manually
$('#saveProfileBtn').on('click', function (e) {
    e.preventDefault();
	
	console.log('clicked');

    // Run validation
    if ($('#userInformationForm').valid()) {
        // Form is valid → submit form
        $('#userInformationForm').submit();
    } else {
        // Validation failed → keep modal open
        $('#editUserModal').modal('show');
    }
});


                });

            </script>

@endsection
