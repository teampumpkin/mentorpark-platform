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
                        <a href="{{ route('master.goals.create') }}" class="btn btn-outline-primary rounded-pill">Add Goal</a>
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
                            <th></th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach ($list as $data)
                            <tr>
                                <td> {{ $data->name }}</td>
                                <td>
                                    <a href="{{ route('master.goals.edit', $data) }}" class="btn btn-info btn-icon">
                                        <i data-lucide="pencil"></i>
                                    </a>
                                    <form action="{{ route('master.goals.destroy', $data->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-info btn-icon btn btn-soft-dark" onclick="return confirm('Are you sure you want to delete?')">
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
