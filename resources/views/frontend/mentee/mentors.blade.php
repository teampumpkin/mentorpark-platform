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

        .mentor-list .card-body .profile-img {
            border-radius: 50%;
            width: 48px;
            height: 48px;
        }

        .card-img-top img{
            width: 100% !important;
        }

        .mentors-card{
            width: 100% !important;
        }

        .category-slider {
            display: flex;
            overflow-x: auto; /* Enable horizontal scroll */
            overflow-y: hidden; /* Prevent vertical scroll */
            white-space: nowrap; /* Keep buttons in one line */
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch; /* Smooth scroll on iOS */
            cursor: grab; /* Visual cue for drag */
        }

        /* Optional: allow drag scroll on desktop */
        .category-slider:active {
            cursor: grabbing;
        }

        .category-slider::-webkit-scrollbar {
            height: 6px; /* Show thin scrollbar on desktop */
        }

        .category-slider::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 10px;
        }

        .category-slider::-webkit-scrollbar-track {
            background: transparent;
        }

        .category {
            flex: 0 0 auto;
            scroll-snap-align: start;
            border: 1px solid #e5e5e5;
            background: #fff;
            color: #444;
            border-radius: 50px;
            padding: 8px 18px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .category i {
            font-size: 16px;
            color: #888;
        }

        .category:hover {
            background-color: #f7f7f7;
        }

        .category.active {
            background-color: #000;
            color: #fff;
            border-color: #000;
        }

        .category.active i {
            color: #fff;
        }

        .mentor-card{

        }
        .countryFlag{
            width: 18px;
            height: 18px;
            object-fit: cover;
            border-radius: 50px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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
                <div class="text-end">
                    <div class="button-group">

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10">
                    <div class="d-flex justify-content-center">
                        <div class="position-relative w-100">
                <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                    <i class="ri-search-line fs-18"></i>
                </span>
                            <input type="text" id="mentor-search" class="form-control ps-5 py-2 rounded-pill border-light shadow-sm"
                                   placeholder="Search by name or skill">
                            <div id="search-suggestions" class="list-group position-absolute w-100" style="z-index:1000;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>



            <div class="category-slider mt-4">
                <a href="{{ route('frontend.mentee.mentors') }}" class="category active">All</a>
                @foreach($skills as $skill)
                    <a href="{{ route('frontend.mentee.mentors.skill', ['skill' => $skill->name]) }}" class="category">{{ $skill->name }}</a>
                @endforeach
            </div>


            <div class="mentor-list mt-4">
                <div class="row">
                    @forelse($mentorsList as $mentor)
                        <div class="col-md-3">
                            <div class="mentor-card">
                                <div class="container d-flex justify-content-center master-class-div">
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
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center text-muted">No results found.</p>
                        </div>
                    @endforelse

                </div>
            </div>


        </div>
    </div>

@endsection

@section('javascripts')
    <script>
        $(document).ready(function() {
            $('#mentor-search').keyup(function() {
                let query = $(this).val();
                if(query.length > 1){
                    $.ajax({
                        url: "{{ route('frontend.mentee.mentor.search.suggestions') }}",
                        method: 'GET',
                        data: { query: query },
                        success: function(data) {
                            let suggestions = '';
                            if(data.length > 0){
                                data.forEach(function(mentor){
                                    suggestions += `<a href="/mentors?search=${mentor.name}" class="list-group-item list-group-item-action">
                                                ${mentor.name} - ${mentor.skills.join(', ')}
                                            </a>`;
                                });
                            } else {
                                suggestions = '<div class="list-group-item">No results found</div>';
                            }
                            $('#search-suggestions').html(suggestions).show();
                        }
                    });
                } else {
                    $('#search-suggestions').hide();
                }
            });

            // Hide suggestions when clicking outside
            $(document).click(function(e) {
                if(!$(e.target).closest('#mentor-search').length){
                    $('#search-suggestions').hide();
                }
            });
        });
    </script>

@endsection
