@extends('frontend.layouts.app')

@section('stylesheets')

    <style>
        .accordion {
            border-radius: 8px;
            box-shadow: 0 1px 10px #d0d6f9;
            margin-bottom: 18px;
            background: white;
        }

        .accordion-header {
            background: white;
            cursor: pointer;
            padding: 14px 20px;
            font-weight: 600;
            font-size: 20px;
            border-bottom: 1px solid #ebeef3;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }

        .accordion-header:hover {
            background: #f5f7ff;
        }

        .accordion-content {
            padding: 16px 20px;
            display: none;
            border-top: 1px solid #ebeef3;
        }

        .accordion-content.active {
            display: block;
        }

        /* Session progress table */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            margin: 16px 0 24px;
        }

        th, td {
            padding: 12px 10px;
            text-align: left;
            font-size: 15px;
            color: #444;
        }

        th {
            font-weight: 700;
            border-bottom: 2px solid #d0d6f9;
        }

        tr {
            background: #f7f9ff;
            border-radius: 8px;
        }

        tr:hover {
            background: #e3ebff;
        }

        .status-chip {
            display: inline-block;
            padding: 5px 16px;
            border-radius: 24px;
            font-weight: 600;
            font-size: 14px;
            color: white;
        }

        .status-done {
            background-color: #37b24d; /* Green */
        }

        .status-pending {
            background-color: #f59f00; /* Amber */
        }

        /* Assignments Table */
        .assignment-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .assignment-table th, .assignment-table td {
            border: 1px solid #d0d6f9;
            padding: 8px 12px;
            font-size: 14px;
            vertical-align: middle;
            color: #444;
        }

        .assignment-table th {
            background: #e7e9fc;
            font-weight: 600;
        }

        .btn-download, .btn-submitted {
            background-color: #6c36d9;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 6px 18px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }

        .btn-download:hover {
            background-color: #5328a1;
        }

        .btn-submitted {
            background-color: #4caf50;
        }

        /* Icons - Replace with your SVG icons or font icons */
        .icon-file {
            font-size: 20px;
            color: #6c36d9;
        }

        .icon-calendar {
            font-size: 16px;
            color: #6c36d9;
            margin-left: 6px;
        }
    </style>
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
                                                        fill="#ffffff"></path>
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
                                                            stroke-width="1.07143"></circle>
                                                    <path
                                                        d="M7.91917 18.9062C8.20283 18.8221 8.36461 18.524 8.28051 18.2403C8.19641 17.9566 7.89829 17.7948 7.61462 17.8789L7.91917 18.9062ZM10.5576 11.9614H10.0218V14.4883H10.5576H11.0933V11.9614H10.5576ZM2.63477 14.5863H3.17048V11.9614H2.63477H2.09905V14.5863H2.63477ZM7.74308 18.3996L7.89535 18.9132L7.91917 18.9062L7.76689 18.3926L7.61462 17.8789L7.59081 17.886L7.74308 18.3996ZM2.63477 14.5863H2.09905C2.09905 17.0789 4.11964 19.0994 6.61217 19.0994V18.5637V18.028C4.71137 18.028 3.17048 16.4871 3.17048 14.5863H2.63477ZM6.61217 18.5637V19.0994C7.04663 19.0994 7.47881 19.0367 7.89535 18.9132L7.74308 18.3996L7.59081 17.886C7.27313 17.9802 6.94351 18.028 6.61217 18.028V18.5637ZM10.5576 14.4883H10.0218C10.0218 15.5873 9.53963 16.6308 8.70273 17.3431L9.04993 17.751L9.39712 18.159C10.4732 17.2432 11.0933 15.9014 11.0933 14.4883H10.5576ZM6.59616 8V8.53571C8.48812 8.53571 10.0218 10.0694 10.0218 11.9614H10.5576H11.0933C11.0933 9.47771 9.07985 7.46429 6.59616 7.46429V8ZM6.59616 8V7.46429C4.11248 7.46429 2.09905 9.47771 2.09905 11.9614H2.63477H3.17048C3.17048 10.0694 4.70421 8.53571 6.59616 8.53571V8Z"
                                                        fill="#ffffff"></path>
                                                    <circle cx="2.40791" cy="2.40791" r="2.40791"
                                                            transform="matrix(-1 0 0 1 16.334 1.71484)" stroke="#ffffff"
                                                            stroke-width="1.07143"></circle>
                                                    <path
                                                        d="M12.6043 18.9062C12.3206 18.8221 12.1588 18.524 12.2429 18.2403C12.327 17.9566 12.6252 17.7948 12.9088 17.8789L12.6043 18.9062ZM9.96587 11.9614H10.5016V14.4883H9.96587H9.43016V11.9614H9.96587ZM17.8887 14.5863H17.353V11.9614H17.8887H18.4244V14.5863H17.8887ZM12.7804 18.3996L12.6281 18.9132L12.6043 18.9062L12.7565 18.3926L12.9088 17.8789L12.9326 17.886L12.7804 18.3996ZM17.8887 14.5863H18.4244C18.4244 17.0789 16.4038 19.0994 13.9113 19.0994V18.5637V18.028C15.8121 18.028 17.353 16.4871 17.353 14.5863H17.8887ZM13.9113 18.5637V19.0994C13.4768 19.0994 13.0446 19.0367 12.6281 18.9132L12.7804 18.3996L12.9326 17.886C13.2503 17.9802 13.5799 18.028 13.9113 18.028V18.5637ZM9.96587 14.4883H10.5016C10.5016 15.5873 10.9838 16.6308 11.8207 17.3431L11.4735 17.751L11.1263 18.159C10.0502 17.2432 9.43016 15.9014 9.43016 14.4883H9.96587ZM13.9273 8V8.53571C12.0353 8.53571 10.5016 10.0694 10.5016 11.9614H9.96587H9.43016C9.43016 9.47771 11.4436 7.46429 13.9273 7.46429V8ZM13.9273 8V7.46429C16.411 7.46429 18.4244 9.47771 18.4244 11.9614H17.8887H17.353C17.353 10.0694 15.8192 8.53571 13.9273 8.53571V8Z"
                                                        fill="#ffffff"></path>
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
                                                        stroke="#ffffff" stroke-width="1.25"
                                                        stroke-linecap="round"></path>
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
                                                        fill="#ffffff"></path>
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


            <div id="masterclass-accordion-container">
                <!-- Repeat this block per masterclass -->


                <!-- Masterclass Card -->
                @foreach($mentee_orders as $order)

                    <div class="accordion">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            Masterclass: {{ $order->masterClass->title }}
                            <span>+</span>
                        </div>
                        <div class="accordion-content">
                            <h3>Session Progress</h3>

                            <!-- Sessions Accordion -->
                            <div id="session-accordion-container">


                                @if($order->order_type == 'master_class')
                                    @foreach($order->masterClass->sessions as $sessions)
                                        @php
                                            $isPast = \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($sessions->start_date_time));
                                            $shortDescription = \Illuminate\Support\Str::words($sessions->session_description, 50, '...');
                                        @endphp
                                            <!-- Repeat this block per session -->
                                        <div class="accordion" style="box-shadow:none; margin-bottom:10px;">
                                            <div class="accordion-header" onclick="toggleAccordion(this)"
                                                 style="font-size: 18px; font-weight:600;">
                                                {{ $sessions->title }}
                                                - {{ \Carbon\Carbon::parse($sessions->start_date_time)->format('d M Y') }}
                                                <span>+</span>
                                            </div>
                                            <div class="accordion-content">
                                                <table>
                                                    <thead>
                                                    <tr>
                                                        <th>Session Name</th>
                                                        <th>Scheduled Date</th>
                                                        <th>Status</th>
                                                        <th>Session Summary</th>
                                                        <th>Assignments Completion</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{ $sessions->title }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($sessions->start_date_time)->format('d M Y') }}
                                                            <span class="icon-calendar">📅</span></td>
                                                        <td>
                                                            @if($isPast)
                                                                <span class="status-chip status-done">Done</span>
                                                            @else
                                                                <span class="status-chip status-pending">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="icon-file" title="Session Summary"></span>
                                                            <span
                                                                class="description-text">{{ $shortDescription }}</span>
                                                            @if(\Illuminate\Support\Str::wordCount($sessions->session_description) > 50)
                                                                <a href="javascript:void(0);" class="read-more"
                                                                   data-full="{{ $sessions->session_description }}">Read
                                                                    more</a>
                                                            @endif
                                                        </td>
                                                        <td>1/3 completed</td>
                                                    </tr>
                                                    </tbody>
                                                </table>



                                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                                    <h4 style="margin: 0;">Assignments</h4>

                                                    {{-- Organizer can add new assignment --}}
                                                    <button class="btn btn-outline-secondary add-assignment-btn"
                                                            data-order-id="{{ $order->id }}"
                                                            data-master-class-id="{{ $order->masterClass->id }}"
                                                            data-session-id="{{ $sessions->id }}">
                                                        Add Assignment
                                                    </button>

                                                    <input type="file" id="assignmentUploadInput" accept="application/pdf" style="display:none;">
                                                    <input type="file" id="reuploadAssignmentFile" accept="application/pdf" style="display:none;">
                                                </div>
                                                <table class="assignment-table">
                                                    <thead>
                                                    <tr>
                                                        <th>Assignment</th>
                                                        <th>Uploaded By</th>
                                                        <th>User File</th>
                                                        <th>Organizer File</th>
                                                        <th>Status</th>
                                                        <th>Last Action</th>
                                                        <th>Remarks</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $sessionAssignments = \App\Models\OrderAssignment::where('order_id', $order->id)
                                                            ->where('master_class_id', $order->masterClass->id)
                                                            ->where('session_id', $sessions->id)
                                                            ->orderByDesc('updated_at')
                                                            ->get();
                                                    @endphp

                                                    @forelse($sessionAssignments as $assignment)
                                                        <tr
                                                            @class([
                                                                'bg-warning-subtle' => $assignment->status === 'redo',
                                                                'bg-light' => $assignment->status === 'assigned',
                                                            ])
                                                        >
                                                            <td>{{ $assignment->user_file_name ?? $assignment->organizer_file_name ?? 'Untitled Assignment' }}</td>

                                                            <td>{{ optional($assignment->uploader)->name ?? '—' }}</td>

                                                            {{-- User uploaded file --}}
                                                            <td>
                                                                @if($assignment->user_file_path)
                                                                    <a href="{{ $assignment->user_file_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-download"></i> User File
                                                                    </a>
                                                                    <div style="font-size:12px;">{{ $assignment->readable_user_file_size }}</div>
                                                                @else
                                                                    —
                                                                @endif
                                                            </td>

                                                            {{-- Organizer reupload (redo) file --}}
                                                            <td>
                                                                @if($assignment->organizer_file_path)
                                                                    <a href="{{ $assignment->organizer_file_url }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                                        <i class="fas fa-download"></i> Mentor File
                                                                    </a>
                                                                    <div style="font-size:12px;">{{ $assignment->readable_organizer_file_size }}</div>
                                                                @else
                                                                    —
                                                                @endif
                                                            </td>

                                                            {{-- Status --}}
                                                            <td>
                                                                <span class="status-chip status-secondary text-secondary">{{ ucfirst($assignment->status) }}</span>
                                                            </td>

                                                            {{-- Date info --}}
                                                            <td>
                                                                @if($assignment->status === 'submitted')
                                                                    {{ optional($assignment->final_submitted_at)->format('d M Y') ?? '—' }}
                                                                @elseif($assignment->status === 'under_review')
                                                                    {{ optional($assignment->organizer_reviewed_at)->format('d M Y') ?? '—' }}
                                                                @elseif($assignment->status === 'uploaded')
                                                                    {{ optional($assignment->user_uploaded_at)->format('d M Y') ?? '—' }}
                                                                @else
                                                                    —
                                                                @endif
                                                            </td>

                                                            <td>{{ $assignment->remarks ?? '—' }}</td>

                                                            {{-- Actions --}}
                                                            <td style="text-align:center;">
                                                                {{-- Organizer actions --}}
                                                                @if($assignment->status != 'submitted')
                                                                <button class="btn btn-sm btn-success mark-submitted-btn"
                                                                        data-assignment-id="{{ $assignment->id }}"
                                                                        data-order-id="{{ $assignment->order_id }}"
                                                                        data-master-class-id="{{ $assignment->master_class_id }}"
                                                                        data-session-id="{{ $assignment->session_id }}">
                                                                    <i class="fas fa-check"></i> Mark Submitted
                                                                </button>
                                                                <button class="btn btn-sm btn-warning request-redo-btn"
                                                                        data-assignment-id="{{ $assignment->id }}"
                                                                        data-order-id="{{ $assignment->order_id }}"
                                                                        data-master-class-id="{{ $assignment->master_class_id }}"
                                                                        data-session-id="{{ $assignment->session_id }}">
                                                                    <i class="fas fa-undo"></i> Request Redo
                                                                </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="8" style="text-align:center; color:#888;">
                                                                No assignments yet.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                        </div>
                    </div>
                @endforeach

                <!-- You can replicate above Masterclass block multiple times -->

            </div>


        </div>


        @endsection

        @section('javascripts')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                function toggleAccordion(header) {
                    const content = header.nextElementSibling;
                    if (content.classList.contains('active')) {
                        content.classList.remove('active');
                        header.querySelector('span').textContent = '+';
                    } else {
                        content.classList.add('active');
                        header.querySelector('span').textContent = '−';
                    }
                }


                $(document).on('click', '.add-assignment-btn', function () {
                    // Capture IDs from the clicked button
                    const orderId = $(this).data('order-id');
                    const masterClassId = $(this).data('master-class-id');
                    const sessionId = $(this).data('session-id');

                    console.log("Uploading for: ", {orderId, masterClassId, sessionId});

                    // Trigger file picker
                    $('#assignmentUploadInput').click();

                    // When a file is selected
                    $('#assignmentUploadInput').off('change').on('change', function (e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        // Validation
                        if (file.type !== "application/pdf") {
                            alert("Please upload a PDF file only.");
                            return;
                        }
                        if (file.size > 2 * 1024 * 1024) { // 2MB limit
                            alert("File must be less than 2MB.");
                            return;
                        }

                        // Prepare form data
                        const formData = new FormData();
                        formData.append('file', file);
                        formData.append('order_id', orderId);
                        formData.append('master_class_id', masterClassId);
                        formData.append('session_id', sessionId);
                        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                        // Upload via AJAX
                        $.ajax({
                            url: "{{ route('frontend.upload.assignment.organizer') }}", // define in routes/web.php
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            beforeSend: function () {
                                Swal.fire({
                                    title: "Uploading...",
                                    text: "Please wait while your assignment is being uploaded.",
                                    allowOutsideClick: false,
                                    didOpen: () => Swal.showLoading()
                                });
                            },
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Upload Complete',
                                    text: 'Your assignment has been uploaded successfully!',
                                    timer: 2000
                                });
                                // console.log(response);
                                location.reload();
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Upload Failed',
                                    text: xhr.responseJSON?.message || 'Something went wrong!'
                                });
                            }
                        });
                    });

                });



                $(document).on('click', '.reupload-assignment-btn', function () {
                    console.log('clicked');
                    const assignmentId = $(this).data('assignment-id');
                    const orderId = $(this).data('order-id');
                    const masterClassId = $(this).data('master-class-id');
                    const sessionId = $(this).data('session-id');

                    Swal.fire({
                        title: 'Reupload Assignment',
                        html: `
            <div style="text-align:left;">
                <label for="reuploadFile" style="font-weight:600;">Select New PDF File:</label><br>
                <input type="file" id="reuploadFile" accept="application/pdf" class="swal2-input" style="width:100%;"><br>
                <label for="remarks" style="font-weight:600;">Remarks (Optional):</label><br>
                <textarea id="remarks" class="swal2-textarea" placeholder="Enter remarks for mentor..." rows="3"></textarea>
            </div>
        `,
                        showCancelButton: true,
                        confirmButtonText: 'Submit Reupload',
                        cancelButtonText: 'Cancel',
                        focusConfirm: false,
                        preConfirm: () => {
                            const file = $('#reuploadFile')[0].files[0];
                            const remarks = $('#remarks').val();

                            if (!file) {
                                Swal.showValidationMessage('Please select a PDF file to upload.');
                                return false;
                            }
                            if (file.type !== "application/pdf") {
                                Swal.showValidationMessage('Only PDF files are allowed.');
                                return false;
                            }
                            if (file.size > 2 * 1024 * 1024) {
                                Swal.showValidationMessage('File must be less than 2MB.');
                                return false;
                            }

                            return {file, remarks};
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const {file, remarks} = result.value;
                            const formData = new FormData();
                            formData.append('assignment_id', assignmentId);
                            formData.append('order_id', orderId);
                            formData.append('master_class_id', masterClassId);
                            formData.append('session_id', sessionId);
                            formData.append('remarks', remarks);
                            formData.append('file', file);
                            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                            $.ajax({
                                url: "{{ route('frontend.reupload.assignment') }}",
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function () {
                                    Swal.fire({
                                        title: "Reuploading...",
                                        text: "Please wait while your assignment is being updated.",
                                        allowOutsideClick: false,
                                        didOpen: () => Swal.showLoading()
                                    });
                                },
                                success: function (response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Reupload Complete',
                                        text: 'Your assignment has been successfully reuploaded!',
                                        timer: 2000
                                    });
                                    // Optional: refresh or reload assignments
                                    location.reload();
                                },
                                error: function (xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Upload Failed',
                                        text: xhr.responseJSON?.message || 'Something went wrong!'
                                    });
                                }
                            });
                        }
                    });
                });


                $(document).on('click', '.request-redo-btn', function () {
                    console.log('clicked');

                    const assignmentId = $(this).data('assignment-id');
                    const orderId = $(this).data('order-id');
                    const masterClassId = $(this).data('master-class-id');
                    const sessionId = $(this).data('session-id');

                    Swal.fire({
                        title: 'Reupload Assignment',
                        html: `
            <div style="text-align:left;">
                <label for="reuploadFile" style="font-weight:600;">Select New PDF File (Optional):</label><br>
                <input type="file" id="reuploadFile" accept="application/pdf" class="form-control" style="width:100%;"><br>

                <label for="remarks" style="font-weight:600;">Remarks </label><br>
                <textarea name="remarks" id="remarks" class="form-control" placeholder="Enter remarks for mentor..." rows="3"></textarea><br>

                <label for="progress_status" style="font-weight:600;">Select Status <span style="color:red;">*</span></label><br>
                <select class="form-select" name="status" id="progress_status">
                    <option value="">Select Status</option>
                    <option value="assigned">Assigned</option>
                    <option value="uploaded">Uploaded</option>
                    <option value="under_review">Under Review</option>
                    <option value="redo">Redo</option>
                    <option value="submitted">Submitted</option>
                </select>
            </div>
        `,
                        showCancelButton: true,
                        confirmButtonText: 'Submit Reupload',
                        cancelButtonText: 'Cancel',
                        focusConfirm: false,
                        preConfirm: () => {
                            const file = $('#reuploadFile')[0].files[0];
                            const remarks = $('#remarks').val().trim();
                            const progress_status = $('#progress_status').val();

                            /*if (!remarks) {
                                Swal.showValidationMessage('Remarks are required.');
                                return false;
                            }*/

                            if (!progress_status) {
                                Swal.showValidationMessage('Please select a status.');
                                return false;
                            }

                            if (file) {
                                if (file.type !== "application/pdf") {
                                    Swal.showValidationMessage('Only PDF files are allowed.');
                                    return false;
                                }
                                if (file.size > 2 * 1024 * 1024) {
                                    Swal.showValidationMessage('File must be less than 2MB.');
                                    return false;
                                }
                            }

                            return { file, remarks, progress_status };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const { file, remarks, progress_status } = result.value;

                            const formData = new FormData();
                            formData.append('assignment_id', assignmentId);
                            formData.append('order_id', orderId);
                            formData.append('master_class_id', masterClassId);
                            formData.append('session_id', sessionId);
                            formData.append('remarks', remarks);
                            formData.append('progress_status', progress_status);
                            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                            if (file) {
                                formData.append('file', file);
                            }

                            $.ajax({
                                url: "{{ route('frontend.reupload.assignment.organizer') }}",
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function () {
                                    Swal.fire({
                                        title: "Reuploading...",
                                        text: "Please wait while your assignment is being updated.",
                                        allowOutsideClick: false,
                                        didOpen: () => Swal.showLoading()
                                    });
                                },
                                success: function (response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Reupload Complete',
                                        text: 'Your assignment has been successfully reuploaded!',
                                        timer: 2000
                                    });
                                    location.reload();
                                },
                                error: function (xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Upload Failed',
                                        text: xhr.responseJSON?.message || 'Something went wrong!'
                                    });
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.mark-submitted-btn', function () {
                    const assignmentId = $(this).data('assignment-id');
                    const orderId = $(this).data('order-id');
                    const masterClassId = $(this).data('master-class-id');
                    const sessionId = $(this).data('session-id');

                    Swal.fire({
                        title: 'Mark Assignment as Submitted?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Submit it',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('frontend.user.mark.submitted') }}",
                                type: 'POST',
                                data: {
                                    assignment_id: assignmentId,
                                    order_id: orderId,
                                    master_class_id: masterClassId,
                                    session_id: sessionId,
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Marked Submitted!',
                                        text: response.message,
                                        timer: 2000
                                    });
                                    location.reload();
                                },
                                error: function (xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed!',
                                        text: xhr.responseJSON?.message || 'Something went wrong!'
                                    });
                                }
                            });
                        }
                    });
                });



            </script>
@endsection
