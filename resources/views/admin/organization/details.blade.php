<x-app-layout>
    <x-slot name="header">
        <div class="page-title-head d-flex align-items-center gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-bold mb-0">{{ $breadcrumb }}</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0 fs-13">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $breadcrumb }}</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <!-- Page Content Start -->
    <div class="row">
        <!-- Left Column: Organization Overview -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex flex-wrap align-items-center gap-2">
                    <h4 class="header-title me-auto">Organization Overview</h4>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $organization->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong>
                        @if($organization->email)
                            <a href="mailto:{{ $organization->email }}">{{ $organization->email }}</a>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                    <p><strong>Phone:</strong> {{ $organization->phone ?? 'N/A' }}</p>
                    <p><strong>Website:</strong>
                        @if($organization->website)
                            <a href="{{ $organization->website }}" target="_blank">{{ $organization->website }}</a>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                    <p><strong>Industry Type:</strong> {{ $organization->industryType->name ?? 'N/A' }}</p>
                    <p><strong>Founded:</strong> {{ $organization->founded_date ?? 'N/A' }}</p>
                    <p><strong>Registration No:</strong> {{ $organization->registration_number ?? 'N/A' }}</p>
                    <p><strong>Status:</strong>
                        @if($organization->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card shadow-sm">
                <div class="card-header d-flex flex-wrap align-items-center gap-2">
                    <h4 class="header-title me-auto">Associated Users</h4>
                </div>
                <div class="card-body">
                    @if($organization->userInformation && $organization->userInformation->count())
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Job Title</th>
                                    <th>Experience</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($organization->userInformation as $user)
                                    <tr>
                                        <td><a href="{{ route('users.show', $user->user->id) }}" class="font-extrabold">{{ $user->user->name }}</a></td>
                                        <td>{{ $user->user->email ?? '-' }}</td>
                                        <td>{{ $user->job_title ?? '-' }}</td>
                                        <td>{{ $user->total_experience ?? '-' }} yrs</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No users linked with this organization.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Logo & Address -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex flex-wrap align-items-center gap-2">
                    <h4 class="header-title me-auto">Logo</h4>
                </div>
                <div class="card-body text-center">
                    @if($organization->logo_path)
                        <img src="{{ asset('storage/' . $organization->logo_path) }}" alt="Logo" class="img-fluid" style="max-height: 120px;">
                    @else
                        <p class="text-muted">No logo uploaded</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header d-flex flex-wrap align-items-center gap-2">
                    <h4 class="header-title me-auto">Address</h4>
                </div>
                <div class="card-body">
                    <p>
                        {{ $organization->address ?? '' }}<br>
                        {{ $organization->cityRel->name ?? '' }} {{ $organization->postal_code ? '-' . $organization->postal_code : '' }}<br>
                        {{ $organization->stateRel->name ?? '' }} {{ $organization->countryRel->name ?? '' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content End -->
</x-app-layout>
