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

        .masterclass-card {
            width: 100% !important;
        }

        .master-class-section {
            background: #FFFFFF;
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
                <div class="text-end">

                </div>
            </div>


            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-4">
                                    <div class="published-card">
                                        <div class="card-content">
                                            <div class="icon-area">
                                                <svg width="18" height="22" viewBox="0 0 18 22" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9 8C11.21 8 13 6.21 13 4C13 1.79 11.21 0 9 0C6.79 0 5 1.79 5 4C5 6.21 6.79 8 9 8ZM9 2C10.1 2 11 2.9 11 4C11 5.1 10.1 6 9 6C7.9 6 7 5.1 7 4C7 2.9 7.9 2 9 2ZM9 10.55C6.64 8.35 3.48 7 0 7V18C3.48 18 6.64 19.35 9 21.55C11.36 19.36 14.52 18 18 18V7C14.52 7 11.36 8.35 9 10.55ZM16 16.13C13.47 16.47 11.07 17.43 9 18.95C6.94 17.43 4.53 16.46 2 16.12V9.17C4.1 9.55 6.05 10.52 7.64 12L9 13.28L10.36 12.01C11.95 10.53 13.9 9.56 16 9.18V16.13Z"
                                                        fill="#ffffff"/>
                                                </svg>

                                            </div>
                                            <div class="text-area">
                                                <div class="card-title">Published classes</div>
                                                <div class="card-number">245</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3 mb-4">
                                    <div class="published-card">
                                        <div class="card-content">
                                            <div class="icon-area">
                                                <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="6.59346" cy="4.12275" r="2.40791" stroke="#ffffff"
                                                            stroke-width="1.07143"/>
                                                    <path
                                                        d="M7.91917 18.9062C8.20283 18.8221 8.36461 18.524 8.28051 18.2403C8.19641 17.9566 7.89829 17.7948 7.61462 17.8789L7.91917 18.9062ZM10.5576 11.9614H10.0218V14.4883H10.5576H11.0933V11.9614H10.5576ZM2.63477 14.5863H3.17048V11.9614H2.63477H2.09905V14.5863H2.63477ZM7.74308 18.3996L7.89535 18.9132L7.91917 18.9062L7.76689 18.3926L7.61462 17.8789L7.59081 17.886L7.74308 18.3996ZM2.63477 14.5863H2.09905C2.09905 17.0789 4.11964 19.0994 6.61217 19.0994V18.5637V18.028C4.71137 18.028 3.17048 16.4871 3.17048 14.5863H2.63477ZM6.61217 18.5637V19.0994C7.04663 19.0994 7.47881 19.0367 7.89535 18.9132L7.74308 18.3996L7.59081 17.886C7.27313 17.9802 6.94351 18.028 6.61217 18.028V18.5637ZM10.5576 14.4883H10.0218C10.0218 15.5873 9.53963 16.6308 8.70273 17.3431L9.04993 17.751L9.39712 18.159C10.4732 17.2432 11.0933 15.9014 11.0933 14.4883H10.5576ZM6.59616 8V8.53571C8.48812 8.53571 10.0218 10.0694 10.0218 11.9614H10.5576H11.0933C11.0933 9.47771 9.07985 7.46429 6.59616 7.46429V8ZM6.59616 8V7.46429C4.11248 7.46429 2.09905 9.47771 2.09905 11.9614H2.63477H3.17048C3.17048 10.0694 4.70421 8.53571 6.59616 8.53571V8Z"
                                                        fill="#ffffff"/>
                                                    <circle cx="2.40791" cy="2.40791" r="2.40791"
                                                            transform="matrix(-1 0 0 1 16.334 1.71484)" stroke="#ffffff"
                                                            stroke-width="1.07143"/>
                                                    <path
                                                        d="M12.6043 18.9062C12.3206 18.8221 12.1588 18.524 12.2429 18.2403C12.327 17.9566 12.6252 17.7948 12.9088 17.8789L12.6043 18.9062ZM9.96587 11.9614H10.5016V14.4883H9.96587H9.43016V11.9614H9.96587ZM17.8887 14.5863H17.353V11.9614H17.8887H18.4244V14.5863H17.8887ZM12.7804 18.3996L12.6281 18.9132L12.6043 18.9062L12.7565 18.3926L12.9088 17.8789L12.9326 17.886L12.7804 18.3996ZM17.8887 14.5863H18.4244C18.4244 17.0789 16.4038 19.0994 13.9113 19.0994V18.5637V18.028C15.8121 18.028 17.353 16.4871 17.353 14.5863H17.8887ZM13.9113 18.5637V19.0994C13.4768 19.0994 13.0446 19.0367 12.6281 18.9132L12.7804 18.3996L12.9326 17.886C13.2503 17.9802 13.5799 18.028 13.9113 18.028V18.5637ZM9.96587 14.4883H10.5016C10.5016 15.5873 10.9838 16.6308 11.8207 17.3431L11.4735 17.751L11.1263 18.159C10.0502 17.2432 9.43016 15.9014 9.43016 14.4883H9.96587ZM13.9273 8V8.53571C12.0353 8.53571 10.5016 10.0694 10.5016 11.9614H9.96587H9.43016C9.43016 9.47771 11.4436 7.46429 13.9273 7.46429V8ZM13.9273 8V7.46429C16.411 7.46429 18.4244 9.47771 18.4244 11.9614H17.8887H17.353C17.353 10.0694 15.8192 8.53571 13.9273 8.53571V8Z"
                                                        fill="#ffffff"/>
                                                </svg>

                                            </div>
                                            <div class="text-area">
                                                <div class="card-title">Total Participants</div>
                                                <div class="card-number">40</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3 mb-4">
                                    <div class="published-card">
                                        <div class="card-content">
                                            <div class="icon-area">
                                                <svg width="21" height="19" viewBox="0 0 21 19" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M7.26542 16.6393L5.86662 17.6556C5.2842 18.0788 4.50055 17.5094 4.72302 16.8247L6.33154 11.8742C6.43103 11.568 6.32204 11.2326 6.06157 11.0433L1.85039 7.98371C1.26797 7.56055 1.5673 6.63932 2.28721 6.63932H7.49251C7.81447 6.63932 8.09981 6.43201 8.1993 6.12581L9.80783 1.17527C10.0303 0.490589 10.9989 0.490589 11.2214 1.17527L12.8299 6.12581C12.9294 6.43201 13.2148 6.63932 13.5367 6.63932H18.742C19.4619 6.63932 19.7613 7.56056 19.1788 7.98371L14.9677 11.0433C14.7072 11.2326 14.5982 11.568 14.6977 11.8742L16.3062 16.8247C16.5287 17.5094 15.745 18.0788 15.1626 17.6556L10.9514 14.596C10.691 14.4068 10.3383 14.4068 10.0778 14.596L9.70232 14.8688L9.38025 15.1028"
                                                        stroke="#ffffff" stroke-width="1.25" stroke-linecap="round"/>
                                                </svg>

                                            </div>
                                            <div class="text-area">
                                                <div class="card-title">Avg. Rating</div>
                                                <div class="card-number">4.4</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3 mb-4">
                                    <div class="published-card">
                                        <div class="card-content">
                                            <div class="icon-area">
                                                <svg width="19" height="18" viewBox="0 0 19 18" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M18 4.28V2C18 0.9 17.1 0 16 0H2C0.89 0 0 0.9 0 2V16C0 17.1 0.89 18 2 18H16C17.1 18 18 17.1 18 16V13.72C18.59 13.37 19 12.74 19 12V6C19 5.26 18.59 4.63 18 4.28ZM17 6V12H10V6H17ZM2 16V2H16V4H10C8.9 4 8 4.9 8 6V12C8 13.1 8.9 14 10 14H16V16H2Z"
                                                        fill="#ffffff"/>
                                                </svg>

                                            </div>
                                            <div class="text-area">
                                                <div class="card-title">Revenue this Month</div>
                                                <div class="card-number">15000</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="master-class-section card mt-2">

                <div class="classes-content">
                    <h3 class="m-2">Suggested for you</h3>
                    <div class="slider master-class-items">
                        @foreach($suggested_masterClasses as $class)
                            <div>
                                <div
                                    class="container my-4 d-flex justify-content-center master-class-div">
                                    <div class="card masterclass-card">
                                        <div class="card-img-top position-relative">
                                            <img
                                                src="{{ Storage::disk('master_class_banner_image')->url($class->banner_image) }}"
                                                class="img-fluid rounded slick-poster-image"
                                                alt="{{ $class->title }}"/>

                                        </div>
                                        <div class="card-body">
                                            <a href="{{ route('frontend.master-classes.detail', ['slug' => $class->slug]) }}">
                                                <p class="mb-1">{{ \Carbon\Carbon::parse($class->created_at)->format('M d, g:ia') }}
                                                    (GMT {{ \Carbon\Carbon::parse($class->created_at)->format('P') }}
                                                    )</p>
                                                <h5 class="card-title mb-1">
                                                    {{ $class->title }}
                                                    <span
                                                        class="badge bg-secondary text-purple ms-2">{{ $class->price }}</span>
                                                </h5>
                                                <p class="card-text text-muted">
                                                    {{ \Illuminate\Support\Str::words($class->description, 25, '...') }}
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
    stroke="#5D29A6" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10.364 5.09277V10.5473L14.0004 12.3655" stroke="#F2B035" stroke-width="1.13636" stroke-linecap="round"
      stroke-linejoin="round"/>
</svg>
                                            4 hrs</span>
                                            <span class="icon-text">
                                        <svg width="21" height="19" viewBox="0 0 21 19" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
<path
    d="M7.26542 16.6393L5.86662 17.6556C5.2842 18.0788 4.50055 17.5094 4.72302 16.8247L6.33154 11.8742C6.43103 11.568 6.32204 11.2326 6.06157 11.0433L1.85039 7.98371C1.26797 7.56055 1.5673 6.63932 2.28721 6.63932H7.49251C7.81447 6.63932 8.09981 6.43201 8.1993 6.12581L9.80783 1.17527C10.0303 0.490589 10.9989 0.490589 11.2214 1.17527L12.8299 6.12581C12.9294 6.43201 13.2148 6.63932 13.5367 6.63932H18.742C19.4619 6.63932 19.7613 7.56056 19.1788 7.98371L14.9677 11.0433C14.7072 11.2326 14.5982 11.568 14.6977 11.8742L16.3062 16.8247C16.5287 17.5094 15.745 18.0788 15.1626 17.6556L10.9514 14.596C10.691 14.4068 10.3383 14.4068 10.0778 14.596L9.70232 14.8688L9.38025 15.1028"
    stroke="#F2B035" stroke-width="1.25" stroke-linecap="round"/>
</svg>
                                            4.5</span>
                                            <span class="icon-text">
                                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
<circle cx="6.59346" cy="4.12275" r="2.40791" stroke="#5D29A6" stroke-width="1.07143"/>
<path
    d="M7.91917 18.9062C8.20283 18.8221 8.36461 18.524 8.28051 18.2403C8.19641 17.9566 7.89829 17.7948 7.61462 17.8789L7.91917 18.9062ZM10.5576 11.9614H10.0218V14.4883H10.5576H11.0933V11.9614H10.5576ZM2.63477 14.5863H3.17048V11.9614H2.63477H2.09905V14.5863H2.63477ZM7.74308 18.3996L7.89535 18.9132L7.91917 18.9062L7.76689 18.3926L7.61462 17.8789L7.59081 17.886L7.74308 18.3996ZM2.63477 14.5863H2.09905C2.09905 17.0789 4.11964 19.0994 6.61217 19.0994V18.5637V18.028C4.71137 18.028 3.17048 16.4871 3.17048 14.5863H2.63477ZM6.61217 18.5637V19.0994C7.04663 19.0994 7.47881 19.0367 7.89535 18.9132L7.74308 18.3996L7.59081 17.886C7.27313 17.9802 6.94351 18.028 6.61217 18.028V18.5637ZM10.5576 14.4883H10.0218C10.0218 15.5873 9.53963 16.6308 8.70273 17.3431L9.04993 17.751L9.39712 18.159C10.4732 17.2432 11.0933 15.9014 11.0933 14.4883H10.5576ZM6.59616 8V8.53571C8.48812 8.53571 10.0218 10.0694 10.0218 11.9614H10.5576H11.0933C11.0933 9.47771 9.07985 7.46429 6.59616 7.46429V8ZM6.59616 8V7.46429C4.11248 7.46429 2.09905 9.47771 2.09905 11.9614H2.63477H3.17048C3.17048 10.0694 4.70421 8.53571 6.59616 8.53571V8Z"
    fill="#5D29A6"/>
<circle cx="2.40791" cy="2.40791" r="2.40791" transform="matrix(-1 0 0 1 16.334 1.71484)" stroke="#5D29A6"
        stroke-width="1.07143"/>
<path
    d="M12.6043 18.9062C12.3206 18.8221 12.1588 18.524 12.2429 18.2403C12.327 17.9566 12.6252 17.7948 12.9088 17.8789L12.6043 18.9062ZM9.96587 11.9614H10.5016V14.4883H9.96587H9.43016V11.9614H9.96587ZM17.8887 14.5863H17.353V11.9614H17.8887H18.4244V14.5863H17.8887ZM12.7804 18.3996L12.6281 18.9132L12.6043 18.9062L12.7565 18.3926L12.9088 17.8789L12.9326 17.886L12.7804 18.3996ZM17.8887 14.5863H18.4244C18.4244 17.0789 16.4038 19.0994 13.9113 19.0994V18.5637V18.028C15.8121 18.028 17.353 16.4871 17.353 14.5863H17.8887ZM13.9113 18.5637V19.0994C13.4768 19.0994 13.0446 19.0367 12.6281 18.9132L12.7804 18.3996L12.9326 17.886C13.2503 17.9802 13.5799 18.028 13.9113 18.028V18.5637ZM9.96587 14.4883H10.5016C10.5016 15.5873 10.9838 16.6308 11.8207 17.3431L11.4735 17.751L11.1263 18.159C10.0502 17.2432 9.43016 15.9014 9.43016 14.4883H9.96587ZM13.9273 8V8.53571C12.0353 8.53571 10.5016 10.0694 10.5016 11.9614H9.96587H9.43016C9.43016 9.47771 11.4436 7.46429 13.9273 7.46429V8ZM13.9273 8V7.46429C16.411 7.46429 18.4244 9.47771 18.4244 11.9614H17.8887H17.353C17.353 10.0694 15.8192 8.53571 13.9273 8.53571V8Z"
    fill="#5D29A6"/>
</svg> 2200 learners</span>
                                        </div>
                                    </div>
                                </div>
                                {{--                                                </a>--}}
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="classes-content">

                    <div class="d-flex align-items-center gap-2">
                        <div class="flex-grow-1">
                            <h3 class="m-2">Master classes for upskilling</h3>
                        </div>

                        <div class="text-end d-flex gap-3">

                            <!-- Date Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-light rounded-pill px-4" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="color:#000;">
                                    <i class="bi bi-calendar3"></i> Date
                                </button>
                                <div class="dropdown-menu p-3 shadow-lg" style="min-width: 280px;">
                                    <div class="mb-2">
                                        <label class="form-label fw-semibold">Start Date</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control"  value="{{ request('start_date') ?? $start_date }}">
                                    </div>
                                    <div>
                                        <label class="form-label fw-semibold">End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') ?? $end_date }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Location Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-light rounded-pill px-4" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="color:#000;">
                                    <i class="bi bi-geo-alt"></i> Location
                                </button>
                                <div class="dropdown-menu p-3 shadow-lg" style="min-width: 300px;">
                                    <div class="mb-2">
                                        <label class="form-label fw-semibold">Country</label>
                                        <select class="form-select" id="countrySelect">
                                            <option disabled {{ !$country ? 'selected' : '' }}>Select Country</option>
                                            @foreach($countries as $c)
                                                <option value="{{ $c->id }}" {{ $country == $c->id ? 'selected' : '' }}>
                                                    {{ $c->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label fw-semibold">State</label>
                                        <select class="form-select" id="stateSelect">
                                            <option disabled {{ !$state ? 'selected' : '' }}>Select State</option>
                                            @foreach($stateList as $s)
                                                <option value="{{ $s->id }}" {{ $state == $s->id ? 'selected' : '' }}>
                                                    {{ $s->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label fw-semibold">City</label>
                                        <select class="form-select" id="citySelect">
                                            <option disabled {{ !$city ? 'selected' : '' }}>Select City</option>
                                            @foreach($cityList as $ct)
                                                <option value="{{ $ct->id }}" {{ $city == $ct->id ? 'selected' : '' }}>
                                                    {{ $ct->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Mode select dropdown -->
                            <select class="form-control rounded-pill px-4" id="mode"
                                    style="width: 160px; display: inline-block;" placeholder="Mode">
                                <option disabled {{ !$mode ? 'selected' : '' }}>Mode</option>
                                <option value="virtual" {{ $mode == 'virtual' ? 'selected' : '' }}>Virtual</option>
                                <option value="face_to_face" {{ $mode == 'face_to_face' ? 'selected' : '' }}>Face to face</option>
                            </select>


                            <!-- Skills select dropdown -->
                            <select class="form-control rounded-pill px-4" id="skills"
                                    style="width: 160px; display: inline-block;" placeholder="Skills">
                                <option disabled {{ !$skill ? 'selected' : '' }}>Skills</option>
                                @foreach($skills as $s)
                                    <option value="{{ $s->id }}" {{ $skill == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>

                            <a href="{{ route('frontend.mentee.master-classes') }}">Clear filters</a>

                        </div>
                    </div>


                    @if($upskill_masterClass->isNotEmpty())
                        <div class="slider master-class-items">
                            @foreach($upskill_masterClass as $class)
                                <div>
                                    <div
                                        class="container my-4 d-flex justify-content-center master-class-div">
                                        <div class="card masterclass-card">
                                            <div class="card-img-top position-relative">
                                                <img
                                                    src="{{ Storage::disk('master_class_banner_image')->url($class->banner_image) }}"
                                                    class="img-fluid rounded slick-poster-image"
                                                    alt="{{ $class->title }}"/>

                                            </div>
                                            <div class="card-body">
                                                <a href="{{ route('frontend.master-classes.detail', ['slug' => $class->slug]) }}">
                                                    <p class="mb-1">{{ \Carbon\Carbon::parse($class->created_at)->format('M d, g:ia') }}
                                                        (GMT {{ \Carbon\Carbon::parse($class->created_at)->format('P') }}
                                                        )</p>
                                                    <h5 class="card-title mb-1">
                                                        {{ $class->title }}
                                                        <span
                                                            class="badge bg-secondary text-purple ms-2">{{ $class->price }}</span>
                                                    </h5>
                                                    <p class="card-text text-muted">
                                                        {{ \Illuminate\Support\Str::words($class->description, 25, '...') }}
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
    stroke="#5D29A6" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10.364 5.09277V10.5473L14.0004 12.3655" stroke="#F2B035" stroke-width="1.13636" stroke-linecap="round"
      stroke-linejoin="round"/>
</svg>
                                            4 hrs</span>
                                                <span class="icon-text">
                                        <svg width="21" height="19" viewBox="0 0 21 19" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
<path
    d="M7.26542 16.6393L5.86662 17.6556C5.2842 18.0788 4.50055 17.5094 4.72302 16.8247L6.33154 11.8742C6.43103 11.568 6.32204 11.2326 6.06157 11.0433L1.85039 7.98371C1.26797 7.56055 1.5673 6.63932 2.28721 6.63932H7.49251C7.81447 6.63932 8.09981 6.43201 8.1993 6.12581L9.80783 1.17527C10.0303 0.490589 10.9989 0.490589 11.2214 1.17527L12.8299 6.12581C12.9294 6.43201 13.2148 6.63932 13.5367 6.63932H18.742C19.4619 6.63932 19.7613 7.56056 19.1788 7.98371L14.9677 11.0433C14.7072 11.2326 14.5982 11.568 14.6977 11.8742L16.3062 16.8247C16.5287 17.5094 15.745 18.0788 15.1626 17.6556L10.9514 14.596C10.691 14.4068 10.3383 14.4068 10.0778 14.596L9.70232 14.8688L9.38025 15.1028"
    stroke="#F2B035" stroke-width="1.25" stroke-linecap="round"/>
</svg>
                                            4.5</span>
                                                <span class="icon-text">
                                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
<circle cx="6.59346" cy="4.12275" r="2.40791" stroke="#5D29A6" stroke-width="1.07143"/>
<path
    d="M7.91917 18.9062C8.20283 18.8221 8.36461 18.524 8.28051 18.2403C8.19641 17.9566 7.89829 17.7948 7.61462 17.8789L7.91917 18.9062ZM10.5576 11.9614H10.0218V14.4883H10.5576H11.0933V11.9614H10.5576ZM2.63477 14.5863H3.17048V11.9614H2.63477H2.09905V14.5863H2.63477ZM7.74308 18.3996L7.89535 18.9132L7.91917 18.9062L7.76689 18.3926L7.61462 17.8789L7.59081 17.886L7.74308 18.3996ZM2.63477 14.5863H2.09905C2.09905 17.0789 4.11964 19.0994 6.61217 19.0994V18.5637V18.028C4.71137 18.028 3.17048 16.4871 3.17048 14.5863H2.63477ZM6.61217 18.5637V19.0994C7.04663 19.0994 7.47881 19.0367 7.89535 18.9132L7.74308 18.3996L7.59081 17.886C7.27313 17.9802 6.94351 18.028 6.61217 18.028V18.5637ZM10.5576 14.4883H10.0218C10.0218 15.5873 9.53963 16.6308 8.70273 17.3431L9.04993 17.751L9.39712 18.159C10.4732 17.2432 11.0933 15.9014 11.0933 14.4883H10.5576ZM6.59616 8V8.53571C8.48812 8.53571 10.0218 10.0694 10.0218 11.9614H10.5576H11.0933C11.0933 9.47771 9.07985 7.46429 6.59616 7.46429V8ZM6.59616 8V7.46429C4.11248 7.46429 2.09905 9.47771 2.09905 11.9614H2.63477H3.17048C3.17048 10.0694 4.70421 8.53571 6.59616 8.53571V8Z"
    fill="#5D29A6"/>
<circle cx="2.40791" cy="2.40791" r="2.40791" transform="matrix(-1 0 0 1 16.334 1.71484)" stroke="#5D29A6"
        stroke-width="1.07143"/>
<path
    d="M12.6043 18.9062C12.3206 18.8221 12.1588 18.524 12.2429 18.2403C12.327 17.9566 12.6252 17.7948 12.9088 17.8789L12.6043 18.9062ZM9.96587 11.9614H10.5016V14.4883H9.96587H9.43016V11.9614H9.96587ZM17.8887 14.5863H17.353V11.9614H17.8887H18.4244V14.5863H17.8887ZM12.7804 18.3996L12.6281 18.9132L12.6043 18.9062L12.7565 18.3926L12.9088 17.8789L12.9326 17.886L12.7804 18.3996ZM17.8887 14.5863H18.4244C18.4244 17.0789 16.4038 19.0994 13.9113 19.0994V18.5637V18.028C15.8121 18.028 17.353 16.4871 17.353 14.5863H17.8887ZM13.9113 18.5637V19.0994C13.4768 19.0994 13.0446 19.0367 12.6281 18.9132L12.7804 18.3996L12.9326 17.886C13.2503 17.9802 13.5799 18.028 13.9113 18.028V18.5637ZM9.96587 14.4883H10.5016C10.5016 15.5873 10.9838 16.6308 11.8207 17.3431L11.4735 17.751L11.1263 18.159C10.0502 17.2432 9.43016 15.9014 9.43016 14.4883H9.96587ZM13.9273 8V8.53571C12.0353 8.53571 10.5016 10.0694 10.5016 11.9614H9.96587H9.43016C9.43016 9.47771 11.4436 7.46429 13.9273 7.46429V8ZM13.9273 8V7.46429C16.411 7.46429 18.4244 9.47771 18.4244 11.9614H17.8887H17.353C17.353 10.0694 15.8192 8.53571 13.9273 8.53571V8Z"
    fill="#5D29A6"/>
</svg> 2200 learners</span>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                                                </a>--}}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center mt-2">No Master classes found</p>
                    @endif
                </div>


            </div>


        </div>
    </div>

@endsection

@section('javascripts')
    <script>
        $(".master-class-items").slick({
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 4,
            slidesToScroll: 3
        });
    </script>

    <script>
        document.getElementById('countrySelect').addEventListener('change', function () {
            const countryId = this.value;
            fetch(`/get-states/${countryId}`)
                .then(res => res.json())
                .then(states => {
                    const stateSelect = document.getElementById('stateSelect');
                    stateSelect.innerHTML = '<option disabled selected>Select State</option>';
                    states.forEach(state => {
                        stateSelect.innerHTML += `<option value="${state.id}">${state.name}</option>`;
                    });
                });
        });

        document.getElementById('stateSelect').addEventListener('change', function () {
            const stateId = this.value;
            fetch(`/get-cities/${stateId}`)
                .then(res => res.json())
                .then(cities => {
                    const citySelect = document.getElementById('citySelect');
                    citySelect.innerHTML = '<option disabled selected>Select City</option>';
                    cities.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                    });
                });
        });

        $(document).ready(function () {
            $(document).on('change', '#countrySelect', function () {
                let countryId = $(this).val();
                let stateSelect = $('#stateSelect');
                let citySelect = $('#citySelect');
                console.log(countryId)
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
        });

        $(document).on('change', '#stateSelect', function () {
            let stateId = $(this).val();
            let citySelect = $('#citySelect');

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

        $(document).on('change', '#start_date, #citySelect, #end_date, #mode, #skills', function () {
            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();
            let country = $('#countrySelect').val();
            let state = $('#stateSelect').val();
            let city = $('#citySelect').val();
            let mode = $('#mode').val();
            let skills = $('#skills').val();
            let query = $.param({
                start_date: startDate,
                end_date: endDate,
                country: country,
                state: state,
                city: city,
                mode: mode,
                skill: skills,
            });
            window.location.href = "{{ route('frontend.mentee.master-classes') }}?" + query;
        });


    </script>

@endsection
