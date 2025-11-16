@extends('frontend.layouts.app')

@section('stylesheets')
    <style>
        .button-group {
            display: flex;
            gap: 12px;
            justify-content: flex-start;
            align-items: center;
            margin: 20px 0;
        }
        .btn-black {
            background-color: #000000;
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
            background-color: #6a1b9a;
        }

        .mentor-profile-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50px;
        }

        .title-text {
            font-size: 20px;
            font-weight: 700;
        }
    </style>

@endsection

@section('pageContent')
    <div class="wrapper">
        @include('frontend.includes.sidebar')
        <div class="page-content">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <!-- Profile Image -->
                    <img
                        src="{{ Storage::disk('public_users_profile')->url($mentorDetail->information->profile_photo) }}"
                        alt="{{ $mentorDetail->name }}"
                        class="rounded-circle"
                        style="width:80px; height:80px; object-fit:cover;">

                    <!-- Country, Name, Role -->
                    <div>
                        <div class="d-flex align-items-center gap-1">
                            @if($mentorDetail->information && $mentorDetail->information->countryRel)
                                @php $country = $mentorDetail->information->countryRel; @endphp
                                @if(!empty($country->iso2))
                                    <img src="https://flagcdn.com/24x18/{{ strtolower($country->iso2) }}.png"
                                         alt="{{ $country->name }}"
                                         width="20" height="15"
                                         class="rounded">
                                    <span class="text-muted fw-semibold small">{{ strtoupper($country->iso2) }}</span>
                                @endif
                            @endif
                            <span class="fw-semibold ms-1" style="font-size:16px;">{{ $mentorDetail->name }}</span>

                            <!-- LinkedIn -->
                            @if(!empty($mentorDetail->information->linkedin))
                                <a href="{{ $mentorDetail->information->linkedin }}" target="_blank" class="ms-2">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#0A66C2"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M18.375 0H5.625C2.518 0 0 2.518 0 5.625v12.75C0 21.482 2.518 24 5.625 24h12.75C21.482 24 24 21.482 24 18.375V5.625C24 2.518 21.482 0 18.375 0ZM7.337 20.408H4.215V9.531h3.122v10.877ZM5.776 8.163a1.806 1.806 0 1 1 0-3.612 1.806 1.806 0 0 1 0 3.612ZM20.437 20.408h-3.12v-5.571c0-1.33-.026-3.04-1.85-3.04-1.85 0-2.135 1.446-2.135 2.939v5.672h-3.12V9.531h2.993v1.483h.042c.417-.79 1.435-1.622 2.955-1.622 3.16 0 3.74 2.081 3.74 4.785v6.231Z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                        <small
                            class="text-muted d-block mt-1">{{ $mentorDetail->information->your_level }} {{ $mentorDetail->information->organization_name }}</small>
                    </div>
                </div>

                <div>
                    <a href="#" class="btn btn-sm btn-black px-3">Request a program</a>
                    <a href="#" class="btn btn-sm btn-purple px-3">Book a session</a>
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
                                        <span class="d-none d-md-inline-block">About</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#profile-b1" data-bs-toggle="tab" aria-expanded="false"
                                       class="nav-link">
                                        <span class="d-none d-md-inline-block">Reviews</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#settings-b1" data-bs-toggle="tab" aria-expanded="false"
                                       class="nav-link">
                                        <span class="d-none d-md-inline-block">Master classes</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="col-lg-8">
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="home-b1">
                                        <div class="row">


                                            <div class="bg-opacity-50 p-2 p-lg-4 profile-box">

                                                <div class="col-md-12 mt-3">
                                                    <h4 class="heading-title font-bold">Experience</h4>
                                                    <p>{{ $mentorDetail->information->additional_description ?? '' }}</p>
                                                </div>
                                                @if(!empty($mentorDetail->skills))
                                                    <div class="col-md-12 mt-3">
                                                        <h4 class="heading-title font-bold">Skills</h4>
                                                        <ul class="d-flex gap-2 list-unstyled p-0 m-0 flex-wrap">

                                                            @foreach($mentorDetail->skills as $skill)
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
                                                            class="text-muted">{{ $mentorDetail->information->address ?? '' }}</small>
                                                    </p>
                                                    <p class="card-text"><small
                                                            class="text-muted">{{ $mentorDetail->information->stateRel->name ?? '' }}
                                                            , {{ $mentorDetail->information?->countryRel->name ?? '' }}</small>
                                                    </p>
                                                </div>

                                                <div class="col-md-12 mt-3">
                                                    <h4 class="heading-title font-bold">Email</h4>
                                                    <p class="card-text"><small
                                                            class="text-muted">{{ $mentorDetail->email }}</small></p>
                                                </div>


                                            </div>
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
                            </div>

                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col -->

            </div>


        </div>
    </div>

@endsection

@section('javascripts')


@endsection
