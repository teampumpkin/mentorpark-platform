@php use App\Models\MasterClass\MasterClassSession; @endphp
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

        /* === PREMIUM TABLE STYLE === */
        {
            border-collapse: separate
        ;
            border-spacing: 0 8px
        ;
            width: 100%
        ;
        }

        thead tr {
            background-color: #f8f9fb;
            border-bottom: 2px solid #e9ecef;
        }

        thead th {
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            color: #5D29A6;
            padding: 14px 18px;
            border: none;
            letter-spacing: 0.5px;
        }

        tbody tr {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(93, 41, 166, 0.05);
            transition: all 0.2s ease-in-out;
        }

        tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(93, 41, 166, 0.12);
            background-color: #faf8ff;
        }

        tbody td {
            padding: 14px 18px;
            vertical-align: middle;
            border-top: none;
            font-size: 0.95rem;
            color: #333;
        }

        tbody td:first-child {
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        tbody td:last-child {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        /* === BADGE STYLES === */
        .badge {
            font-weight: 500;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .badge.bg-success {
            background-color: #d4f7d9 !important;
            color: #2e7d32 !important;
        }

        .badge.bg-warning {
            background-color: #fff4cc !important;
            color: #b8860b !important;
        }

        .badge.bg-danger {
            background-color: #fdecea !important;
            color: #c62828 !important;
        }

        /* === DATATABLE SEARCH + PAGINATION === */
        .dataTables_filter input {
            border: 1px solid #d6c6f3;
            border-radius: 20px;
            padding: 6px 12px;
            outline: none;
        }

        .dataTables_length select {
            border-radius: 10px;
            border: 1px solid #d6c6f3;
            padding: 4px 8px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 8px;
            padding: 5px 10px;
            margin: 0 2px;
            border: 1px solid transparent;
            background: transparent;
            color: #5D29A6 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #5D29A6 !important;
            color: white !important;
            border-color: #5D29A6 !important;
        }

        .dataTables_wrapper .dataTables_info {
            color: #777;
            font-size: 0.85rem;
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
                    <div class="button-group">
                        @if(auth()->user()->role_names[0] == 'Organization')
                            <a href="{{ route('frontend.organization.mentee.add', ['organization_id' => auth()->user()->organization_id]) }}"
                               class="btn btn-purple">Add Mentees</a>
                        @endif
                    </div>
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
                                                <div class="card-title">Mentor-mentee pairs</div>
                                                <div class="card-number">234</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3 mb-4">
                                    <div class="published-card">
                                        <div class="card-content">
                                            <div class="icon-area">
                                                <svg width="34" height="24" viewBox="0 0 34 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.2075 17.6896H10.915C10.5435 17.6896 10.1862 17.8326 9.91721 18.0888L6.26225 21.5708C6.14713 21.6805 5.95669 21.5989 5.95669 21.4399V19.1362C5.95669 18.3373 5.30902 17.6896 4.51007 17.6896H4.16164C2.66361 17.6896 1.44922 16.4752 1.44922 14.9772V3.71291C1.44922 2.21488 2.66361 1.00049 4.16164 1.00049H21.874C23.372 1.00049 24.5864 2.21488 24.5864 3.71291V4.41417"
                                                        stroke="white" stroke-width="1.44663" stroke-linecap="round"/>
                                                    <path
                                                        d="M27.4302 21.9625L27.784 22.5934L27.4302 21.9625ZM30.5655 18.8272L31.1964 19.181L30.5655 18.8272ZM32.5508 21.9625L33.0766 21.4659C33.2825 21.6838 33.3325 22.0061 33.2025 22.2762C33.0725 22.5464 32.7894 22.7083 32.4906 22.6834L32.5508 21.9625ZM15.2927 14.8446H16.016C16.016 18.949 19.3432 22.2762 23.4476 22.2762V22.9995V23.7228C18.5443 23.7228 14.5694 19.7479 14.5694 14.8446H15.2927ZM31.6025 14.8446H30.8792C30.8792 10.7403 27.5519 7.41301 23.4476 7.41301V6.6897V5.96638C28.3509 5.96638 32.3258 9.9413 32.3258 14.8446H31.6025ZM23.4476 6.6897V7.41301C19.3432 7.41301 16.016 10.7403 16.016 14.8446H15.2927H14.5694C14.5694 9.9413 18.5443 5.96638 23.4476 5.96638V6.6897ZM23.4476 22.9995V22.2762C24.7669 22.2762 26.0039 21.933 27.0765 21.3316L27.4302 21.9625L27.784 22.5934C26.5009 23.3129 25.021 23.7228 23.4476 23.7228V22.9995ZM30.5655 18.8272L29.9346 18.4735C30.536 17.4009 30.8792 16.1639 30.8792 14.8446H31.6025H32.3258C32.3258 16.4181 31.9159 17.8979 31.1964 19.181L30.5655 18.8272ZM27.4302 21.9625L27.0765 21.3316C27.2887 21.2126 27.5515 21.1653 27.7424 21.1391C27.9621 21.109 28.2179 21.0919 28.4855 21.0827C29.0226 21.0644 29.6621 21.0768 30.2673 21.1003C30.8752 21.1239 31.4605 21.1592 31.893 21.1886C32.1095 21.2033 32.2883 21.2165 32.4133 21.2261C32.4758 21.2309 32.5248 21.2348 32.5584 21.2375C32.5752 21.2388 32.5882 21.2399 32.597 21.2406C32.6014 21.241 32.6048 21.2412 32.6072 21.2414C32.6083 21.2415 32.6092 21.2416 32.6099 21.2416C32.6102 21.2417 32.6104 21.2417 32.6106 21.2417C32.6107 21.2417 32.6108 21.2417 32.6108 21.2417C32.6109 21.2417 32.6109 21.2417 32.5508 21.9625C32.4906 22.6834 32.4906 22.6834 32.4906 22.6834C32.4906 22.6834 32.4906 22.6834 32.4906 22.6833C32.4905 22.6833 32.4903 22.6833 32.4901 22.6833C32.4896 22.6833 32.4889 22.6832 32.4879 22.6831C32.486 22.683 32.483 22.6827 32.4789 22.6824C32.4709 22.6817 32.4587 22.6807 32.4427 22.6795C32.4107 22.6769 32.3633 22.6731 32.3027 22.6685C32.1813 22.6592 32.0067 22.6463 31.795 22.6319C31.371 22.6031 30.8006 22.5687 30.2112 22.5458C29.6192 22.5228 29.0201 22.512 28.5348 22.5285C28.2913 22.5368 28.09 22.5516 27.939 22.5724C27.7591 22.597 27.7376 22.6195 27.784 22.5934L27.4302 21.9625ZM32.5508 21.9625C32.025 22.4592 32.0249 22.4592 32.0248 22.4591C32.0248 22.459 32.0247 22.459 32.0246 22.4589C32.0245 22.4587 32.0243 22.4586 32.0241 22.4583C32.0237 22.4579 32.0231 22.4573 32.0224 22.4566C32.021 22.4551 32.0191 22.453 32.0166 22.4503C32.0116 22.445 32.0044 22.4373 31.9952 22.4275C31.9769 22.4078 31.9506 22.3794 31.9175 22.3433C31.8513 22.2711 31.7577 22.1679 31.6469 22.0423C31.4262 21.792 31.1328 21.448 30.8489 21.0797C30.5695 20.7172 30.2795 20.306 30.0809 19.9251C29.9826 19.7365 29.8898 19.5237 29.8409 19.3078C29.7957 19.108 29.7605 18.784 29.9346 18.4735L30.5655 18.8272L31.1964 19.181C31.2796 19.0326 31.2383 18.9282 31.2519 18.9885C31.2619 19.0327 31.293 19.1207 31.3637 19.2564C31.5033 19.5242 31.7323 19.8562 31.9946 20.1965C32.2525 20.531 32.5236 20.8492 32.7319 21.0854C32.8357 21.2031 32.9228 21.2992 32.9837 21.3656C33.0141 21.3987 33.0378 21.4243 33.0537 21.4414C33.0617 21.45 33.0677 21.4564 33.0715 21.4605C33.0735 21.4625 33.0749 21.464 33.0757 21.4649C33.0762 21.4654 33.0764 21.4657 33.0766 21.4658C33.0767 21.4659 33.0767 21.466 33.0767 21.466C33.0767 21.466 33.0767 21.466 33.0767 21.466C33.0767 21.4659 33.0766 21.4659 32.5508 21.9625Z"
                                                        fill="#F2B035"/>
                                                </svg>


                                            </div>
                                            <div class="text-area">
                                                <div class="card-title">Mentoring session</div>
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
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M10 0.625C15.1777 0.625 19.375 4.82233 19.375 10C19.375 15.1777 15.1777 19.375 10 19.375C4.82233 19.375 0.625 15.1777 0.625 10C0.625 4.82233 4.82233 0.625 10 0.625Z"
                                                        stroke="#ffffff" stroke-width="1.25" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                    <path d="M10.364 5.09277V10.5473L14.0004 12.3655" stroke="#F2B035"
                                                          stroke-width="1.13636" stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>


                                            </div>
                                            <div class="text-area">
                                                <div class="card-title">Completion rate</div>
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

            <div class="card-body">
                <ul class="nav nav-pills bg-nav-pills nav-justified mb-3 w-lg-50 w-100" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#profiles" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active"
                           aria-selected="true" role="tab">
                            Pending Requests
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#performance" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0"
                           aria-selected="false" role="tab" tabindex="-1">
                            Approved Requests
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#leaderboard" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0"
                           aria-selected="false" role="tab" tabindex="-1">
                            Rejected Requests
                        </a>
                    </li>
                </ul>

                <div class="tab-content">

                    {{-- Pending Requests --}}
                    <div class="tab-pane p-4 active show" id="profiles" role="tabpanel">
                        <table id="pendingTable" class="display w-100">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mentee</th>
                                <th>Master Class</th>
                                <th>Sessions</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pendingRequests as $req)
                                <tr>
                                    <td>{{ $req->id }}</td>
                                    <td>{{ $req->mentee->name ?? '-' }}</td>
                                    <td>{{ $req->masterClass->title ?? '-' }}</td>
                                    <td>
                                        @php
                                            $sessions = is_array($req->sessions)
                                                ? $req->sessions
                                                : json_decode($req->sessions, true);
                                            foreach ($req->sessions as $sessionId)
                                                {
                                                     $session = MasterClassSession::find($sessionId);
                                                     echo '<ul>';
                                                     echo '<li>'.$session->title.'</li>';
                                                     echo '</ul>';
                                                }

                                        @endphp
                                    </td>
                                    <td><span class="badge bg-warning">{{ ucfirst($req->status) }}</span></td>
                                    <td>
                                        <button class="btn btn-success btn-sm action-btn" data-id="{{ $req->id }}"
                                                data-action="accepted">Approve
                                        </button>
                                        <button class="btn btn-danger btn-sm action-btn" data-id="{{ $req->id }}"
                                                data-action="rejected">Reject
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Accepted Requests --}}
                    <div class="tab-pane p-4" id="performance" role="tabpanel">
                        <table id="acceptedTable" class="display w-100">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mentee</th>
                                <th>Master Class</th>
                                <th>Sessions</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($acceptedRequests as $req)
                                <tr>
                                    <td>{{ $req->id }}</td>
                                    <td>{{ $req->mentee->name ?? '-' }}</td>
                                    <td>{{ $req->masterClass->title ?? '-' }}</td>
                                    <td>
                                        @php
                                            $sessions = is_array($req->sessions)
                                                ? $req->sessions
                                                : json_decode($req->sessions, true);
                                            foreach ($req->sessions as $sessionId)
                                                {
                                                     $session = MasterClassSession::find($sessionId);
                                                     echo '<ul>';
                                                     echo '<li>'.$session->title.'</li>';
                                                     echo '</ul>';
                                                }

                                        @endphp
                                    </td>
                                    <td><span class="badge bg-success">{{ ucfirst($req->status) }}</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Rejected Requests --}}
                    <div class="tab-pane p-4" id="leaderboard" role="tabpanel">
                        <table id="rejectedTable" class="display w-100">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mentee</th>
                                <th>Master Class</th>
                                <th>Sessions</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rejectedRequests as $req)
                                <tr>
                                    <td>{{ $req->id }}</td>
                                    <td>{{ $req->mentee->name ?? '-' }}</td>
                                    <td>{{ $req->masterClass->title ?? '-' }}</td>
                                    <td>
                                        @php
                                            $sessions = is_array($req->sessions)
                                                ? $req->sessions
                                                : json_decode($req->sessions, true);
                                            foreach ($req->sessions as $sessionId)
                                                {
                                                     $session = MasterClassSession::find($sessionId);
                                                     echo $session->title;
                                                }

                                        @endphp
                                    </td>
                                    <td><span class="badge bg-danger">{{ ucfirst($req->status) }}</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>


            </div>


        </div>
    </div>

@endsection

@section('javascripts')
    <script>
        $(document).ready(function () {
            // Initialize all tables
            $('#pendingTable, #acceptedTable, #rejectedTable').DataTable({
                pageLength: 5,
                language: {
                    search: "Search Requests:",
                    lengthMenu: "Show _MENU_ entries"
                }
            });

            // Approve / Reject Actions
            $(document).on('click', '.action-btn', function () {
                let id = $(this).data('id');
                let action = $(this).data('action');

                if (!confirm(`Are you sure you want to ${action} this request?`)) return;

                $.ajax({
                    url: "{{ route('frontend.mentor.request.action') }}",
                    method: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id,
                        status: action
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Something went wrong.');
                    }
                });
            });
        });
    </script>

@endsection
