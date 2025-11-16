<x-app-layout>
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

    <!-- Page Content Start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('users.create') }}" class="btn btn-outline-primary rounded-pill">Add User</a>
                        </div>
                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>User Type</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Experience</th>
                                <th>Designation</th>
                                <th>Skills</th>
                                <th></th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td> <a href="{{ route('users.show', $user) }}" class="font-extrabold">{{ $user->name }}</a> </td>
                                    <td>
                                        @if(!empty($user->information?->user_type))
                                            @foreach($user->information->user_type as $type)
                                                <span class="badge badge-soft-secondary">{{ $type }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile ?? 'N/A' }}</td>
                                    <td>{{ $user->information?->total_experience ?? 'N/A' }}</td>
                                    <td>{{ $user->information?->job_title ?? 'N/A' }}</td>
                                    <td>
                                        @if(!empty($user->skills))
                                            @foreach($user->skills as $skill)
                                                <span class="badge badge-soft-success">{{ $skill->name }}</span> <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-info btn-icon">
                                            <i data-lucide="pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- Page Content End -->


</x-app-layout>
