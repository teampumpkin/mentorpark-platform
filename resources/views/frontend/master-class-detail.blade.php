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
            <div class="">
                <div class="row">
                    <!-- Main Section -->
                    <div class="col-lg-8">
                        <div class="masterclass-card p-4 mb-4 rounded shadow master-class-section">
                            <div class="mb-3">
                                <h2 class="fw-bold mb-2" style="color:#222;">{{ $masterClass->title }}</h2>
                                <span class="text-secondary"><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($masterClass->created_at)->format('M d, g:ia') }}
                                                    (GMT {{ \Carbon\Carbon::parse($masterClass->created_at)->format('P') }}
                                                    )</span>
                            </div>
                            <div>
                                <img
                                    src="{{ Storage::disk('master_class_banner_image')->url($masterClass->banner_image) }}"
                                    alt="Session main visual" class="img-fluid rounded mb-4"
                                    style="max-height:280px;object-fit:cover; width: 100%;">
                            </div>

                            <p class="mb-2 text-muted">
                                {{ $masterClass->description }}
                            </p>


                            <h5 class="fw-semibold">Masterclass structure</h5>
                            <div class="accordion" id="masterclassAccordion">

                                @foreach($masterClass->sessions as $key => $session)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse_{{ $key }}">
                                                Session {{ $key + 1 }} – {{ $session->title }}
                                            </button>
                                        </h2>
                                        <div id="collapse_{{ $key }}"
                                             class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}">
                                            <div class="accordion-body">
                                                <div>
                                                    <span
                                                        class="fw-semibold">Start Date Time:</span> {{ \Carbon\Carbon::parse($session->start_date_time)->format('d-m-Y h:i A') }}
                                                    <br>
                                                    <span
                                                        class="fw-semibold">End Date Time:</span> {{ \Carbon\Carbon::parse($session->end_date_time)->format('d-m-Y h:i A') }}
                                                    <br>
                                                    <span
                                                        class="fw-semibold">Slots:</span> {{ $session->seat_capacity_min }}
                                                    - {{ $session->seat_capacity_max }}
                                                </div>
                                                <div class="mt-2">
                                                    @if( $session->session_type == 'face_to_face')
                                                        <span
                                                            class="fw-semibold">Venue:</span> {{ $session->venue_address }} {{ $session->cityRel->name }} {{ $session->stateRel->name }} {{ $session->countryRel->name }} {{ $session->postal_code }}
                                                        . <br>
                                                    @endif

                                                    <span class="fw-semibold">Speakers:</span> Lorem ipsum
                                                </div>
                                                <div class="mt-2">
                                                    {{ $session->session_description }}
                                                </div>


                                                <div>
                                                    <span class="fw-semibold">Speakers</span>
                                                    @foreach($session->mentors as $mentor)
                                                        @php
                                                            $user = \App\Models\User::where('email', $mentor->email)->with('information')->first();
                                                        @endphp
                                                        <div class="mt-2">
                                                            <div class="d-flex align-items-center mb-1">
                                                                <img
                                                                    src="{{ Storage::disk('public_users_profile')->url($user->information->profile_photo ?? '') }}"
                                                                    class="mentor-profile-image me-2" alt=""
                                                                    width="40" height="40">
                                                                <span>{{ $mentor->name }}<br>
                                                            <small
                                                                class="text-muted">{{ $user->information->job_title ?? '' }} {{ $user->information->organization->name ?? '' }}</small></span>
                                                            </div>
                                                            <!-- Repeat for more speakers if needed -->
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="d-flex align-items-center gap-2 mt-2">
                                                    @php
                                                        $finalPrice = $session->session_price;
                                                        $discountLabel = '';

                                                        if (!empty($session->session_price_discount)) {
                                                            if ($session->discount_type == 'amount') {
                                                                $finalPrice = $session->session_price - $session->session_price_discount;
                                                                $discountLabel = '₹' . $session->session_price_discount . ' off';
                                                            } elseif ($session->discount_type == 'percent') {
                                                                $discountAmount = ($session->session_price * $session->session_price_discount) / 100;
                                                                $finalPrice = $session->session_price - $discountAmount;
                                                                $discountLabel = $session->session_price_discount . '% off';
                                                            }
                                                        }
                                                    @endphp
                                                    <span class="fw-bold" style="color:#5D29A6;"> Price:
                                                        @if(!empty($session->session_price_discount))
                                                            <span style="font-size: 10px; color: #FF0000FF;">
                                                                <strike>₹{{ number_format($session->session_price, 2) }}</strike>
                                                            </span>
                                                            ₹{{ number_format($finalPrice, 2) }}/-
                                                            <small style="color: green;">({{ $discountLabel }})</small>
                                                        @else
                                                            ₹{{ number_format($session->session_price, 2) }}/-
                                                        @endif
                                                    </span>
                                                    <button class="btn btn-purple">Enroll Now</button>
                                                    {{--                                                    <span class="text-danger small">Hurry up! 8 Seats left</span>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="p-4 rounded shadow mb-4 master-class-section">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                @php
                                    $finalPrice = $masterClass->price;
                                    $discountLabel = '';

                                    if (!empty($masterClass->discount_value)) {
                                        if ($masterClass->discount_type == 'amount') {
                                            $finalPrice = $masterClass->price - $masterClass->discount_value;
                                            $discountLabel = '₹' . $masterClass->discount_value . ' off';
                                        } elseif ($masterClass->discount_type == 'percent') {
                                            $discountAmount = ($masterClass->price * $masterClass->discount_value) / 100;
                                            $finalPrice = $masterClass->price - $discountAmount;
                                            $discountLabel = $masterClass->discount_value . '% off';
                                        }
                                    }
                                @endphp
                                <h4 class="fw-bold mb-0" style="color:#5D29A6;">
                                    @if(!empty($masterClass->discount_value))
                                        <span style="font-size: 10px; color: #FF0000FF;">
                                                                <strike>₹{{ number_format($masterClass->price, 2) }}</strike>
                                                            </span>
                                        ₹{{ number_format($finalPrice, 2) }}/-
                                        <small style="color: green;">({{ $discountLabel }})</small>
                                    @else
                                        ₹{{ number_format($masterClass->price, 2) }}/-
                                    @endif

                                </h4>

                                @if($authUser->id !== $masterClass->user_id)
                                    <button class="btn btn-purple" onclick="openMasterClassModal()">
                                        Enroll in Masterclass
                                    </button>
                                @endif

                            </div>
                            @if($authUser->id !== $masterClass->user_id)
                                <button class="btn btn-black mb-3 w-100">I'm Interested</button>
                            @endif
                            {{-- <input type="text" class="form-control mb-3" value="https://mentorpark.com/masterclass"
                                    readonly>--}}
                            <div class="d-flex align-items-center mb-4" style="gap: 8px;">
                                <input type="text"
                                       class="form-control"
                                       value="{{ url()->current() }}"
                                       id="shareLinkInput"
                                       readonly
                                       style="background: #fafafa; border: 1px solid #e0e0e0; border-radius: 8px; height: 44px; font-size: 15px;">
                                <button type="button"
                                        class="btn"
                                        style="background: #18D1A7; color: #fff; font-weight: 600; height: 44px; padding: 0 20px; border-radius: 8px;"
                                        onclick="shareUrl()">
                                    Share
                                </button>
                            </div>
                            {{--<div class="mb-3">
                                <span class="fw-semibold">Interested participants (20)</span>
                                <div class="d-flex mt-2">
                                    <img src="participant1.jpg" class="rounded-circle" width="32" height="32" alt="">
                                    <img src="participant2.jpg" class="rounded-circle" width="32" height="32" alt=""
                                         style="margin-left: -10px;">
                                    <img src="participant3.jpg" class="rounded-circle" width="32" height="32" alt=""
                                         style="margin-left: -10px;">
                                    <span
                                        class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                        style="width:32px;height:32px;margin-left:-10px;">+50</span>
                                </div>
                            </div>--}}
                            <div class="mb-2">
                                <span class="fw-semibold">Hosted by</span>
                                <div class="d-flex align-items-center mt-2">
                                    <img
                                        src="{{ Storage::disk('public_users_profile')->url($masterClass->user->information->profile_photo ?? '') }}"
                                        class="mentor-profile-image me-2" alt="">
                                    <span>{{ $masterClass->user->name }}<br>
                                    <small
                                        class="text-muted">{{ $masterClass->user->information->your_level }} {{ $masterClass->user->information->organization->name ?? '' }}</small>
                                </span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <span class="fw-semibold">Key learning area</span>
                                <div class="d-flex gap-1 mt-1 flex-wrap">
                                    @foreach($masterClass->user->skills as $skill)
                                        <span class="badge bg-light text-dark"> {{ $skill->name }}</span>
                                    @endforeach

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /Sidebar -->
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Structure -->
    <div id="enrollMasterClassModal"
         style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); z-index:9999;">
        <div
            style="background:white;border-radius:16px;max-width:380px;margin:3% auto;box-shadow:0 8px 32px rgba(80,68,137,0.12);padding:30px 20px 20px 20px;position:relative;">
            <!-- Close Button -->
            <button onclick="closeMasterClassModal()"
                    style="position:absolute;top:18px;right:20px;background:none;border:none;font-size:20px;color:#888;cursor:pointer;">
                ×
            </button>

            <h2 style="margin-bottom:18px;font-size:22px;">Fill details</h2>
            @php $activeTab = 'individual'; @endphp
            {{--            @dump($authUser)--}}
            @if($authUser && $authUser->information)
                <!-- Enrolling as -->
                @php
                    $info = $authUser->information;
                    $hasOrg = !is_null($info->organization_id);
                    $isOrgUser = in_array('Organization', $info->user_type ?? '[]');

                    if (!$hasOrg) {
                        $activeTab = 'individual';
                        $buttonLabel = 'Pay Now';
                        $formAction = url('/enroll/individual');
                    } elseif ($hasOrg && $isOrgUser) {
                        $activeTab = 'organization';
                        $buttonLabel = 'Pay Now';
                        $formAction = url('/enroll/organization');
                    } else {
                        $activeTab = 'request';
                        $buttonLabel = 'Request Class';
                        $formAction = url('/request/class');
                    }
                @endphp
                <div style="display:flex;gap:10px;margin-bottom:20px;">
                    <button id="tabIndividual"
                            onclick="switchTab('individual')"
                            @if($authUser->information->organization_id !== null) disabled
                            style="background:#f2f2f2;color:#bbb;cursor:not-allowed; padding: 5px 15px;border: none;border-radius: 5px;"
                            @endif
                            @if($authUser->information->organization_id === null) style="background:#6C36D9;color:#fff;padding: 5px 15px;border: none;border-radius: 5px;" @endif>
                        Individual
                    </button>
                    <button id="tabOrganization"
                            onclick="switchTab('organization')"
                            @if($authUser->information->organization_id === null) disabled
                            style="background:#f2f2f2;color:#bbb;cursor:not-allowed;padding: 5px 15px;border: none;border-radius: 5px;"
                            @endif
                            @if($authUser->information->organization_id !== null) style="background:#6C36D9;color:#fff;padding: 5px 15px;border: none;border-radius: 5px;" @endif>
                        Organization
                    </button>
                </div>

                <!-- Sessions Included as checkbox -->
                <div style="margin-bottom:20px;">
                    <div style="color:#8B68EC;font-weight:600;margin-bottom:10px;">Sessions Included</div>
                    @foreach($masterClass->sessions as $key => $session)
                        @php
                            $sessionFinalPrice = $session->session_price;
                            $sessionDiscountLabel = '';

                            if (!empty($session->session_price_discount)) {
                                if ($session->discount_type == 'amount') {
                                    $sessionFinalPrice -= $session->session_price_discount;
                                    $sessionDiscountLabel = '₹' . $session->session_price_discount . ' off';
                                } elseif ($session->discount_type == 'percent') {
                                    $discountAmt = ($session->session_price * $session->session_price_discount) / 100;
                                    $sessionFinalPrice -= $discountAmt;
                                    $sessionDiscountLabel = $session->session_price_discount . '% off';
                                }
                            }
                        @endphp
                        <div
                            style="background:#f2e9fb;border-radius:10px;padding:8px 12px;margin-bottom:10px;display:flex;align-items:center;gap:8px;">
                            <input type="checkbox"
                                   class="session-checkbox"
                                   id="session_{{ $session->id }}"
                                   name="sessions[]"
                                   value="{{ $session->id }}"
                                   data-price="{{ $sessionFinalPrice }}"
                                   checked
                                   style="accent-color:#6C36D9;"/>
                            <label for="session_{{ $session->id }}" style="color:#6C36D9;">
                                {{ $session->title }}<br>
                                <span style="color:#5D29A6;">
                    @if(!empty($session->session_price_discount))
                                        <span style="font-size:10px;color:#FF0000FF;">
                            <strike>₹{{ number_format($session->session_price, 2) }}</strike>
                        </span>
                                        ₹{{ number_format($sessionFinalPrice, 2) }}/-
                                        <small style="color:green;">({{ $sessionDiscountLabel }})</small>
                                    @else
                                        ₹{{ number_format($sessionFinalPrice, 2) }}/-
                                    @endif
                </span>
                            </label>
                        </div>
                    @endforeach

                    @php
                        $masterFinalPrice = $masterClass->price;
                        $masterDiscountLabel = '';

                        if (!empty($masterClass->discount_value)) {
                            if ($masterClass->discount_type == 'amount') {
                                $masterFinalPrice -= $masterClass->discount_value;
                                $masterDiscountLabel = '₹' . $masterClass->discount_value . ' off';
                            } elseif ($masterClass->discount_type == 'percent') {
                                $masterDiscountAmt = ($masterClass->price * $masterClass->discount_value) / 100;
                                $masterFinalPrice -= $masterDiscountAmt;
                                $masterDiscountLabel = $masterClass->discount_value . '% off';
                            }
                        }
                    @endphp

                    <div
                        style="background:#f2e9fb;border-radius:10px;padding:8px 12px;margin-bottom:10px;display:flex;align-items:center;gap:8px;">
                        <input type="checkbox"
                               id="completeMasterclass"
                               name="complete_masterclass"
                               style="accent-color:#6C36D9;"
                               value="{{ $masterClass->id }}"
                               checked/>
                        <label for="completeMasterclass" style="color:#6C36D9;">
                            Complete Masterclass <br>
                            <span style="color:#5D29A6;">
                @if(!empty($masterClass->discount_value))
                                    <span style="font-size:10px;color:#FF0000FF;">
                        <strike>₹{{ number_format($masterClass->price, 2) }}</strike>
                    </span>
                                    ₹{{ number_format($masterFinalPrice, 2) }}/-
                                    <small style="color:green;">({{ $masterDiscountLabel }})</small>
                                @else
                                    ₹{{ number_format($masterFinalPrice, 2) }}/-
                                @endif
            </span>
                        </label>
                    </div>

                    <input type="hidden" name="order_type" id="order_type" value="master_class">
                    <input type="hidden" name="master_class_id" id="master_class_id" value="{{ $masterClass->id }}">

                    <div class="payable-amount-div" style="text-align:right;">
                        <label id="payableAmountLabel" class="item-right font-extrabold">Payable amount:
                            ₹{{ number_format($masterFinalPrice, 2) }}</label>
                    </div>
                </div>

                <!-- Form Sections -->
                <form id="individualForm">
                    {{--<input type="text"
                           style="width:100%;margin-bottom:12px;padding:12px;border-radius:9px;border:1px solid #eee;background:#f8f8fa;"
                           placeholder="Full Name">
                    <input type="email"
                           style="width:100%;margin-bottom:12px;padding:12px;border-radius:9px;border:1px solid #eee;background:#f8f8fa;"
                           placeholder="Email Id">
                    <input type="tel"
                           style="width:100%;margin-bottom:24px;padding:12px;border-radius:9px;border:1px solid #eee;background:#f8f8fa;"
                           placeholder="Phone Number">--}}
                </form>
                <form id="organizationForm" style="display:none;">
                    @if($activeTab == 'organization')
                        <input type="text"
                               style="width:100%;margin-bottom:12px;padding:12px;border-radius:9px;border:1px solid #eee;background:#f8f8fa;"
                               placeholder="Contact Person">
                        <input type="email"
                               style="width:100%;margin-bottom:12px;padding:12px;border-radius:9px;border:1px solid #eee;background:#f8f8fa;"
                               placeholder="Email ID">
                        <input type="tel"
                               style="width:100%;margin-bottom:12px;padding:12px;border-radius:9px;border:1px solid #eee;background:#f8f8fa;"
                               placeholder="Phone Number">
                        <div style="display:flex;gap:10px;margin-bottom:12px;">
                            <select
                                style="flex:2; padding:12px; border-radius:9px; border:1px solid #eee; background:#f8f8fa;">
                                <option>Select venue</option>
                                <option>Venue 1</option>
                                <option>Venue 2</option>
                            </select>
                            <input type="number"
                                   style="flex:1; padding:12px; border-radius:9px; border:1px solid #eee; background:#f8f8fa;"
                                   placeholder="No. of seats">
                        </div>
                        <input type="text"
                               style="width:100%;margin-bottom:12px;padding:12px;border-radius:9px;border:1px solid #eee;background:#f8f8fa;"
                               placeholder="Suggested Date & Time" onfocus="this.type='date'" onblur="this.type='text'">
                    @endif
                </form>
            @endif
            <!-- Footer Buttons -->
            <div style="display:flex;justify-content:space-between;margin-top:16px;">
                <button type="button" onclick="closeMasterClassModal()"
                        style="border:none;background:#f5f5f7;color:#444;border-radius:8px;padding:10px 32px;font-weight:600;">
                    Cancel
                </button>
                @if($activeTab == 'request')
                    <button id="raiseRequest"
                            style="border:none;background:#6C36D9;color:white;border-radius:8px;padding:10px 32px;font-weight:600;">
                        Raise Request
                    </button>
                @else
                    <button id="actionButton"
                            style="border:none;background:#6C36D9;color:white;border-radius:8px;padding:10px 32px;font-weight:600;">
                        Pay Now
                    </button>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('javascripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sessionCheckboxes = document.querySelectorAll('.session-checkbox');
            const completeMasterclass = document.getElementById('completeMasterclass');
            const payableAmountLabel = document.getElementById('payableAmountLabel');
            const masterClassPrice = {{ $masterFinalPrice ?? '' }};
            const sessionCount = {{ count($masterClass->sessions) ?? 0 }};

            function updatePayableAmount() {
                let checkedCount = 0;
                let sum = 0;
                sessionCheckboxes.forEach(cb => {
                    if (cb.checked) {
                        checkedCount++;
                        sum += parseFloat(cb.getAttribute('data-price')) || 0;
                    }
                });

                if (checkedCount === sessionCount) {
                    completeMasterclass.checked = true;
                    payableAmountLabel.textContent = "Payable amount: ₹" + masterClassPrice.toFixed(2);
                    $('#order_type').val('master_class');
                } else {
                    completeMasterclass.checked = false;
                    payableAmountLabel.textContent = "Payable amount: ₹" + sum.toFixed(2);
                    $('#order_type').val('session');
                }
            }

            sessionCheckboxes.forEach(cb => {
                cb.addEventListener('change', updatePayableAmount);
            });

            completeMasterclass.addEventListener('change', function () {
                if (completeMasterclass.checked) {
                    // Check all session boxes
                    sessionCheckboxes.forEach(cb => cb.checked = true);
                }
                updatePayableAmount();
            });

            updatePayableAmount(); // initialize at load
        });
    </script>
    <script>
        window.onload = function () {
            {{--            @if($user->information->organization_id !== null)--}}
            {{--            switchTab('organization');--}}
            {{--            @else--}}
            {{--            switchTab('individual');--}}
            {{--            @endif--}}
        }

        function shareUrl() {
            const url = document.getElementById('shareLinkInput').value;
            if (navigator.share) {
                navigator.share({
                    title: 'Masterclass',
                    url: url
                });
            } else {
                // fallback for browsers that do not support navigator.share
                alert('Sharing not supported on this browser. Please copy the link manually: ' + url);
            }
        }

        function openMasterClassModal() {
            document.getElementById('enrollMasterClassModal').style.display = 'block';
        }

        function closeMasterClassModal() {
            document.getElementById('enrollMasterClassModal').style.display = 'none';
        }

        function switchTab(tab) {
            // Tab state
            let tabIndividual = document.getElementById('tabIndividual');
            let tabOrganization = document.getElementById('tabOrganization');
            let individualForm = document.getElementById('individualForm');
            let organizationForm = document.getElementById('organizationForm');
            let actionBtn = document.getElementById('actionButton');

            if (tab === 'individual') {
                tabIndividual.style.background = "#6C36D9";
                tabIndividual.style.color = "#fff";
                tabOrganization.style.background = "#f2f2f2";
                tabOrganization.style.color = "#333";
                individualForm.style.display = '';
                organizationForm.style.display = 'none';
                actionBtn.textContent = 'Pay Now';
            } else {
                tabOrganization.style.background = "#6C36D9";
                tabOrganization.style.color = "#fff";
                tabIndividual.style.background = "#f2f2f2";
                tabIndividual.style.color = "#333";
                individualForm.style.display = 'none';
                organizationForm.style.display = '';
                actionBtn.textContent = 'Enquire Now';
            }
        }
    </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $('#payBtn').click(function () {
            let amount = $('#amount').val();

            $.post("{{ route('create.order') }}", {
                amount,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function (data) {
                if (data.order_id) {
                    let options = {
                        "key": data.key,
                        "amount": data.amount * 100,
                        "currency": "INR",
                        "name": "Your App Name",
                        "description": "Test Transaction",
                        "order_id": data.order_id,
                        "handler": function (response) {
                            $.post("{{ route('verify.payment') }}", {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_signature: response.razorpay_signature
                            }, function (res) {
                                alert(res.message);
                            });
                        },
                        "theme": {
                            "color": "#3399cc"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                } else {
                    alert("Order creation failed!");
                }
            });
        });
    </script>
    <script>
        function getModalData() {
            let tab = $('#tabIndividual').prop('disabled') ? 'organization' : 'individual';
            let selectedSessions = [];
            $('.session-checkbox:checked').each(function () {
                selectedSessions.push($(this).val());
            });
            let completeMasterclass = $('#completeMasterclass').is(':checked') ? 1 : 0;
            let data = {
                tab: tab,
                sessions: selectedSessions,
                complete_masterclass: completeMasterclass,
            };
            if (tab === 'individual') {
                // data.full_name = $('#individualForm input[type="text"]').val();
                // data.email = $('#individualForm input[type="email"]').val();
                // data.phone = $('#individualForm input[type="tel"]').val();
                data.master_class_id = $('#master_class_id').val();
            } else {
                data.contact_person = $('#organizationForm input[type="text"]').val();
                data.email = $('#organizationForm input[type="email"]').val();
                data.phone = $('#organizationForm input[type="tel"]').val();
                data.venue = $('#organizationForm select').val();
                data.seats = $('#organizationForm input[type="number"]').val();
                data.suggested_date_time = $('#organizationForm input[type="text"]').eq(1).val();
                data.master_class_id = $('#master_class_id').val();
            }
            data.order_type = $('#order_type').val();
            return data;
        }

        function getRaiseRequestData() {
            let selectedSessions = [];
            $('.session-checkbox:checked').each(function () {
                selectedSessions.push($(this).val());
            });
            let completeMasterclass = $('#completeMasterclass').is(':checked') ? 1 : 0;
            let data = {
                sessions: selectedSessions,
                master_class_id: $('#master_class_id').val(),
                complete_masterclass: completeMasterclass,
            };
            return data;
        }

        function resetFieldHighlights() {
            $('#individualForm input, #organizationForm input, #organizationForm select').css('border', '1px solid #eee');
            $('.session-checkbox').parents('div').css('border', 'none');
        }

        function validateModalData(data) {
            let error = '';
            resetFieldHighlights();

            if (data.tab === 'individual') {
                /* if (!data.full_name) {
                     $('#individualForm input[type="text"]').css('border', '1px solid red');
                     error = 'Full Name required';
                 }
                 if (!data.email) {
                     $('#individualForm input[type="email"]').css('border', '1px solid red');
                     error = 'Email required';
                 }
                 if (!data.phone) {
                     $('#individualForm input[type="tel"]').css('border', '1px solid red');
                     error = 'Phone Number required';
                 }*/
            } else {
                if (!data.contact_person) {
                    $('#organizationForm input[type="text"]').css('border', '1px solid red');
                    error = 'Contact Person required';
                }
                if (!data.email) {
                    $('#organizationForm input[type="email"]').css('border', '1px solid red');
                    error = 'Email required';
                }
                if (!data.phone) {
                    $('#organizationForm input[type="tel"]').css('border', '1px solid red');
                    error = 'Phone Number required';
                }
                if (!data.venue || data.venue === 'Select venue') {
                    $('#organizationForm select').css('border', '1px solid red');
                    error = 'Please select venue';
                }
                if (!data.seats) {
                    $('#organizationForm input[type="number"]').css('border', '1px solid red');
                    error = 'Number of seats required';
                }
                if (!data.suggested_date_time) {
                    $('#organizationForm input[type="text"]').eq(1).css('border', '1px solid red');
                    error = 'Suggested date/time required';
                }
            }
            if (data.sessions.length === 0) {
                $('.session-checkbox').parents('div').css('border', '1px solid red');
                error = 'Select at least one session';
            }
            return error;
        }

        // Remove red border on input
        $('#individualForm, #organizationForm').on('input change', 'input, select', function () {
            $(this).css('border', '1px solid #eee');
        });

        // Remove red border on checkbox click
        $('.session-checkbox').on('change', function () {
            $(this).parents('div').css('border', 'none');
        });

        /*$('#actionButton').on('click', function () {
            let data = getModalData();
            let error = validateModalData(data);
            if (error) {
                // No alert; just highlight
                return;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let url = (data.tab === 'individual') ? '/pay-now' : '/enquire-now';
            $.post(url, data, function (response) {
                alert('Submitted successfully!');
                closeMasterClassModal();
            })
                .fail(function () {
                    alert('Submission failed. Please try again.');
                });
        });*/

        $('#actionButton').on('click', function () {
            let $btn = $(this);
            $btn.prop('disabled', true).text('Loading...');
            let data = getModalData();
            let error = validateModalData(data);
            if (error) {
                return;
            }

            // Set CSRF header
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Only handle Razorpay for 'Pay Now' / individual (you can make tab-specific if needed)
            if (data.tab === 'individual') {
                // 1. Create order on backend and get Razorpay order id and config
                $.post('/pay-now', data, function (response) {
                    // console.log(response);
                    if (response.razorpayOrderData) {
                        launchRazorpay(response.razorpayOrderData, data);
                    } else {
                        alert('Unable to create payment order. Please try again.');
                    }
                }).fail(function () {
                    alert('Failed to initiate payment. Please try again.');
                });
            } else {
                // For Enquire Now path (organization), do your normal post here
                $.post('/enquire-now', data, function (response) {
                    alert('Submitted successfully!');
                    closeMasterClassModal();
                }).fail(function () {
                    alert('Submission failed. Please try again.');
                });
            }
        });

        function launchRazorpay(rzpData, formData) {
            // rzpData should come from your backend, e.g.:
            // { "key": "<key_id>", "order_id": "<order_id>", "amount": ..., "name": ..., "currency": "INR", ... }
            var options = {
                key: rzpData.key,
                amount: rzpData.amount, // in paise
                currency: rzpData.currency || 'INR',
                name: rzpData.name,
                description: rzpData.description,
                // image: rzpData.image, // optional
                order_id: rzpData.order_id,
                handler: function (response) {
                    // On payment successful -- send to verify endpoint
                    $.post('/verify-payment', {
                        purchase_order_id: rzpData.purchase_order_id,
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature,

                    }, function (serverResponse) {
                        // alert('Payment successful!');
                        closeMasterClassModal();
                        window.location.href = serverResponse.url;
                    }).fail(function () {
                        alert('Payment succeeded but verification failed. Please contact support.');
                    });
                },
                prefill: {
                    name: formData.full_name,
                    email: formData.email,
                    contact: formData.phone
                },
                theme: {color: "#6C36D9"}
            };
            var rzp = new Razorpay(options);
            rzp.open();
        }


        $('#raiseRequest').on('click', function () {
            let data = getRaiseRequestData();
            // console.log(data);

            $.ajax({
                url: "{{ route('frontend.mentor.raise.request') }}",  // ✅ must be inside quotes
                type: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    // console.log('Request successful:', response);
                    alert('Request raised successfully!');
                },
                error: function (xhr) {
                    console.error('Request failed:', xhr.responseText);
                    alert('Something went wrong. Please try again.');
                }
            });
        });
    </script>
@endsection
