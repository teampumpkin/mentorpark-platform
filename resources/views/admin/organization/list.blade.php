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
                        <a href="{{ route('organization.create') }}" class="btn btn-outline-primary rounded-pill">Add Organization</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-secondary alert-dismissible d-flex align-items-center border-2 border border-secondary"
                             role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            <iconify-icon icon="solar:bicycling-round-bold-duotone"
                                          class="fs-20 me-1"></iconify-icon>
                            <div class="lh-1"><strong> {{ session('success') }} </strong></div>
                        </div>
                    @endif

                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Industry</th>
                            <th>Active</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($list as $data)
                            <tr>
                                <td>
                                    <a href="{{ route('organization.show', $data->id) }}">
                                        @if($data->logo_path)
                                            <img src="{{ asset('storage/' . $data->logo_path) }}" alt="Logo" width="40">
                                        @else
                                            N/A
                                        @endif
                                    </a>
                                </td>
                                <td><a href="{{ route('organization.show', $data->id) }}">{{ $data->name }}</a></td>
                                <td>{{ $data->email ?? '-' }}</td>
                                <td>{{ $data->phone ?? '-' }}</td>
                                <td>{{ $data->countryRel->name ?? '-' }}</td>
                                <td>{{ $data->stateRel->name ?? '-' }}</td>
                                <td>{{ $data->cityRel->name ?? '-' }}</td>
                                <td>{{ $data->industryType->name ?? '-' }}</td>
                                <td>
                                    @if($data->is_active)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-danger">No</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('organization.edit', $data->id) }}" class="btn btn-info btn-sm">
                                        <i data-lucide="pencil"></i>
                                    </a>
                                    <form action="{{ route('organization.destroy', $data->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this organization?')">
                                            <i data-lucide="trash"></i>
                                        </button>
                                    </form>
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
