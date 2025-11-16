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
                        <a href="{{ route('roles.create') }}" class="btn btn-outline-primary rounded-pill">Add Roles</a>
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
                            <th>Name</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @foreach($role->permissions as $perm)
                                        <span class="badge bg-info">{{ $perm->name }}</span>
                                    @endforeach
                                </td>
                                <td>

                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-info btn-sm">
                                        <i data-lucide="pencil"></i>
                                    </a>
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this Role?')">
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
